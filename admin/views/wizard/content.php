
<div class="page-container header-wizard">
	<div class="page-content">
		<div class="row row-custom">
			<div class="robot-wizard-text textalign">
				<p><?php echo esc_attr( __( 'Hi admin!', 'ai-robot' ) ); ?></p>
				<p><?php echo esc_attr( __( 'Never ever miss an opportunity to opt in for Email Notifications / Announcements about exciting New Features and Update Releases.', 'ai-robot' ) ); ?></p>
				<p><?php echo esc_attr( __( 'Contribute in helping us making our plugin compatible with most plugins and themes by allowing to share non-sensitive information about your website.', 'ai-robot' ) ); ?></p>
				<p><?php echo esc_attr( __( 'If you opt in, some data about your usage of Ai Robot will be sent to our servers for Compatiblity Testing Purposes and Email Notifications.', 'ai-robot' ) ); ?></p>
		    </div>
		</div>
		<div class="row row-custom">
			<div class="robot-wizard-text">
				<div class="textalign">
					<p><?php echo esc_attr( __( 'If you\'re not ready to Opt-In, that\'s ok too!', 'ai-robot' ) ); ?></p>
					<p><strong><?php echo esc_attr( __( 'Ai Robot will still work fine.', 'ai-robot' ) ); ?></strong></p>
				</div>
			</div>
			<div class="robot-wizard-text">
				<a href="#permissions" class="robot-wizard-permissions"><?php echo esc_attr( __( 'What permissions are being granted?', 'ai-robot' ) ); ?></a>
			</div>
			<div class="robot-wizard-text" style="display:none;" id="robot_wizard_set_up">
				<div class="col-md-6">
					<ul>
						<li>
							<i class="dashicons dashicons-admin-users cpo-dashicons-admin-users"></i>
							<div class="admin">
								<span><strong><?php echo esc_attr( __( 'User Details', 'ai-robot' ) ); ?></strong></span>
								<p><?php echo esc_attr( __( 'Name and Email Address', 'ai-robot' ) ); ?></p>
							</div>
						</li>
					</ul>
				</div>
				<div class="col-md-6 align align2">
					<ul>
						<li>
							<i class="dashicons dashicons-admin-plugins cpo-dashicons-admin-plugins"></i>
							<div class="admin-plugins">
								<span><strong><?php echo esc_attr( __( 'Current Plugin Status', 'ai-robot' ) ); ?></strong></span>
								<p><?php echo esc_attr( __( 'Activation, Deactivation and Uninstall', 'ai-robot' ) ); ?></p>
							</div>
						</li>
					</ul>
				</div>
				<div class="col-md-6">
					<ul>
						<li>
							<i class="dashicons dashicons-testimonial cpo-dashicons-testimonial"></i>
								<div class="testimonial">
									<span><strong><?php echo esc_attr( __( 'Notifications', 'ai-robot' ) ); ?></strong></span>
									<p><?php echo esc_attr( __( 'Updates &amp; Announcements', 'ai-robot' ) ); ?></p>
								</div>
						</li>
					</ul>
				</div>
				<div class="col-md-6 align2">
					<ul>
						<li>
							<i class="dashicons dashicons-welcome-view-site cpo-dashicons-welcome-view-site"></i>
							<div class="settings">
								<span><strong><?php echo esc_attr( __( 'Website Overview', 'ai-robot' ) ); ?></strong></span>
								<p><?php echo esc_attr( __( 'Site URL, WP Version, PHP Info, Plugins &amp; Themes Info', 'ai-robot' ) ); ?></p>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="robot-wizard-text allow">
				<div class="robot-wizard-actions">
					<a href="#robot-opt-in" class="button button-primary-wizard robot-wizard-opt-in">
						<strong><?php echo esc_attr( __( 'Opt-In &amp; Continue', 'ai-robot' ) ); ?> </strong>
						<i class="dashicons dashicons-arrow-right-alt cpo-dashicons-arrow-right-alt"></i>
					</a>
					<a href="#robot-skip" class="button button-secondary-wizard robot-wizard-skip" tabindex="2">
						<strong><?php echo esc_attr( __( 'Skip &amp; Continue', 'ai-robot' ) ); ?> </strong>
						<i class="dashicons dashicons-arrow-right-alt cpo-dashicons-arrow-right-alt"></i>
					</a>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>
