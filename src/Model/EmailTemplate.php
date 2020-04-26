<?php

namespace Triangle\Model;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Model
 */

use Triangle\Wordpress\Action;
use Triangle\Wordpress\Meta;
use Triangle\Wordpress\Service;

class EmailTemplate extends Model {

    /**
     * Emailtemplate constructor
     * @return void
     * @var    object $plugin Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin)
    {
        parent::__construct($plugin);

        /** @backend - Post_type : emailtemplate */
        $this->args['publicly_queryable'] = false;
        $this->args['has_archive'] = false;
        $this->args['show_in_menu'] = false;
        $this->args['labels'] = ['name' => 'Email Template'];
        $this->args['supports'] = ['title'];

        /** @backend - Meta_fields : Based on plugin config templates */
        $templates = $plugin->getConfig()->templates;
        foreach($templates as $template) {
            foreach ($template->children as $children) {
                $key = 'template_' . $children->id;
                $meta = new Meta();
                $meta->setType($this);
                $meta->setKey($key);
                $this->metas[$key] = $meta;
            }
        }

        /** @backend - Hooks - Emailtemplate save post hook */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('save_post');
        $action->setCallback('save_emailtemplate');
        $action->setAcceptedArgs(3);
        $this->hooks[] = $action;
    }

    /**
     * Save emailtemplate hook
     * 1. Save page script as meta fields
     * 2. Build email template script (html, css, js) file
     * @backend - @emailtemplate
     * @return  void
     * @var     int     $post_id    Post ID
     * @var     object  $post       Post Object
     * @var     bool    $update     Whether this is an existing post being updated or not.
     */
    public function save_emailtemplate($post_id, $post, $update){
        $pagenow = $this->Helper->getScreen()->pagenow;
        if (!empty($_POST) && $post->post_type=='emailtemplate' && in_array($pagenow, ['post.php', 'post-new.php'])){
            if($post->post_status=='trash') return;
            $templates = $this->Plugin->getConfig()->templates;
            $templates = $this->Helper->getTemplatesFromConfig($templates);
            /** Save meta field */
            $this->ID = $post_id;
            $metas = $this->metas;
            $html = ''; $css = '';
            foreach($metas as $meta){
                $name = $meta->getKey();
                $configName = str_replace('template_','',$name);
                if(Service::get_option('triangle_builder_inliner')=='none' && $templates[$configName]->mode=='ace/mode/css') continue; /** Builder options */
                if($templates[$configName]->mode=='ace/mode/html') $html .= $_POST[$name];
                elseif($templates[$configName]->mode=='ace/mode/css') $css .= $_POST[$name];
                $meta->setValue($_POST[$name]);
                $results[] = $meta->update_post_meta();
            }
            /** Build template */
            $this->loadController('EmailTemplate');
            $this->EmailTemplate->buildEmailTemplate($post->post_name, $html, $css);
            $this->EmailTemplate->standardizeEmailTemplate($post->post_name);
        }
    }

}