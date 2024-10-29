<?php
$status = isset( $settings['status'] ) ? sanitize_text_field( $settings['status'] ) : 'draft';
?>
<div id="ai-robot-builder-status" class="robot-box robot-box-sticky">
    <div class="robot-box-status">
        <div class="robot-status">
            <div class="robot-status-module">
                <?php esc_html_e( 'Status', 'ai-robot' ); ?>
                    <?php
                    if( $status === 'draft'){
                        ?>
                    <span class="robot-tag robot-tag-draft">
                        <?php esc_html_e( 'draft', 'ai-robot' ); ?>
                    </span>
                    <?php
                    }else if($status === 'publish'){
                        ?>
                    <span class="robot-tag robot-tag-published">
                       <?php esc_html_e( 'published', 'ai-robot' ); ?>
                    </span>
                    <?php
                    }
                    ?>
            </div>
            <div class="robot-status-changes">

            </div>
        </div>
        <div class="robot-actions">
            <button id="robot-campaign-save" class="robot-button" type="button">
                <span class="robot-loading-text">
                    <ion-icon name="reload-circle"></ion-icon>
                    <span class="button-text campaign-save-text">
                        <?php
                        if($status === 'publish'){
                            echo esc_html( 'unpublish', 'ai-robot' );
                        }else{
                            echo esc_html( 'save draft', 'ai-robot' );
                        }
                        ?>
                    </span>
                </span>
            </button>
            <button id="robot-campaign-publish" class="robot-button robot-button-blue" type="button">
                <span class="robot-loading-text">
                    <ion-icon name="save"></ion-icon>
                    <span class="button-text campaign-publish-text">
                        <?php
                        if($status === 'publish'){
                            echo esc_html( 'update', 'ai-robot' );
                        }else{
                            echo esc_html( 'publish', 'ai-robot' );
                        }
                        ?>
                    </span>
                </span>
            </button>
        </div>
    </div>
</div>
