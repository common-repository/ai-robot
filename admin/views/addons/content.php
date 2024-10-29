<?php
$addons = Ai_Robot_Admin_Addons::get_list();
?>
<div class="wphobby-wrap">
        <div class="hui-addons">
            <?php foreach ( $addons as $addon => $data ) { ?>
            <div class="hui-addon-card" tabindex="0">
                <div class="hui-addon-card--image" aria-hidden="true">
                    <img src="<?php echo esc_url( $data['thumbnail'] );?>" aria-hidden="true">
                    <div class="hui-addon-card--mask" aria-hidden="true"></div>
                </div>
                <div class="hui-addon-info">
                    <h4><?php echo esc_html($data['name']);?></h4>
                    <span><?php echo esc_html($data['price']);?></span>
                </div>
                <p class="hui-screen-reader-highlight" tabindex="0"><?php esc_html_e( 'Tailored to promote your seasonal offers in a modern layout.', 'ai-robot' ); ?></p>
                <button class="robot-addon-preview-button">
					<span class="sui-icon-eye" aria-hidden="true"></span>
                    <?php esc_html_e( 'Preview', 'ai-robot' ); ?>
                </button>
                <button class="robot-button robot-button-blue robot-addon-purchase-button" aria-label="Build from Minimalist addon" data-addon="<?php echo esc_attr( $addon );?>">
                    <?php esc_html_e( 'Purchase', 'ai-robot' ); ?>
                </button>
            </div>
            <?php } ?>
        </div>
</div>

