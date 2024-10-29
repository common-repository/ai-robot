<div class="robot-box-settings-row">

    <div class="robot-box-settings-col-1">
        <span class="robot-settings-label"><?php esc_html_e( 'Facebook URL', 'ai-robot' ); ?></span>
        <span class="robot-description"><?php esc_html_e( 'You can select post from faceook group or profile url.', 'ai-robot' ); ?></span>
    </div>

    <div class="robot-box-settings-col-2">

        <div class="sui-side-tabs">
            <div class="sui-tabs-menu">
                <div class="sui-tab-item facebook_source_type <?php if(isset($settings['facebook_source_type']) && $settings['facebook_source_type'] == 'profile'){echo 'active';}else if(!isset($settings['facebook_source_type'])){echo 'active';} ?>" data-nav="profile"><?php esc_html_e( 'Profile', 'ai-robot' ); ?></div>
                <div class="sui-tab-item facebook_source_type <?php if(isset($settings['facebook_source_type']) && $settings['facebook_source_type'] == 'group'){echo 'active';} ?>" data-nav="group"><?php esc_html_e( 'Group', 'ai-robot' ); ?></div>
            </div>
        </div>

        <div class="sui-tabs-content">
            <div class="sui-tab-content <?php if(isset($settings['facebook_source_type']) && $settings['facebook_source_type'] == 'profile'){echo 'active';}else if(!isset($settings['facebook_source_type'])){echo 'active';} ?>" id="profile">
                <div class="robot-form-field">
                    <label for="facebook_user" id="facebook-user-label" class="robot-label">
                        <span>
                        <?php
                        printf(
                            esc_html__( 'The user feed is only accessiable after the user grants the "user_posts" permission. Check the %1$s)', 'ai-robot' ),
                            '<a href="https://developers.facebook.com/tools/explorer/">Facebook API</a>'
                        );
                        ?>
                        </span>
                    </label>
                </div>
            </div>

            <div class="sui-tab-content <?php if(isset($settings['facebook_source_type']) && $settings['facebook_source_type'] == 'group'){echo 'active';} ?>" id="group">
                <div class="robot-form-field">
                    <label for="facebook_group" id="facebook-group" class="robot-label">
                        <span>
                        <?php
                        printf(
                            esc_html__( 'Facebook page name(after facebook.com at the thewphobby link, for example "thewphobby" for  %1$s)', 'ai-robot' ),
                            '<a href="https://www.facebook.com/thewphobby/">this page</a>'
                        );
                        ?>
                        </span>
                    </label>
                    <input
                        type="text"
                        name="facebook_group"
                        placeholder="<?php esc_html_e( 'Enter your facebook group name here', 'ai-robot' ); ?>"
                        value="<?php if(isset($settings['facebook_group'])){echo esc_attr($settings['facebook_group']);} ?>""
                        id="facebook-group"
                        class="robot-form-control"
                        aria-labelledby="facebook_group"
                    />
                </div>
            </div>
        </div>


    </div>

</div>
