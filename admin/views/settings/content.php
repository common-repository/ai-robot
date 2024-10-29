<div class="robot-row-with-sidenav">

    <div class="robot-sidenav">
        <div class="robot-mobile-select">
            <span class="robot-select-content"><?php esc_html_e( 'Global Settings', 'ai-robot' ); ?></span>
            <ion-icon name="chevron-down" class="robot-icon-down"></ion-icon>
        </div>

        <ul class="robot-vertical-tabs robot-sidenav-hide-md">

            <li class="robot-vertical-tab current">
                <a href="#" data-nav="notifications"><?php esc_html_e( 'Notifications', 'ai-robot' ); ?></a>
            </li>

            <li class="robot-vertical-tab">
                <a href="#" data-nav="general"><?php esc_html_e( 'General', 'ai-robot' ); ?></a>
            </li>

        </ul>

    </div>

    <div class="robot-box-tabs">
         <?php $this->template( 'settings/sections/tab-notifications' ); ?>
         <?php $this->template( 'settings/sections/tab-general' ); ?>
    </div>
</div>