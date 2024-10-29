<div id="test-popup" class="white-popup mfp-with-anim mfp-hide">

			<div class="step-1">
				<div class="robot-box-header robot-block-content-center">
					<h3 class="robot-box-title type-title"><?php esc_html_e( 'Choose a type', 'ai-robot' ); ?></h3>
				</div>

                <div class="robot-box-body robot-block-content-center">

                    <p class="robot-description">
                        <?php esc_html_e( 'Select your campaign source data type.', 'ai-robot' ); ?>
                    </p>

                </div>

				<div class="robot-box-selectors robot-box-selectors-col-2">
					<ul class="type-list">
						<li>
							<label for="robot-type-rss" class="robot-box-selector">
								<input type="radio" name="robot-selected-type" id="robot-type-rss" class="robot-type" value="rss" checked="checked">
								<span>
									<ion-icon name="logo-rss" class="robot-icon"></ion-icon>
									<?php esc_html_e( 'Feed', 'ai-robot' ); ?>
								</span>
							</label>
						</li>
						<li>
							<label for="robot-type-social" class="robot-box-selector">
								<input type="radio" name="robot-selected-type" id="robot-type-social" class="robot-type" value="social">
								<span>
									<ion-icon name="share-social" class="robot-icon"></ion-icon>
									<?php esc_html_e( 'Social Media', 'ai-robot' ); ?>
								</span>
							</label>
						</li>
						<li>
							<label for="robot-type-video" class="robot-box-selector">
								<input type="radio" name="robot-selected-type" id="robot-type-video" class="robot-type" value="video">
								<span>
									<ion-icon name="videocam" class="robot-icon"></ion-icon>
									<?php esc_html_e( 'Video', 'ai-robot' ); ?>
								</span>
							</label>
						</li>
						<li>
							<label for="robot-type-sound" class="robot-box-selector">
								<input type="radio" name="robot-selected-type" id="robot-type-sound" class="robot-type" value="sound">
								<span>
									<ion-icon name="musical-notes" class="robot-icon"></ion-icon>
									<?php esc_html_e( 'Sound', 'ai-robot' ); ?>
								</span>
							</label>
						</li>
					</ul>
				</div>

				<div class="robot-box-footer">
					<div class="robot-actions-right">

						<button class="robot-button ai-robot-select-type">
							<span class="robot-loading-text"><?php esc_html_e( 'Continue', 'ai-robot' ); ?></span>
							<i class="robot-icon-load robot-loading" aria-hidden="true"></i>
						</button>

					</div>
				</div>
			</div>

			<div class="step-2">
				<div class="robot-box-header robot-block-content-center">

					<h3 class="robot-box-title source-title"><?php esc_html_e( 'Choose a source', 'ai-robot' ); ?></h3>

				</div>

				<div class="robot-box-selectors robot-box-selectors-col-2">
					<ul class="source-list">
						<script type="text/template" id="tmpl-robot-source-list">
							<# if ( data.length ) { #>
								<# for ( key in data ) { #>
									<li>
										<label for="robot-selected-source" class="robot-box-selector">
											<input type="radio"  name="robot-selected-source" value="{{{ data[ key ].value }}}">
											<span class="robot-source" data-source="{{{ data[ key ].value }}}">
												<ion-icon name="{{{ data[ key ].icon }}}" class="robot-icon"></ion-icon>
													{{{ data[ key ].value }}}
											</span>
										</label>
									</li>
									<# } #>
										<# } else { #>
											<p class="no-source">
												<?php esc_html_e( 'No source.', 'ai-robot' ); ?>
											</p>
											<# } #>
						</script>
					</ul>
				</div>

				<div class="robot-box-footer">

					<div class="robot-actions-left">

						<button class="robot-button ai-robot-select-previous">
							<span class="robot-loading-text"><?php esc_html_e( 'Previous', 'ai-robot' ); ?></span>
							<i class="robot-icon-load robot-loading" aria-hidden="true"></i>
						</button>

					</div>

					<div class="robot-actions-right">

						<button class="robot-button robot-go-wizard">
							<span class="robot-loading-text"><?php esc_html_e( 'Continue', 'ai-robot' ); ?></span>
							<i class="robot-icon-load robot-loading" aria-hidden="true"></i>
						</button>

					</div>

				</div>
			</div>

			<img src="<?php echo esc_url(AI_ROBOT_URL.'/assets/images/robot.png'); ?>" class="robot-image robot-image-center" aria-hidden="true" alt="<?php esc_attr_e( 'Ai Robot', 'ai-robot' ); ?>">
</div>

