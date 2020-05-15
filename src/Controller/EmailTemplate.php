<?php

namespace Triangle\Controller;

!defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\View;
use Triangle\Wordpress\Action;
use Triangle\Wordpress\Email;
use Triangle\Wordpress\Shortcode;

class EmailTemplate extends Base {

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);
        $this->loadModel('EmailTemplate');

        /** @backend - Eneque scripts */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('admin_enqueue_scripts');
        $action->setCallback('backend_enequeue');
        $action->setAcceptedArgs(1);
        $this->hooks[] = $action;

        /** @backend @emailTemplate - Setup builder,editor script */
        $action = clone $action;
        $action->setHook('edit_form_after_title');
        $action->setCallback('edit_emailtemplate');
        $action->setAcceptedArgs(0);
        $this->hooks[] = $action;

        /** @frontend - Create custom page template for customizer */
        $action = clone $action;
        $action->setHook('template_include');
        $action->setCallback('customizer_custom_page');
        $action->setAcceptedArgs(1);
        $action->setPriority(999);
        $this->hooks[] = $action;

        /** @backend @emailTemplate - Setup editor script */
        $shortcode = new Shortcode();
        $shortcode->setComponent($this);
        $shortcode->setHook('triangle_send');
        $shortcode->setCallback('shortcode_send');
        $shortcode->setAcceptedArgs(2);
        $this->hooks[] = $shortcode;
    }

    /**
     * Create custom page for customizer and template
     */
    public function customizer_custom_page($template){
        $default = ['post_id', 'triangle_customize'];
        $specs = $this->validateParams($_GET, $default);
        $user = $this->Service->User->get_current_user();
        $user = (isset($user->ID) && $user->ID) ? true :false;
        // TODO: set this as customizer preview and editor "is_customize_preview()"
        if($user && $specs && $_GET['triangle_customize'] == 'true') {
            $this->EmailTemplate->setID($_GET['post_id']);
            $post = $this->EmailTemplate->get_post();
            $post->template = $this->EmailTemplate->getMetas()['template_html'];
            $post->template->setArgs(['single' => true]);
            $post->template = $post->template->get_post_meta();
            ob_start();
                $view = new View($this->Plugin);
                $view->setTemplate('backend.customize');
                $view->addData(compact('post'));
                $view->setSections([
                    'EmailTemplate.backend.customize' => ['name' => 'Customize', 'active' => true]
                ]);
                $view->build();
            echo ob_get_clean(); return;
        } else {
            return $template;
        }
    }

    /**
     * Eneque scripts @backend
     * @return  void
     * @var     array   $hook_suffix     The current admin page
     */
    public function backend_enequeue($hook_suffix){
        $screen = unserialize(TRIANGLE_SCREEN);
        $requiredAssets = [];
        /** Load Assets Libraries for pages and sections */
        if (in_array($screen->pagenow, ['post.php', 'post-new.php'])){
            /** @emailtemplate @edit - @section codeeditor */
            if(isset($_GET['section']) && $_GET['section'] == 'codeeditor') {
                $requiredAssets = ['ace'];
                $this->Service->Asset->wp_enqueue_script('emailtemplate_codeeditor_js', 'backend/emailtemplate/edit-codeeditor.js', [], false, true);
            /** @emailtemplate @edit - @section builder */
            } else {
                $this->Service->Asset->wp_enqueue_media();
                $this->Service->Asset->wp_enqueue_script('emailtemplate_builder_js', 'backend/emailtemplate/edit-builder.js', [], false, true);
                $requiredAssets = ['wp-tinymce','colorpicker','confirm','muuri'];
            }
        }
        $this->backend_load_plugin_libraries([], [$this->EmailTemplate->getName()], $requiredAssets);
    }

    /**
     * Setup scripts and metabox
     * @backend - @emailtemplate
     * @return  void
     */
    public function edit_emailtemplate(){
        $screen = unserialize(TRIANGLE_SCREEN);
        if(isset($screen->post->post_type) && $screen->post->post_type==$this->EmailTemplate->getName()){
            /** Prepare Data */
            $this->EmailTemplate->setID($screen->post->ID);
            $screen->post->template = $this->EmailTemplate->getMetas()['template_html'];
            $screen->post->template->setArgs(['single' => true]);
            $screen->post->template = $screen->post->template->get_post_meta();
            $options = [ 'builder_codeeditor' => $this->Service->Option->get_option('triangle_builder_codeeditor') ];

            /** Load Sections */
            $activeSection = (!isset($_GET['section'])) ? 'builder' : $_GET['section'];
            $urlPreview = unserialize(TRIANGLE_PATH)['home_url'] . '?triangle_customize=true&post_id='. $screen->post->ID;
            $sections = array();
            $sections['EmailTemplate.edit-builder'] = ['name' => 'Builder', 'link' => 'builder'];
            if($options['builder_codeeditor']) $sections['EmailTemplate.edit-codeeditor'] = ['name' => 'Code editor', 'link' => 'codeeditor'];
            $sections['EmailTemplate.edit-preview'] = ['name' => 'Preview', 'link' => $urlPreview];
            $sections['EmailTemplate.edit-' . $activeSection]['active'] = true;

            /** Redirect if section is not loaded */
            if(!isset($sections['EmailTemplate.edit-' . $activeSection]['name'])){
                $path = array();
                $path['post'] = $screen->post->ID;
                $path['action'] = 'edit';
                $path['section'] = 'builder';
                $path = unserialize(TRIANGLE_PATH)['admin_url'] . 'post.php?' . http_build_query($path);
                $this->Service->Page->js_redirect($path);
            }

            /** Setup View */
            $view = new View($this->Plugin);
            $view->setTemplate('backend.box');
            $view->setOptions(['shortcode' => false]);
            $view->addData([
                'disableTab'    => 'true',
                'screen'        => $screen,
                'background'    => 'bg-wetasphalt',
                'options'       => [
                    'triangle_builder_inliner' => $this->Service->Option->get_option('triangle_builder_inliner')
                ],
                'template'      => $screen->post->template,
            ]);
            $view->setSections($sections);
            $view->build();
        }
    }

    /**
     * Send template email
     * @backend - @emailtemplate from [@contactPage]
     * @return  void
     */
    public function shortcode_send($atts, $content = null){
        /** Validate attributes */
        $default = ['field_template', 'field_users', 'field_from_name', 'field_from_email', 'field_email_subject'];
        if(!$this->validateParams($atts, $default)) { echo ('Parameters did not match the specs!'); return; }

        /** Prepare Data */
        $this->EmailTemplate->setID($atts['field_template']);
        $this->EmailTemplate->getMetas()['template_standard']->setArgs(['single' => true]);
        $template = $this->EmailTemplate->getMetas()['template_standard']->get_post_meta();
        $template = isset($template) ? $template : '';
        $users = explode(',',$atts['field_users']);
        foreach($users as &$user) $user = $this->Service->User->get_user_by('ID', $user)->data->user_email;

        /** Send Email */
        $email = new Email();
        $headers = $email->getHeaders();
        $headers[] = 'From: '.$atts['field_from_name'].' <'.$atts['field_from_email'].'> ';
        $email->setHeaders($headers);
        $email->setTo($users);
        $email->setSubject($atts['field_email_subject']);
        $email->setMessage($template);
        $status = $email->send();

        /** Show status */
        ob_start();
            $view = new View($this->Plugin);
            $view->setTemplate('backend.blank');
            $view->addData([
                'status' => ($status) ? 'Email send successfully!' : 'Email failed to send, please turn off conflicting plugin and try again!',
            ]);
            $view->setSections(['Backend.contact.send-status' => ['name' => 'Send Notification']]);
            $view->build();
        echo ob_get_clean();
    }

}