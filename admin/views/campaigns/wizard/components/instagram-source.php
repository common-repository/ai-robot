<div class="robot-box-settings-row">

    <div class="robot-box-settings-col-1">
        <span class="robot-settings-label"><?php esc_html_e( 'Keywords', 'ai-robot' ); ?></span>
        <span class="robot-description"><?php esc_html_e( 'Customize the dashboard as per your liking.', 'ai-robot' ); ?></span>
    </div>

    <div class="robot-box-settings-col-2">

        <div class="sui-side-tabs">
            <div class="sui-tabs-menu">
                <div class="sui-tab-item active" data-nav="default"><?php esc_html_e( 'Specify User', 'ai-robot' ); ?></div>
            </div>
        </div>

        <div class="sui-tabs-content">
            <div class="sui-tab-content active" id="default">
                <div class="robot-form-field">
                    <label for="instagram_user" id="instagram-user-label" class="robot-label">
                        <span>
                        <?php
                        printf(
                            esc_html__( 'Instagram username(after instagram.com at the user link, for example "bbc" for  %1$s)', 'ai-robot' ),
                            '<a href="https://www.instagram.com/bbc/">this user</a>'
                        );
                        ?>
                        </span>
                    </label>
                    <input
                        type="text"
                        name="instagram_user"
                        placeholder="<?php esc_html_e( 'Enter your instagram username here', 'ai-robot' ); ?>"
                        value="<?php if(isset($settings['instagram_user'])){echo esc_attr($settings['instagram_user']);}?>"
                        id="instagram-user"
                        class="robot-form-control"
                        aria-labelledby="instagram_user"
                    />
                    <p>
                     <span class="robot-description">
                        <?php
                        printf(
                            esc_html__( 'Note: Follow %1$s your Instagram SessionID before get instagram data.', 'ai-robot' ),
                            '<a href="https://wpairobot.com/document/api-settings/how-to-setup-instagram-api-settings/">these instructions to retrieve</a>'
                        );
                        ?>
                     </span>
                    </p>
                </div>
            </div>


        </div>

    </div>

</div>
