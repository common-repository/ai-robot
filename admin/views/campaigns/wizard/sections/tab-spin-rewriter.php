<?php
$spin_rewriter_checked = isset($settings['robot_spin_rewriter']) && $settings['robot_spin_rewriter']== 'on' ? 'checked' : '';
?>
<div id="rewriter" class="robot-box-tab" data-nav="rewriter" >

    <div class="robot-box-header">
        <h2 class="robot-box-title"><?php esc_html_e( 'Enable Spin Rewriter', 'ai-robot' ); ?></h2>
    </div>

    <div class="robot-box-body">
        <div class="robot-box-settings-row">
            <div class="robot-box-settings-col-1">
                <span class="robot-settings-label"><?php esc_html_e( 'Enable Spin Rewriter', 'ai-robot' ); ?></span>
                <span class="robot-description"><?php esc_html_e( 'Enable Spin Rewriter or not.', 'ai-robot' ); ?></span>
            </div>
            <div class="robot-box-settings-col-2">
                <label class="switch" for="spin-rewriter">
                   <input type="checkbox" id="spin-rewriter" name='robot_spin_rewriter' <?php echo esc_attr($spin_rewriter_checked); ?> />
                   <div class="slider round"></div>
                </label>
                <p>
                    <span class="robot-description">
                        <a href="<?php echo esc_url( 'https://www.spinrewriter.com/?ref=50f2e' );?>">
                            <?php esc_html_e( 'Note: You need the unique Spin Rewriter API key for this services', 'ai-robot' ); ?>
                        </a>
                    </span>
                </p>
                <p>
                    <span class="robot-description">
                        <a href="<?php echo admin_url( 'admin.php?page=ai-robot-integrations' ); ?>">
                            <?php esc_html_e( 'Note: Please select the spin rewriter service and enter API key here', 'ai-robot' ); ?>
                        </a>
                    </span>
                </p>
            </div>
        </div>
    </div>

</div>


