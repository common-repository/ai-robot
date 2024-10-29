<?php
$full_content_checked = isset($settings['robot_content_options']) && $settings['robot_content_options']== 'full_content' ? 'checked' : '';
$excerpt_checked = isset($settings['robot_content_options']) && $settings['robot_content_options']== 'excerpt' ? 'checked' : '';

if(!isset($settings['robot_content_options'])){
    $full_content_checked  = 'checked';
}
?>
<div class="robot-box-settings-row">

    <div class="robot-box-settings-col-1">
        <span class="robot-settings-label"><?php esc_html_e( 'Post Content', 'ai-robot' ); ?></span>
    </div>

    <div class="robot-box-settings-col-2">
        <div class="robot-content-options">
            <input type="radio" name="robot_content_options" id="robot_full_content" value="full_content" <?php echo esc_attr($full_content_checked); ?> />
            <label for="robot_full_content">Full Content</label>
            <input type="radio" name="robot_content_options" id="robot_excerpt" value="excerpt" <?php echo esc_attr($excerpt_checked); ?>/>
            <label for="robot_excerpt">Excerpt</label>
        </div>
    </div>

</div>