<?php
$premium_link = '<a href="https://wpairobot.com/" target="_blank">' . __( 'premium version', 'ai-robot' ) . '</a>';
$document_link = '<a href="https://wpairobot.com/document/" target="_blank">' . __( 'document', 'ai-robot' ) . '</a>';
$demos = array(
	array(
		'href' => 'https://www.youtube.com/watch?v=eeuAVH5W2GM/',
		'demo' => 'RSS Campaign'
	),
	array(
		'href' => 'https://www.youtube.com/watch?v=fnu4hgrcATQ/',
		'demo' => 'Instagram Campaign'
	),
	array(
		'href' => 'https://www.youtube.com/watch?v=nDm58uxiZLE/',
		'demo' => 'Vimeo Campaign'
	),
	array(
		'href' => 'https://www.youtube.com/watch?v=X-kO589Byso/',
		'demo' => 'Flickr Campaign'
	),
	array(
		'href' => 'https://www.youtube.com/watch?v=m339MVd6tuA/',
		'demo' => 'Twitter Campaign'
	),
	array(
		'href' => 'https://www.youtube.com/watch?v=nHYa633aj3M/',
		'demo' => 'Youtube Campaign'
	),
	array(
		'href' => 'https://www.youtube.com/watch?v=W8lvU6Anj1c/',
		'demo' => 'Schedule Settings'
	),
	array(
		'href' => 'https://www.youtube.com/watch?v=M-fARSJFKF4/',
		'demo' => 'Post Template'
	),
	array(
		'href' => 'https://www.youtube.com/watch?v=anFfEyfrSFY/',
		'demo' => 'Set Feature Image'
	),
	array(
		'href' => 'https://www.youtube.com/watch?v=LwApQaIDb_M/',
		'demo' => 'Video Template'
	),
	array(
		'href' => 'https://www.youtube.com/watch?v=guFze2Krfjc/',
		'demo' => 'System Settings'
	),
	array(
		'href' => 'https://www.youtube.com/watch?v=dSGtphbXYdU/',
		'demo' => 'Logs System'
	),
);
$support_url = 'https://codecanyon.net/item/ai-robot/26798462/support/';
$document_url = 'https://wpairobot.com/document/';
$license_activated = get_option( 'ai_robot_license_activated');
$license_activated = 102;
$api_data = Ai_Robot_Addon_Loader::get_instance()->get_addon_data('open-ai');
?>
<div class="wrap about-wrap robot-welcome-wrap">
	<h1>
		<?php
              printf(
                  esc_html__( 'Welcome to Ai Robot %1$s', 'ai-robot' ),
                  AI_ROBOT_VERSION
              );
        ?>
	</h1>
	<div class="about-text">
		<p>
		<?php
              printf(
                  esc_html__( 'Thank you for choosing Ai Robot %1$s, the most intuitive and extensible tool to generate WordPress posts from OpenAI and ChatGPT! - %2$s', 'ai-robot' ),
                  AI_ROBOT_VERSION,
				  '<a href="https://wpairobot.com/" target="_blank">Visit Plugin Homepage</a>'
              );
        ?>
		</p>
		<?php
            if(  !isset($api_data['api_key']) && empty($api_data['api_key'])  ){
        ?>
		<p class="ai-robot-api-notice">
                        <?php
                            printf(
                                esc_html__( 'To use the features of AI Robot, you need to have an OpenAI account and create an API Key. Visit the %1$s and setup %2$s', 'ai-robot' ),
                                '<a href="https://beta.openai.com/account/api-keys" class="robot-welcome-homepage" target="_blank">OpenAI website</a>',
                                '<a href="'.esc_url ( admin_url( 'admin.php?page=ai-robot-integrations' ) ).'" class="robot-welcome-homepage" target="_blank">OpenAI API Key</a>'
                            );
                        ?>
        </p>
		<?php } ?>
		<a href="https://wpairobot.com" target="_blank">
    		<button class="robot-button robot-button-blue">
            	<?php esc_html_e( 'Get Pro Version', 'ai-robot' ); ?>
        	</button>
    		</a>
			<a href="https://www.spinrewriter.com/?ref=50f2e" target="_blank">
    		</a>
		<?php if ( empty($license_activated) || $license_activated != '102' ) : ?>
			<div class="robot-license-notice-message">
			<a href="<?php echo admin_url( 'admin.php?page=ai-robot-license' ); ?>">
    <button class="robot-button robot-button-blue">
            <?php esc_html_e( ' Please add your purchase code and activate the plugin
            ', 'ai-robot' ); ?>
        </button>
    </a>
            </div>
        <?php endif; ?>
	</div>
		<div class="robot-badge-logo">
			<img src="<?php echo esc_url(AI_ROBOT_URL.'/assets/images/robot.png'); ?>"aria-hidden="true" alt="<?php esc_attr_e( 'Ai Robot', 'ai-robot' ); ?>">
		</div>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active" href="#" data-nav="help">
				<?php esc_html_e( 'Getting Started', 'ai-robot' ); ?>
			</a>
			<a class="nav-tab" href="#" data-nav="demo">
				<?php esc_html_e( 'Demos', 'ai-robot' ); ?>
			</a>
			<a class="nav-tab" href="#" data-nav="support">
				<?php esc_html_e( 'Help & Support', 'ai-robot' ); ?>
			</a>
	</h2>
	<div class="robot-welcome-tabs">
	<div id="help" class="active nav-container">
		<div class="changelog section-getting-started">
			<div class="feature-section">
				<h2><?php esc_html_e( 'Create Your First Campaign', 'ai-robot' ); ?></h2>

				<img src="<?php echo esc_url(AI_ROBOT_URL.'/assets/images/create-campaign.png'); ?>" class="robot-help-screenshot" alt="<?php esc_attr_e( 'Ai Robot', 'ai-robot' ); ?>">

				<h4><?php printf( __( '1. <a href="%s" target="_blank">Add New Campaign</a>', 'ai-robot' ), esc_url ( admin_url( 'admin.php?page=ai-robot-welcome' ) ) ); ?></h4>
				<p><?php _e( 'To create your first campaign, simply click the Create button.', 'ai-robot' ); ?></p>

				<h4><?php _e( '2. Select Campaign Source Type', 'ai-robot' );?></h4>
				<p><?php _e( 'You will need to select the source type between RSS Feed, Social Media, Video.', 'ai-robot' ); ?></p>

				<h4><?php _e( '3. Save Your Campaign Settings', 'ai-robot' );?></h4>
				<p><?php _e( 'There are tons of settings to help you customize the campaign to suit your needs.', 'ai-robot' );?></p>
			</div>
		</div>
		<div class="changelog section-getting-started">
			<div class="robot-tip">
			<?php printf( __( 'Want to more custom campaign types and customize options? Check out all our %s.', 'ai-robot' ), $document_link ); ?>
			</div>
		</div>
		<div class="changelog section-getting-started">
			<div class="feature-section">
				<h2><?php _e( 'Manage Your Campaigns', 'ai-robot' ); ?></h2>

				<img src="<?php echo esc_url(AI_ROBOT_URL.'/assets/images/campaigns-list.png'); ?>" class="robot-help-screenshot" alt="<?php esc_attr_e( 'Ai Robot', 'ai-robot' ); ?>">

				<h4><?php printf( __( '1. <a href="%s" target="_blank">Go to Campaigns List</a>', 'ai-robot' ), esc_url ( admin_url( 'admin.php?page=ai-robot-campaign' ) ) ); ?></h4>
				<p><?php _e( 'We make your life easy! Just use the bulk actions you can publish, unpublish and delete campaigns. ', 'ai-robot' );?></p>

				<h4><?php _e( '2. Edit Campaigns', 'ai-robot' );?></h4>
				<p><?php _e( 'To edit any your campaign, simply click the Edit button.', 'ai-robot' ); ?></p>

			</div>
		</div>
	</div>
	<div id="demo" class="nav-container">
		<h2><?php _e( 'Videos Demo', 'ai-robot' ); ?></h2>
		<div class="demos_masonry">
		<?php
			foreach ( $demos as $demo ) {
		?>
				<div class="demo_section">
					<h3><a href="<?php echo esc_url($demo['href']); ?>" target="_blank" title="<?php __('Open demo in new tab','ai-robot'); ?>"><?php echo esc_html($demo['demo']); ?></a></h3>
				</div>
		<?php
			}
		?>

		</div>
	</div>
	<div id="support" class="nav-container">
		<h2><?php _e( "Need help? We're here for you...", 'ai-robot' ); ?></h2>
		<p class="document-center">
			<span class="dashicons dashicons-editor-help"></span>
			<a href="<?php echo esc_url ( $document_url ); ?>" target="_blank">
			<?php _e('Document','ai-robot'); ?>
			- <?php _e('The document articles will help you troubleshoot issues that have previously been solved.', 'ai-robot'); ?>
			</a>
		</p>
		<div class="feature-cta">
			<p><?php _e('Still stuck? Please open a support ticket and we will help:', 'ai-robot'); ?></p>
			<a target="_blank" href="<?php echo esc_url ( $support_url ); ?>"><?php _e('Open a support ticket', 'ai-robot' ); ?></a>
		</div>
	</div>
	</div>
</div>