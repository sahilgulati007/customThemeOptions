//my theme option code
add_action('admin_menu','custom_theme_option');
function custom_theme_option(){
    add_menu_page( "Theme Options", "Theme Options", "manage_options", "theme-options", 'create_options');
}

function create_options()
{
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
    echo "hello";
    ?>
    <form action="#" method="post">
        <table>
            <tr>
                <th>Logo</th>
                <td><input type="text" placeholder="Logo" name="logo1"> <?php global $post;
                    $meta = get_post_meta( $post->ID, 'your_fields', true ); ?>

                    <input type="hidden" name="your_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
                    <p>
                        <label for="your_fields[image]">Image Upload</label><br>
                        <input type="text" name="logo" id="logo" class="meta-image regular-text" value="<?php echo get_option('bloglogo'); ?>">
                        <input type="button" class="button image-upload" value="Browse">
                    </p>

                    <div class="image-preview"><img src="<?php echo get_option('bloglogo'); ?>" style="max-width: 250px;"></div>
                    <!-- All fields will go here -->
                    <script>
                        jQuery(document).ready(function ($) {
                            // Instantiates the variable that holds the media library frame.
                            var meta_image_frame;
                            // Runs when the image button is clicked.
                            $('.image-upload').click(function (e) {
                                // Get preview pane
                                var meta_image_preview = $(this).parent().parent().children('.image-preview');
                                // Prevents the default action from occuring.
                                e.preventDefault();
                                var meta_image = $(this).parent().children('.meta-image');
                                // If the frame already exists, re-open it.
                                if (meta_image_frame) {
                                    meta_image_frame.open();
                                    return;
                                }
                                // Sets up the media library frame
                                meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
                                    title: meta_image.title,
                                    button: {
                                        text: meta_image.button
                                    }
                                });
                                // Runs when an image is selected.
                                meta_image_frame.on('select', function () {
                                    // Grabs the attachment selection and creates a JSON representation of the model.
                                    var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
                                    // Sends the attachment URL to our custom image input field.
                                    meta_image.val(media_attachment.url);
                                    meta_image_preview.children('img').attr('src', media_attachment.url);
                                });
                                // Opens the media library frame.
                                meta_image_frame.open();
                            });
                        });
                    </script> </td>
            </tr>
            <tr>
                <th>Site Title</th>
                <td><input type="text" placeholder="Site Title" name="title"
                           value="<?php echo get_option('blogname') ?>"></td>
            </tr>
            <tr>
                <th>Site Description</th>
                <td><input type="text" placeholder="Site Description" name="desc"
                           value="<?php echo get_option('blogdescription') ?>"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center"><input type="submit" value="Update" name="sub"></td>
            </tr>
        </table>
    </form>
    <?php
    if (isset($_POST['sub'])) {
        echo "in";
        echo $_POST['logo'];
        echo $_POST['title'];
        echo $_POST['desc'];
        update_option('blogname', $_POST['title']);
        update_option('blogdescription', $_POST['desc']);
        update_option('bloglogo',$_POST['logo']);
    }
}