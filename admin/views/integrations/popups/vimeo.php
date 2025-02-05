<?php
$current_addon_data = ai_robot_get_addon_data('vimeo');
?>
<div class="robot-box" role="document">

    <div class="robot-box-header robot-block-content-center">

        <div class="robot-dialog-image" aria-hidden="true">

            <img src="<?php echo esc_url(AI_ROBOT_URL.'/assets/images/vimeo.png'); ?>" alt="<?php esc_attr_e( 'Vimeo API', 'ai-robot' ); ?>">

        </div>

        <div class="robot-box-content integration-header">

            <h3 class="robot-box-title" id="dialogTitle2"><?php esc_html_e( 'Setup Vimeo API', 'ai-robot' ); ?></h3>

			<span class="robot-description">
                <?php esc_html_e( 'Setup Vimeo API to be used by Ai Robot to display tweets on your blog.', 'ai-robot' ); ?>
			</span>

        </div>

    </div>

    <div class="robot-box-body">
        <form class="robot-integration-form" method="post" name="robot-integration-form" action="">

            <div class="robot-form-field">
                <label class="robot-label"><?php esc_html_e( 'Access Token', 'ai-robot' ); ?></label>
                <div class="robot-control-with-icon">
                    <ion-icon class="robot-icon-key" name="key"></ion-icon>
                    <input name="access_token" placeholder="<?php esc_html_e( 'Access Token', 'ai-robot' ); ?>" value="<?php if(!empty($current_addon_data['access_token'])){echo esc_attr($current_addon_data['access_token']);}?>" class="robot-form-control">
                </div>
            </div>

            <input type="hidden" name="slug" value="<?php echo esc_attr('vimeo');?>" >
            <input type="hidden" name="is_connected" value="<?php echo esc_attr($current_addon_data['is_connected']);?>" >

            <div class="robot-border-frame robot-description">

                <span>
                    <?php esc_html_e( 'Follow these instructions to retrieve your Client ID and Secret.', 'ai-robot' ); ?>
                </span>

            </div>

        </form>

    </div>

    <div class="robot-box-footer robot-box-footer-center">
        <button type="button" class="robot-button robot-addon-connect">
            <span class="robot-loading-text"><?php esc_html_e( 'Connect', 'ai-robot' ); ?></span>
        </button>
    </div>

</div>