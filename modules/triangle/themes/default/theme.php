<?php
    if($_POST){
        update_option('triangle_theme_default_header', wp_kses_post(stripslashes($_POST['header'])));
        update_option('triangle_theme_default_footer', wp_kses_post(stripslashes($_POST['footer'])));
        update_option('triangle_theme_default_logo', $_POST['triangle_theme_default_logo']);
    }

    $editorConfig = array(
        'wpautop' => true,
        'media_buttons' => true,
        'textarea_rows' => 20,
        'tabindex' => '',
        'tabfocus_elements' => ':prev,:next', 
        'editor_css' => '', 
        'editor_class' => '',
        'teeny' => false,
        'dfw' => false,
        'tinymce' => false,
        'quicktags' => true
    );
    $header = get_option('triangle_theme_default_header');
    $footer = get_option('triangle_theme_default_footer');
    $logo = get_option('triangle_theme_default_logo',0);
?>
    
    <form method="POST" style="padding:0px;">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label>Logo</label>
                    </th>
                    <td>
                        <div class='image-preview-wrapper'>
                            <?php
                                $logo_url = wp_get_attachment_url( $logo );
                                if(!$logo_url) $logo_url = $this->get_asset('img','appleby.png',array('type' => 'url'));
                            ?>
                            <img id='image-preview' src='<?= $logo_url; ?>' height='100'>
                        </div>
                        <input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo' ); ?>" />
                        <input type='hidden' name='triangle_theme_default_logo' id='image_logo_id' value='<?php echo get_option( 'media_selector_attachment_id' ); ?>'>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label>Header</label>
                    </th>
                    <td>
                        <?php wp_editor($header, 'header', $editorConfig); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label>Footer</label>
                    </th>
                    <td>
                        <?php wp_editor($footer, 'footer', $editorConfig); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">&nbsp;</th>
                    <td>
                        <input name="save" class="button-primary" value="Save changes" type="submit">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <script type='text/javascript'>
		jQuery( document ).ready( function( $ ) {
			// Uploading files
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = <?= $logo; ?>; // Set this
			jQuery('#upload_logo_button').on('click', function( event ){
				event.preventDefault();
				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}
				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});
				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();
					// Do something with attachment.id and/or attachment.url here
					$( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					$( '#image_logo_id' ).val( attachment.id );
					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});
					// Finally, open the modal
					file_frame.open();
			});
			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		});
	</script>