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
use Triangle\Wordpress\Filter;
use Triangle\Wordpress\Shortcode;
use Triangle\Wordpress\Type;
use Triangle\Wordpress\User;

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

        /** @backend @emailTemplate - Setup editor script */
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

        /** @frontend - Change default single_emailtemplate */
        $filter = new Filter();
        $filter->setComponent($this);
        $filter->setHook('single_template');
        $filter->setCallback('cpt_single_template');
        $filter->setAcceptedArgs(1);
        $this->hooks[] = $filter;

        /** @frontend - Modify content for builder */
        $filter = clone $filter;
        $filter->setHook('the_content');
        $filter->setCallback('cpt_single_template_content');
        $filter->setAcceptedArgs(1);
        $this->hooks[] = $filter;

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
        if(is_customize_preview() && $specs && $_GET['triangle_customize'] == 'true') {
            $post = Type::get_post($_GET['post_id']);
            $post->template = get_post_meta($post->ID, 'template_html', true);
            ob_start();
                $view = new View($this->Plugin);
                $view->setTemplate('frontend.blank');
                $view->addData(compact('post'));
                $view->setSections([
                    'Template.frontend.customize' => ['name' => 'Builder', 'active' => true]
                ]);
                $view->build();
            echo ob_get_clean(); return;
        } else {
            return $template;
        }
    }

    /**
     * Modify single emailtemplate page
     */
    public function cpt_single_template_content($content){
        global $post;
        $this->loadModel('EmailTemplate');
        if( is_single() && $post->post_type == $this->EmailTemplate->getName() ) {
            $post->template = get_post_meta($post->ID, 'template_html', true);
            ob_start();
                $view = new View($this->Plugin);
                $view->setTemplate('frontend.editor');
                $view->addData(compact('post'));
                $view->setSections([
                    'EmailTemplate.frontend.builder' => ['name' => 'Builder', 'active' => true]
                ]);
                $view->build();
            $content .= ob_get_clean();
        }
        return $content;
    }

    /**
     * Create custom single template for Emailtemplate post type
     * @var     string  $template   Path to the template. See locate_template().
     * @var     string  $type       Sanitized filename without extension.
     * @var     array   $templates  A list of template candidates, in descending order of priority.
     * @return  array   Template
     */
    public function cpt_single_template($single){
        global $post;
        $path = unserialize(TRIANGLE_PATH);
        $this->loadModel('EmailTemplate');
        if ( $post->post_type == $this->EmailTemplate->getName() ) {
            $templatePath = $path['view_path'] . 'EmailTemplate/theme/single.php';
            return ( file_exists( $templatePath ) ) ? $templatePath : $single;
        }
        return $single;
    }

    /**
     * Eneque scripts @backend
     * @return  void
     * @var     array   $hook_suffix     The current admin page
     */
    public function backend_enequeue($hook_suffix){
        $screen = unserialize(TRIANGLE_SCREEN);
        $this->backend_load_plugin_libraries([],[$this->EmailTemplate->getName()]);
        if(isset($screen->post->post_type) && $screen->post->post_type==$this->EmailTemplate->getName()) {
            if($screen->pagenow=='post.php' || $screen->pagenow=='post-new.php'){
                $this->Service->Asset->wp_enqueue_script('triangle_emailtemplate_js', 'backend/emailtemplate/edit.js', [], false, true);
                $this->Service->Asset->wp_enqueue_script('juice_js', 'backend/juice.build.js', [], false, true);
            }
        }
    }

    /**
     * Setup scripts and metabox
     * @backend - @emailtemplate
     * @return  void
     */
    public function edit_emailtemplate(){
        $screen = unserialize(TRIANGLE_SCREEN);
        if(isset($screen->post->post_type) && $screen->post->post_type==$this->EmailTemplate->getName()){
            $this->Service->Asset->wp_enqueue_media();
            $view = new View($this->Plugin);
            $view->setTemplate('backend.box');
            $view->setOptions(['shortcode' => false]);
            $view->addData([
                'screen'        => $screen,
                'background'    => 'bg-wetasphalt',
                'options'       => [
                    'triangle_builder_inliner' => $this->Service->Option->get_option('triangle_builder_inliner')
                ],
            ]);
            $view->setSections([
                'EmailTemplate.edit-builder' => ['name' => 'Builder', 'active' => true],
                'EmailTemplate.edit-codeeditor' => ['name' => 'Code editor'],
                'EmailTemplate.edit-preview' => ['name' => 'Preview'],
            ]);
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
        $this->loadModel('EmailTemplate');
        $this->EmailTemplate->setID($atts['field_template']);
        $this->EmailTemplate->getMetas()['template_standard']->setSingle(true);
        $template = $this->EmailTemplate->getMetas()['template_standard']->get_post_meta();
        $template = isset($template) ? $template : '';
        $users = explode(',',$atts['field_users']);
        foreach($users as &$user) $user = User::get_user_by('ID', $user)->data->user_email;

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