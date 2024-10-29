<div class="robot-box-settings-row">

    <div class="robot-box-settings-col-1">
        <span class="robot-settings-label"><?php esc_html_e( 'Schedule Settings', 'ai-robot' ); ?></span>
        <span class="robot-description"><?php esc_html_e( 'Run this campaign as the WP Cron Job Schedule.', 'ai-robot' ); ?></span>
    </div>

    <div class="robot-box-settings-col-2">

        <label class="robot-settings-label"><?php esc_html_e( 'Schedule Settings', 'ai-robot' ); ?></label>

        <span class="robot-description"><?php esc_html_e( 'Select Campaign Schedule use the WP Cron Job Schedule on backend.', 'ai-robot' ); ?></span>

        <div class="range-slider">
            <input class="range-slider__range" type="range" value="<?php if(isset($settings['update_frequency'])){echo esc_attr( $settings['update_frequency'] );}else{echo esc_html('100');}?>" min="0" max="500">
            <span class="range-slider__value">0</span>
        </div>

        <span class="robot-description"><?php esc_html_e( 'Time Unit', 'ai-robot' ); ?></span>

        <div class="select-container">
            <span class="dropdown-handle" aria-hidden="true">
                <ion-icon name="chevron-down" class="robot-icon-down"></ion-icon>
            </span>
            <div class="select-list-container">
                <button type="button" class="list-value" id="robot-field-unit-button" value="Minutes">
                    <?php
                    if(isset($settings['update_frequency_unit'])){
                        echo esc_html($settings['update_frequency_unit']);
                    }else{
                        esc_html_e( 'Minutes', 'ai-robot' );
                    }
                    ?>
                </button>
                <ul tabindex="-1" role="listbox" class="list-results robot-sidenav-hide-md" >
                    <li><?php esc_html_e( 'Minutes', 'ai-robot' ); ?></li>
                    <li><?php esc_html_e( 'Hours', 'ai-robot' ); ?></li>
                    <li><?php esc_html_e( 'Days', 'ai-robot' ); ?></li>
                </ul>
            </div>
        </div>


    </div>

</div>
