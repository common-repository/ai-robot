<?php
$addons = ai_robot_get_addons();
?>
<div id="robot-apps" class="robot-box-tab active">

    <div class="robot-box">

        <div class="robot-box-header">

            <h2 class="robot-box-title">
                <?php esc_html_e( 'Your API Settings', 'ai-robot' ); ?>
            </h2>

        </div>

        <div id="robot-integrations-page" class="robot-box-body">
            <p>
                <?php esc_html_e( 'Ai Robot integrates with your favorite third party apps. You can connect to the available apps via their API here and activate them to collect data from third party apps.', 'ai-robot' ); ?>
            </p>

            <div class="robot-integrations-block">

                <span class="robot-table-title"><?php esc_html_e( 'Connected Apps', 'ai-robot' ); ?></span>

                <?php
                if ( ! empty( $addons['connected'] ) ) {
                ?>

                <table class="robot-table robot-table--apps">
                    <tbody>
                    <?php foreach ( $addons['connected'] as $key => $provider ) : ?>

                    <tr class="robot-integration-enabled">
                        <td class="robot-table-item-title">
                            <div class="robot-app--wrapper">
                                <img src="<?php echo esc_attr($provider['icon_url']); ?>" alt="<?php echo esc_attr($provider['name']); ?>" class="robot-addon-image" aria-hidden="true">
                                <span><?php echo esc_html($provider['name']); ?></span>
                                <a href="#integration-popup" class="robot-connect-integration" data-effect="mfp-zoom-in" data-slug="<?php echo esc_attr($provider['slug']); ?>">
                                <button class="robot-button-icon robot-tooltip robot-tooltip-top-right connect-integration">
                                    <ion-icon name="settings-outline"></ion-icon>
                                    <span class="robot-screen-reader-text"><?php esc_html_e( 'Connect this integration', 'ai-robot' ); ?></span>
                                </button>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <?php } else { ?>

                    <div class="robot-notice robot-notice-info">
                        <p><?php esc_html_e( 'You are not connected to any third party apps. You can connect to the available apps listed below and activate them in your modules to collect data.', 'ai-robot' ); ?></p>
                    </div>

                <?php } ?>

                <span class="robot-description">
                    <?php esc_html_e( 'To activate any of these to collect data, click the following app name and add the API settings data.', 'ai-robot' ); ?>
                </span>

            </div>

            <div class="robot-integrations-block">

                <span class="robot-table-title"><?php esc_html_e( 'Available Apps', 'ai-robot' ); ?></span>

                <?php
                if ( ! empty( $addons['not_connected'] ) ) {
                ?>

                <table class="robot-table robot-table--apps">
                    <tbody>
                    <?php foreach ( $addons['not_connected'] as $key => $provider ) : ?>
                        <tr>
                            <td class="robot-table-item-title">
                                <div class="robot-app--wrapper">
                                    <img src="<?php echo esc_attr($provider['icon_url']); ?>"  alt="<?php echo esc_attr($provider['name']); ?>" class="robot-addon-image" aria-hidden="true">
                                    <span><?php echo esc_html($provider['name']); ?></span>
                                    <a href="#integration-popup" class="robot-connect-integration" data-effect="mfp-zoom-in" data-slug="<?php echo esc_attr($provider['slug']); ?>">
                                        <button class="robot-button-icon robot-tooltip robot-tooltip-top-right" >
                                        <ion-icon name="add"></ion-icon>
                                        <span class="robot-screen-reader-text"><?php esc_html_e( 'Connect this integration', 'ai-robot' ); ?></span>
                                    </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>


                <?php
                    }
                ?>

            </div>
        </div>

    </div>

    <!-- Integration Popup -->
    <div id="integration-popup" class="white-popup mfp-with-anim mfp-hide">
    </div>

</div>