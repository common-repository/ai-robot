<?php
$main_post_template = isset($settings['robot_youtube_main_post_content']) ? $settings['robot_youtube_main_post_content']  : '{{video_embed}}';
$before_post_template = isset($settings['robot_before_post_content']) ? $settings['robot_before_post_content']  : '';
$after_post_template = isset($settings['robot_after_post_content']) ? $settings['robot_after_post_content']  : '';
$source = isset( $_GET['source'] ) ? sanitize_text_field( $_GET['source'] ) : 'dashboard';
?>
<div id="post-content" class="robot-box-tab" data-nav="post-content" >

    <div class="robot-box-header">
        <h2 class="robot-box-title"><?php esc_html_e( 'Post Template & Words Limits', 'ai-robot' ); ?></h2>
    </div>

    <div class="robot-box-body">
        <?php
            if($source === 'youtube'){
        ?>
                <div class="robot-box-settings-row">
                    <div class="robot-box-settings-col-1">
                        <span class="robot-settings-label"><?php esc_html_e( 'Post Content Template', 'ai-robot' ); ?></span>
                    </div>
                    <div class="robot-box-settings-col-2">
                        <label class="robot-settings-label"><?php esc_html_e( 'Your Post Content Template', 'ai-robot' ); ?></label>
                        <span class="robot-description"><?php esc_html_e( 'You can use the following shortcode to insert youtube video elements in your post content.', 'ai-robot' ); ?></span>
                        <div class="select-container">
                    <span class="dropdown-handle" aria-hidden="true">
                        <ion-icon name="chevron-down" class="robot-icon-down"></ion-icon>
                    </span>
                            <a class="button_add_field dashicons dashicons-plus-alt" title="<?php _e("Add", 'ai-robot') ?>"></a>
                            <div class="select-list-container">
                                <button type="button" class="list-value" id="robot-field-shortcode-button" value="{{video_embed}}">
                                    <?php
                                    esc_html_e( '{{video_embed}}', 'ai-robot' );
                                    ?>
                                </button>
                                <ul tabindex="-1" role="listbox" class="list-results robot-sidenav-hide-md" >
                                    <li><?php esc_html_e( '{{video_embed}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{video_key}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{video_url}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{video_title}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{video_description}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{video_duration}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{video_views}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{video_favorites}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{video_likes}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{video_dislikes}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{video_comments}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{video_publishedAt}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{thumbnail_maxres_url}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{thumbnail_high_url}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{thumbnail_medium_url}}', 'ai-robot' ); ?></li>
                                    <li><?php esc_html_e( '{{thumbnail_default_url}}', 'ai-robot' ); ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="robot-form-field">
                            <textarea class="robot-form-control" id="robot-main-post-template" rows="5" cols="20" name="robot_youtube_main_post_content" required="required"><?php echo esc_html($main_post_template); ?></textarea>
                        </div>
                    </div>
                </div>
        <?php
            }
        ?>
        <div class="robot-box-settings-row">
            <div class="robot-box-settings-col-1">
                <span class="robot-settings-label"><?php esc_html_e( 'Before Post Content', 'ai-robot' ); ?></span>
            </div>
            <div class="robot-box-settings-col-2">
                <label class="robot-settings-label"><?php esc_html_e( 'Your Content Before Post', 'ai-robot' ); ?></label>
                <span class="robot-description"><?php esc_html_e( 'Insert any of your ads, html content before the source post.', 'ai-robot' ); ?></span>
                <div class="robot-form-field">
                    <textarea class="robot-form-control" id="robot-before-post-template" rows="5" cols="20" name="robot_before_post_content" required="required"><?php echo esc_html($before_post_template); ?></textarea>
                </div>
            </div>
        </div>
        <div class="robot-box-settings-row">
            <div class="robot-box-settings-col-1">
                <span class="robot-settings-label"><?php esc_html_e( 'After Post Content', 'ai-robot' ); ?></span>
            </div>
            <div class="robot-box-settings-col-2">
                <label class="robot-settings-label"><?php esc_html_e( 'Your Content After Post', 'ai-robot' ); ?></label>
                <span class="robot-description"><?php esc_html_e( 'Insert any of your ads, html content after the source post.', 'ai-robot' ); ?></span>
                <div class="robot-form-field">
                    <textarea class="robot-form-control" id="robot-after-post-template" rows="5" cols="20" name="robot_after_post_content" required="required"><?php echo esc_html($after_post_template); ?></textarea>
                </div>
            </div>
        </div>
        <?php if($source === 'rss') :?>
        <div class="robot-box-settings-row">
            <div class="robot-box-settings-col-1">
                <span class="robot-settings-label"><?php esc_html_e( 'Words Limit', 'ai-robot' ); ?></span>
            </div>
            <div class="robot-box-settings-col-2">
                <label class="robot-settings-label"><?php esc_html_e( 'Your Content Words Limit', 'ai-robot' ); ?></label>
                <span class="robot-description"><?php esc_html_e( 'Set your source post content words limit here.', 'ai-robot' ); ?></span>
                <div>
                    <input
                        type="text"
                        name="robot_words_limit"
                        placeholder="<?php esc_html_e( 'Leave this field blank if no words limit', 'ai-robot' ); ?>"
                        value="<?php if(isset($settings['robot_words_limit'])){echo esc_attr($settings['robot_words_limit']);}?>"
                        id="robot_words_limit"
                        class="robot-form-control"
                        aria-labelledby="robot_words_limit"
                    />
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>


