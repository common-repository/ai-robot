<?php
    // All campaigns model
    $models = Ai_Robot_Custom_Form_Model::model()->get_all_models();
    $campaigns = $models['models'];

?>
<div id="export" class="robot-box-tab" data-nav="export" >

    <div class="robot-box-header">
        <h2 class="robot-box-title"><?php esc_html_e( 'Export', 'ai-robot' ); ?></h2>
    </div>

    <form class="robot-settings-form" method="post" action="">

    <div class="robot-box-body">
        <div class="robot-box-settings-row">

            <div class="robot-box-settings-col-1">
                <span class="robot-settings-label"><?php esc_html_e( 'Export Campaigns', 'ai-robot' ); ?></span>
                <span class="robot-description"><?php esc_html_e( 'Export current website campaigns and import these campaigns on your other sites.', 'ai-robot' ); ?></span>
            </div>

            <div class="robot-box-settings-col-2">
                <div class="robot-box-export-selector">
                        <label class="sui-checkbox sui-checkbox-all">
						    <input type="checkbox" checked="checked">
						    <span><?php esc_html_e( 'All Campaigns', 'ai-robot' ); ?><?php echo ' ('.count($campaigns).')';?></span>
					    </label>
                        <br>
                        <?php foreach ( $campaigns as $key => $model ) : ?>
                            <label class="sui-checkbox">
						        <input type="checkbox" checked="checked" data-index=<?php echo esc_attr( $key ); ?>>
						            <span><?php echo esc_html( $model->settings['robot_campaign_name'] ); ?></span>
					        </label>
                            <br>
                        <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>

    <div class="robot-box-footer">
        <div class="robot-actions-left">
            <button class="robot-trigger-export robot-button robot-button-blue" type="button">
                <span class="robot-loading-text"><?php esc_html_e( 'Export', 'ai-robot' ); ?></span>
            </button>
        </div>

    </div>

    </form>



</div>


