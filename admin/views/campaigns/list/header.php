<?php $count = $this->countModules(); ?>
<h1 class="robot-header-title"><?php esc_html_e( 'Campaigns', 'ai-robot' ); ?></h1>

<div class="robot-actions-left">
    <a href="<?php echo admin_url( 'admin.php?page=ai-robot-welcome' ); ?>" class="robot-button robot-button-blue robot-button-blue-first">
        <?php esc_html_e( 'Create', 'ai-robot' ); ?>
    </a>
</div>

<div class="robot-actions-right">
        <a href="https://wpairobot.com/document/" target="_blank" class="robot-button robot-button-ghost">
            <ion-icon class="robot-icon-document" name="document-text-sharp"></ion-icon>
            <?php esc_html_e( 'View Documentation', 'ai-robot' ); ?>
        </a>
</div>

