<div class="robot-box-settings-row">

    <div class="robot-box-settings-col-1">
        <span class="robot-settings-label"><?php esc_html_e( 'Keywords', 'ai-robot' ); ?></span>
        <span class="robot-description"><?php esc_html_e( 'Customize the dashboard as per your liking.', 'ai-robot' ); ?></span>
    </div>

    <div class="robot-box-settings-col-2">

        <label class="robot-settings-label"><?php esc_html_e( 'Campaign keywords', 'ai-robot' ); ?></label>

        <span class="robot-description"><?php esc_html_e( 'Campaign keywords (search for these keywords) (comma separated).', 'ai-robot' ); ?></span>

        <div class="robot-form-field">
            <label for="robot_search" id="robot-feed-link" class="robot-label"><?php esc_html_e( 'search keyword', 'ai-robot' ); ?></label>
            <input
                type="text"
                name="robot_search"
                placeholder="<?php esc_html_e( 'Enter your search keyword here', 'ai-robot' ); ?>"
                value=""
                id="robot-search"
                class="robot-form-control"
                aria-labelledby="robot_search"
            />
        </div>

        <div class="robot-search-results-wrapper">
            <ul class="search-result-list">
            </ul>
        </div>

        <div class="robot-form-field">
            <label for="robot_selected_keywords" id="robot-feed-link" class="robot-label"><?php esc_html_e( 'Selected Keywords', 'ai-robot' ); ?></label>
            <textarea class="robot-form-control" id="robot-selected-keywords" rows="5" cols="20" name="robot_selected_keywords" required="required"><?php if(isset($settings['robot_selected_keywords'])){echo esc_html($settings['robot_selected_keywords']);}?></textarea>
        </div>


    </div>

</div>
