<?php
$source = isset( $_GET['source'] ) ? sanitize_text_field( $_GET['source'] ) : 'dashboard';
$id = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
// Campaign Settings
$settings = array();
if(!empty($id)){
    $model    = $this->get_single_model( $id );
    $settings = $model->settings;
    $settings['status'] = $model->status;
}
$robot_youtube_source_category = isset( $settings['robot_youtube_source_category'] ) ? sanitize_text_field( $settings['robot_youtube_source_category'] ) : 'playlist';

?>
<div class="robot-row-with-sidenav">

    <div class="robot-sidenav">

        <div class="robot-mobile-select">
            <span class="robot-select-content"><?php esc_html_e( 'General', 'ai-robot' ); ?></span>
            <ion-icon name="chevron-down" class="robot-icon-down"></ion-icon>
        </div>

        <ul class="robot-vertical-tabs robot-sidenav-hide-md">

            <li class="robot-vertical-tab">
                <a href="#" data-nav="dashboard"><?php esc_html_e( 'General', 'ai-robot' ); ?></a>
            </li>

            <li class="robot-vertical-tab">
                <a href="#" data-nav="schedule"><?php esc_html_e( 'Schedule', 'ai-robot' ); ?></a>
            </li>

            <li class="robot-vertical-tab">
                <a href="#" data-nav="post-content"><?php esc_html_e( 'Post Template', 'ai-robot' ); ?></a>
            </li>

            <li class="robot-vertical-tab">
                <a href="#" data-nav="post-status"><?php esc_html_e( 'Post Status', 'ai-robot' ); ?></a>
            </li>

            <li class="robot-vertical-tab">
                <a href="#" data-nav="post-images"><?php esc_html_e( 'Post Images', 'ai-robot' ); ?></a>
            </li>

            <li class="robot-vertical-tab">
                <a href="#" data-nav="category"><?php esc_html_e( 'Categories & Tags', 'ai-robot' ); ?></a>
            </li>

            <?php if($source == 'rss') : ?>
                <li class="robot-vertical-tab">
                    <a href="#" data-nav="translation"><?php esc_html_e( 'Translation', 'ai-robot' ); ?></a>
                </li>
                <li class="robot-vertical-tab">
                    <a href="#" data-nav="rewriter"><?php esc_html_e( 'Rewriter', 'ai-robot' ); ?></a>
                </li>
            <?php endif; ?>

        </ul>

        <div class="robot-sidenav-settings">
          <a href="#run-campaign-popup" class="open-popup-campaign" data-effect="mfp-zoom-in">
            <button id="robot-run-button" class="robot-button robot-sidenav-hide-md" accesskey="p">
                <?php esc_html_e( 'Run Campaign', 'ai-robot' ); ?>
            </button>
          </a>
      </div>

    </div>

    <form class="robot-campaign-form" method="post" name="robot-campaign-form" action="">

    <div class="robot-box-tabs">
        <?php $this->template( 'campaigns/wizard/sections/tab-save',  $settings); ?>
        <?php $this->template( 'campaigns/wizard/sections/tab-schedule',  $settings); ?>
        <?php $this->template( 'campaigns/wizard/sections/tab-dashboard', $settings); ?>
        <?php $this->template( 'campaigns/wizard/sections/tab-post-content', $settings); ?>
        <?php $this->template( 'campaigns/wizard/sections/tab-post-status', $settings); ?>
        <?php $this->template( 'campaigns/wizard/sections/tab-post-images', $settings); ?>
        <?php
            if($source == 'rss') {
                $this->template( 'campaigns/wizard/sections/tab-translation', $settings);
                $this->template( 'campaigns/wizard/sections/tab-spin-rewriter', $settings);
            }
        ?>
    </div>
        <input type="hidden" name="robot_selected_source" value="<?php echo esc_html($source); ?>">
        <input type="hidden" name="campaign_id" value="<?php echo esc_html($id); ?>">
        <input type="hidden" class="robot_youtube_source_category" name="robot_youtube_source_category" value="<?php echo esc_html($robot_youtube_source_category); ?>">
    </form>
</div>

<div id="run-campaign-popup" class="white-popup mfp-with-anim mfp-hide">

		<div class="robot-box-header robot-block-content-center">
			<h3 class="robot-box-title type-title"><?php esc_html_e( 'Campaign Console', 'ai-robot' ); ?></h3>
		</div>

        <div class="robot-box-body robot-campaign-popup-body">
        </div>

        <div class="robot-box-footer robot-box-footer-center">
          <button type="button" class="robot-button robot-run-campaign-button">
              <span class="robot-loading-text"><?php esc_html_e( 'Run', 'ai-robot' ); ?></span>
          </button>
        </div>

		<img src="<?php echo esc_url(AI_ROBOT_URL.'/assets/images/robot.png'); ?>" class="robot-image robot-image-center" aria-hidden="true" alt="<?php esc_attr_e( 'Ai Robot', 'ai-robot' ); ?>">
</div>
