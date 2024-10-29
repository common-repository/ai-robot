<?php
$current_addon_data = ai_robot_get_addon_data('open-ai');
?>
<div class="robot-box" role="document">

    <div class="robot-box-header robot-block-content-center">

        <div class="robot-dialog-image" aria-hidden="true">

            <img src="<?php echo esc_url(AI_ROBOT_URL.'/assets/images/open-ai.png'); ?>" alt="<?php esc_attr_e( 'Open AI API Key', 'ai-robot' ); ?>">

        </div>

        <div class="robot-box-content integration-header">

            <h3 class="robot-box-title" id="dialogTitle2"><?php esc_html_e( 'Setup Open AI API Key', 'ai-robot' ); ?></h3>

			<span class="robot-description">
                <?php esc_html_e( 'Setup Open AI API Key to be used by Ai Robot to generate content for your blog automatically.', 'ai-robot' ); ?>
			</span>

        </div>

    </div>

    <div class="robot-box-body">
        <form class="robot-integration-form" method="post" name="robot-integration-form" action="">

            <div class="robot-form-field">
                <label class="robot-label"><?php esc_html_e( 'Session ID', 'ai-robot' ); ?></label>
                <div class="robot-control-with-icon">
                    <ion-icon class="robot-icon-key" name="key"></ion-icon>
                    <input name="api_key" placeholder="<?php esc_html_e( 'API Key', 'ai-robot' ); ?>" value="<?php if(!empty($current_addon_data['api_key'])){echo esc_attr($current_addon_data['api_key']);}?>" class="robot-form-control">
                </div>
            </div>

            <input type="hidden" name="slug" value="<?php echo esc_attr('open-ai');?>" >
            <input type="hidden" name="is_connected" value="<?php echo esc_attr($current_addon_data['is_connected']);?>" >

            <div class="robot-border-frame robot-description">

                <span>
                    <?php
                    printf(
                        esc_html__( 'You can get your API Keys in your %1$s', 'ai-robot' ),
                        '<a href="https://platform.openai.com/account/api-keys" target="_blank">OpenAI Account</a>'
                    );
                    ?>
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