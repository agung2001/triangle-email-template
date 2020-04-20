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
        $this->args['supports'] = ['title', 'thumbnail'];

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
        if ($post->post_type=='emailtemplate'){
            /** Save meta field */
            if(isset($this->metas['template_header'])){
                $meta = $this->metas['template_header'];
                $meta->setValue($_POST['template_header']);
                $result = $meta->update_post_meta();
            }

            echo '<pre>';
            var_dump($result);
            exit;
        }
    }

}