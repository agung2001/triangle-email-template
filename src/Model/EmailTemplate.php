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

        /** @backend - Meta_fields : Extra key for standard */
        $key  = 'template_standard';
        $meta = new Meta();
        $meta->setType($this);
        $meta->setKey($key);
        $this->metas[$key] = $meta;

        /** @backend - Hooks - Emailtemplate save post hook */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('save_post');
        $action->setCallback('save_emailtemplate');
        $action->setAcceptedArgs(3);
        $this->hooks[] = $action;

        /** @backend - Hooks - Emailtemplate save post hook */
        $action = clone $action;
        $action->setHook('before_delete_post');
        $action->setCallback('delete_emailtemplate');
        $action->setAcceptedArgs(1);
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
        global $post, $pagenow;
        if (!empty($_POST) && $post->post_type==$this->name && in_array($pagenow, ['post.php', 'post-new.php'])){
            /** Load Options */
            $this->loadController('EmailTemplate');
            $this->ID = $post_id;

            /** Validate Params */
            $default = ['template_html'];
            if(!$this->EmailTemplate->validateParams($_POST, $default)) die('Parameters did not match the specs!');

            /** Sanitize Params */
            $default = array_flip($default);
            $default['template_html'] = 'html';
            $default['activeSection'] = 'text';
            $params = $this->EmailTemplate->sanitizeParams($_POST, $default);

            /** Save meta field */
            $results = [];
            foreach($this->metas as $key => $meta){
                if(!isset($params[$key])) continue;
                $value = $params[$key];
                $meta->setValue($value);
                $results[] = $meta->update_post_meta();
            }

            /** Redirect to activeSection */
            $path = array();
            $path['post'] = $post_id;
            $path['action'] = 'edit';
            $path['section'] = $params['activeSection'];
            $path = unserialize(TRIANGLE_PATH)['admin_url'] . 'post.php?' . http_build_query($path);
            $this->Service->Page->wp_redirect($path);
        }
    }

    /**
     * Delete emailtemplate hook
     * @backend - @emailtemplate
     * @return  void
     * @var     int     $post_id    Post ID
     */
    public function delete_emailtemplate($post_id){
        $this->setID($post_id);
        $post = $this->get_post();
        if($post->post_type==$this->name){
            $slug = str_replace('__trashed','',strtolower($post->post_name));
            $path = unserialize(TRIANGLE_PATH);
            $dir = $path['upload_dir']['basedir'] . '/emailtemplate/' . $slug;
            if(is_dir($dir)) $this->Helper->deleteDir($dir);
        }
    }

}