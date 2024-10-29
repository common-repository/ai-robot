<?php
$feature_image_checked = isset($settings['robot_feature_image']) && $settings['robot_feature_image']== 'on' ? 'checked' : '';
$save_image_checked = isset($settings['robot_save_image']) && $settings['robot_save_image']== 'on' ? 'checked' : '';
?>
<div id="post-images" class="robot-box-tab" data-nav="post-images" >

    <div class="robot-box-header">
        <h2 class="robot-box-title"><?php esc_html_e( 'Post Images Settings', 'ai-robot' ); ?></h2>
    </div>

    <div class="robot-box-body">
        <div class="robot-box-settings-row">
            <div class="robot-box-settings-col-1">
                <span class="robot-settings-label"><?php esc_html_e( 'Post Feature Image', 'ai-robot' ); ?></span>
                <span class="robot-description"><?php esc_html_e( 'Set First source image as featured image.', 'ai-robot' ); ?></span>
            </div>
            <div class="robot-box-settings-col-2">
                <label class="switch" for="feature-image">
                   <input type="checkbox" id="feature-image" name='robot_feature_image' <?php echo esc_attr($feature_image_checked); ?> />
                   <div class="slider round"></div>
                </label>
                <p>
                    <span class="robot-description">
                        <a href="<?php echo esc_url( 'https://www.php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen' );?>">
                            <?php esc_html_e( 'Note: You need to enable allow_url_fopen in your php.ini', 'ai-robot' ); ?>
                        </a>
                    </span>
                </p>
            </div>
        </div>

        <div class="robot-box-settings-row">
            <div class="robot-box-settings-col-1">
                <span class="robot-settings-label"><?php esc_html_e( 'Save Image in your server', 'ai-robot' ); ?></span>
                <span class="robot-description"><?php esc_html_e( 'Save image to wp media library.', 'ai-robot' ); ?></span>
            </div>
            <div class="robot-box-settings-col-2">
                <label class="switch" for="save-image">
                   <input type="checkbox" id="save-image" name='robot_save_image' <?php echo esc_attr($save_image_checked); ?> />
                   <div class="slider round"></div>
                </label>
                <p>
                    <span class="robot-description">
                            <?php esc_html_e( 'Note: It is not recommended to save remote images on wp media library', 'ai-robot' ); ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

</div>


