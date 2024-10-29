<?php
// Count total forms
$count        = $this->countModules();
$count_active = $this->countModules( 'publish' );

// available bulk actions
$bulk_actions = $this->bulk_actions();

$this->template( 'dashboard/widgets/widget-popup' );
?>

<?php if ( $count > 0 ) { ?>

    <!-- START: Bulk actions and pagination -->
    <div class="robot-listings-pagination">

        <div class="robot-pagination-mobile robot-pagination-wrap">
            <span class="robot-pagination-results">
                            <?php /* translators: ... */ echo esc_html( sprintf( _n( '%s result', '%s results', $count, 'ai-robot' ), $count ) ); ?>
                        </span>
            <?php $this->pagination(); ?>
        </div>

        <div class="robot-pagination-desktop robot-box">
            <div class="robot-box-search">

                <form method="post" name="robot-bulk-action-form" class="robot-search-left">

                    <input type="hidden" id="ai-robot-nonce" name="ai_robot_nonce" value="<?php echo wp_create_nonce( 'ai-robot-campaign-request' );?>">
                    <input type="hidden" name="_wp_http_referer" value="<?php admin_url( 'admin.php?page=ai-robot-campaign' ); ?>">
                    <input type="hidden" name="ids" id="robot-select-campaigns-ids" value="">

                    <label for="robot-check-all-campaigns" class="robot-checkbox">
                        <input type="checkbox" id="robot-check-all-campaigns">
                        <span aria-hidden="true"></span>
                        <span class="robot-screen-reader-text">Select all</span>
                    </label>

                    <div class="robot-select-wrapper">
                        <select name="ai_robot_bulk_action" id="bulk-action-selector-top">
                            <option value=""><?php esc_html_e( 'Bulk Action', 'ai-robot' ); ?></option>
                            <?php foreach ( $bulk_actions as $val => $label ) : ?>
                                <option value="<?php echo esc_attr( $val ); ?>"><?php echo esc_html( $label ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button class="robot-button robot-bulk-action-button">Apply</button>

                </form>

                <div class="robot-search-right">

                    <div class="robot-pagination-wrap">
                        <span class="robot-pagination-results">
                            <?php /* translators: ... */ echo esc_html( sprintf( _n( '%s result', '%s results', $count, 'ai-robot' ), $count ) ); ?>
                        </span>
                        <?php $this->pagination(); ?>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- END: Bulk actions and pagination -->

    <div class="robot-accordion robot-accordion-block" id="robot-modules-list">

        <?php
        foreach ( $this->getModules() as $module ) {
        ?>
            <div class="robot-accordion-item">
                <div class="robot-accordion-item-header">

                    <div class="robot-accordion-item-title robot-trim-title">
                        <label for="wpf-module-<?php echo esc_attr( $module['id'] ); ?>" class="robot-checkbox robot-accordion-item-action">
                            <input type="checkbox" id="wpf-module-<?php echo esc_attr( $module['id'] ); ?>" class="robot-check-single-campaign" value="<?php echo esc_html( $module['id'] ); ?>">
                            <span aria-hidden="true"></span>
                            <span class="robot-screen-reader-text"><?php esc_html_e( 'Select this form', 'ai-robot' ); ?></span>
                        </label>
                        <span class="robot-trim-text">
                            <?php echo ai_robot_get_campaign_name( $module['id'] ); ?>
                        </span>
                        <?php
                        if ( 'publish' === $module['status'] ) {
                            echo '<span class="robot-tag robot-tag-blue">' . esc_html__( 'Published', 'ai-robot' ) . '</span>';
                        }
                        ?>

                        <?php
                        if ( 'draft' === $module['status'] ) {
                            echo '<span class="robot-tag">' . esc_html__( 'Draft', 'ai-robot' ) . '</span>';
                        }
                        ?>
                    </div>

                    <div class="robot-accordion-item-date">
                        <strong><?php esc_html_e( 'Last Run', 'ai-robot' ); ?></strong>
                        <?php esc_html_e( $module['last_run_time'] ); ?>
                    </div>

                    <div class="robot-accordion-col-auto">

                        <a href="<?php echo admin_url( 'admin.php?page=ai-robot-campaign-wizard&id=' . $module['id'].'&source='.$module['type'] ); ?>"
                           class="robot-button robot-button-ghost robot-accordion-item-action robot-desktop-visible">
                            <ion-icon name="pencil" class="robot-icon-pencil"></ion-icon>
                            <?php esc_html_e( 'Edit', 'ai-robot' ); ?>
                        </a>

                        <div class="robot-dropdown robot-accordion-item-action">
                            <button class="robot-button-icon robot-dropdown-anchor">
                                <ion-icon name="settings"></ion-icon>
                            </button>
                            <ul class="robot-dropdown-list">

                                <li>
                                    <form method="post">
                                        <input type="hidden" name="ai_robot_single_action" value="update-status">
                                        <input type="hidden" name="id" value="<?php echo esc_attr( $module['id'] ); ?>">
                                        <?php
                                        if ( 'publish' === $module['status'] ) {
                                            ?>
                                            <input type="hidden" name="status" value="draft">
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ( 'draft' === $module['status'] ) {
                                            ?>
                                            <input type="hidden" name="status" value="publish">
                                            <?php
                                        }
                                        ?>
                                        <input type="hidden" id="ai_robot_nonce" name="ai_robot_nonce" value="<?php echo wp_create_nonce('ai-robot-campaign-request'); ?>">
                                        <button type="submit">
                                            <ion-icon class="robot-icon-cloud" name="cloud"></ion-icon>
                                            <?php
                                            if ( 'publish' === $module['status'] ) {
                                                echo esc_html__( 'Unpublish', 'ai-robot' );
                                            }
                                            ?>

                                            <?php
                                            if ( 'draft' === $module['status'] ) {
                                                echo esc_html__( 'Publish', 'ai-robot' );
                                            }
                                            ?>
                                        </button>
                                    </form>
                                </li>

                                <li>
                                    <a href="#delete-popup" class="open-popup-delete" data-effect="mfp-zoom-in">
                                    <button
                                        class="robot-option-red robot-delete-action"
                                        data-campaign-id="<?php echo esc_attr( $module['id'] ); ?>">
                                        <ion-icon class="robot-icon-trash" name="trash"></ion-icon> <?php esc_html_e( 'Delete', 'ai-robot' ); ?>
                                    </button>
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <button class="robot-button-icon robot-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', 'ai-robot' ); ?>">
                            <ion-icon name="chevron-down"></ion-icon>
                        </button>


                    </div>

                </div>
                <div class="robot-accordion-item-body robot-campaign-detail-hide">
                    <ul class="robot-accordion-item-data">
                        <li data-col="large">
                            <strong><?php esc_html_e( 'Last Run', 'ai-robot' ); ?></strong>
                            <?php esc_html_e( $module['last_run_time'] ); ?>
                        </li>
                        <li data-col="large">
                            <strong><?php esc_html_e( 'Type', 'ai-robot' ); ?></strong>
                            <?php esc_html_e( $module['type'] ); ?>
                        </li>
                        <li data-col="large">
                            <strong><?php esc_html_e( 'Keywords', 'ai-robot' ); ?></strong>
                            <?php esc_html_e( $module['keywords'] ); ?>
                        </li>
                    </ul>
                </div>

            </div>

        <?php

        }

        ?>

    </div>

    <!-- Delete Popup -->

    <div id="delete-popup" class="white-popup mfp-with-anim mfp-hide">

        <div class="robot-box" role="document">

            <div class="robot-box-header">

                <h3 class="robot-box-title" id="dialogTitle"><?php esc_html_e( 'Delete Form', 'ai-robot' ); ?></h3>

            </div>

            <div id="2031">

                <div class="robot-box-body">
                    <span class="robot-description"><?php esc_html_e( 'Are you sure you wish to permanently delete this campaign?', 'ai-robot' ); ?></span>
                </div>

                <div class="robot-box-footer">
                    <button type="button" class="robot-button robot-button-ghost robot-close-popup" data-a11y-dialog-hide=""><?php esc_html_e( 'Cancel', 'ai-robot' ); ?></button>
                    <form method="post" class="delete-action">
                        <input type="hidden" name="ai_robot_single_action" value="delete">
                        <input type="hidden" class="robot-delete-id" name="id" value="">
                        <input type="hidden" id="ai_robot_nonce" name="ai_robot_nonce" value="<?php echo wp_create_nonce('ai-robot-campaign-request'); ?>">
                        <input type="hidden" name="_wp_http_referer" value="<?php admin_url( 'admin.php?page=ai-robot-campaign' ); ?>">
                        <button type="submit" class="robot-button robot-button-ghost robot-button-red">
                            <ion-icon class="robot-icon-trash" name="trash"></ion-icon>
                            <?php esc_html_e( 'Delete', 'ai-robot' ); ?>
                        </button>
                    </form>
                </div>

            </div></div>

    </div>

<?php } else { ?>
    <div class="robot-box robot-message robot-message-lg">

        <img src="<?php echo esc_url(AI_ROBOT_URL.'/assets/images/robot.png'); ?>" class="robot-image robot-image-center" aria-hidden="true" alt="<?php esc_attr_e( 'Ai Robot', 'ai-robot' ); ?>">

        <div class="robot-message-content">

            <p><?php esc_html_e( 'Create campaigns to generate high-quality content articles for your website or blog from OpenAI and ChatGPT.', 'ai-robot' ); ?></p>

            <p>
                <a href="<?php echo admin_url( 'admin.php?page=ai-robot-welcome' ); ?>" class="robot-button robot-button-blue">
                    <?php esc_html_e( 'Create', 'ai-robot' ); ?>
                </a>
            </p>


        </div>

    </div>

<?php } ?>
