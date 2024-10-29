<div class="robot-box-settings-row">

    <div class="robot-box-settings-col-1">
        <span class="robot-settings-label"><?php esc_html_e( 'Feed Link', 'ai-robot' ); ?></span>
    </div>

    <div class="robot-box-settings-col-2">

        <label class="robot-settings-label"><?php esc_html_e( 'Feed Source Link', 'ai-robot' ); ?></label>


        <div class="robot-form-field">
            <input
                type="text"
                name="robot_feed_link"
                placeholder="<?php esc_html_e( 'Enter your feed url here', 'ai-robot' ); ?>"
                value="<?php if(isset($settings['robot_feed_link'])){echo esc_attr( $settings['robot_feed_link'] );}?>"
                id="robot_feed_link"
                class="robot-form-control"
            />
        </div>

        <p>
           <span class="instagram-description">
              <?php
              printf(
                  esc_html__( 'Note: Please enter the rss url like %1$s', 'ai-robot' ),
                  '<a href="https://www.wpbeginner.com/feed">WP Beginner Feed</a>'
              );
              ?>
           </span>
        </p>


    </div>

</div>
