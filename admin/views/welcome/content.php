<?php
$languages = array(
    "US_en" => "English (United States)",
    "GB_en" => "English (United Kingdom)",
    "CA_en" => "English (Canada)",
    "AU_en" => "English (Australia)",
    "SG_en" => "English (Singapore)",
    "BW_en" => "English (Botswana)",
    "ET_en" => "English (Ethiopia)",
    "GH_en" => "English (Ghana)",
    "ID_en" => "English (Indonesia)",
    "IE_en" => "English (Ireland)",
    "IL_en" => "English (Israel)",
    "KE_en" => "English (Kenya)",
    "LV_en" => "English (Latvia)",
    "MY_en" => "English (Malaysia)",
    "NA_en" => "English (Namibia)",
    "NZ_en" => "English (New Zealand)",
    "NG_en" => "English (Nigeria)",
    "PK_en" => "English (Pakistan)",
    "PH_en" => "English (Philippines)",
    "ZA_en" => "English (South Africa)",
    "TZ_en" => "English (Tanzania)",
    "UG_en" => "English (Uganda)",
    "ZW_en" => "English (Zimbabwe)",
    "ID_id" => "Bahasa Indonesia (Indonesia)",
    "CZ_cs" => "Čeština (Česko)",
    "DE_de" => "Deutsch (Deutschland)",
    "AT_de" => "Deutsch (Österreich)",
    "CH_de" => "Deutsch (Schweiz)",
    "AR_es-419" => "Español (Argentina)",
    "CL_es-419" => "Español (Chile)",
    "CO_es-419" => "Español (Colombia)",
    "CU_es-419" => "Español (Cuba)",
    "US_es-419" => "Español (Estados Unidos)",
    "MX_es-419" => "Español (México)",
    "PE_es-419" => "Español (Perú)",
    "VE_es-419" => "Español (Venezuela)",
    "BE_fr" => "Français (Belgique)",
    "CA_fr" => "Français (Canada)",
    "FR_fr" => "Français (France)",
    "MA_fr" => "Français (Maroc)",
    "SN_fr" => "Français (Sénégal)",
    "CH_fr" => "Français (Suisse)",
    "IT_it" => "Italiano (Italia)",
    "LT_lt" => "Latviešu (Latvija)",
    "HU_hu" => "Magyar (Magyarország)",
    "BE_nl" => "Nederlands (België)",
    "NL_nl" => "Nederlands (Nederland)",
    "NO_no" => "Norsk (Norge)",
    "PL_pl" => "Polski (Polska)",
    "BR_pt-419" => "Português (Brasil)",
    "PT_pt-150" => "Português (Portugal)",
    "RO_ro" => "Română (România)",
    "SK_sk" => "Slovenčina (Slovensko)",
    "SI_sl" => "Slovenščina (Slovenija)",
    "SE_sv" => "Svenska (Sverige)",
    "VN_vi" => "Tiếng Việt (Việt Nam)",
    "TR_tr" => "Türkçe (Türkiye)",
    "GR_el" => "Ελληνικά (Ελλάδα)",
    "BG_bg" => "Български (България)",
    "RU_ru" => "Русский (Россия)",
    "UA_ru" => "Русский (Украина)",
    "RS_sr" => "Српски (Србија)",
    "UA_uk" => "Українська (Україна)",
    "IL_he" => "עברית (ישראל)",
    "AE_ar" => "العربية (الإمارات العربية المتحدة)",
    "SA_ar" => "العربية (المملكة العربية السعودية)",
    "LB_ar" => "العربية (لبنان)",
    "EG_ar" => "العربية (مصر)",
    "IN_mr" => "मराठी (भारत)",
    "IN_hi" => "हिन्दी (भारत)",
    "BD_bn" => "বাংলা (বাংলাদেশ)",
    "IN_ta" => "தமிழ் (இந்தியா)",
    "IN_te" => "తెలుగు (భారతదేశం)",
    "IN_ml" => "മലയാളം (ഇന്ത്യ)",
    "TH_th" => "ไทย (ไทย)",
    "CN_zh-Hans" => "中文 (中国)",
    "TW_zh-Hant" => "中文 (台灣)",
    "HK_zh-Hant" => "中文 (香港)",
    "JP_ja" => "日本語 (日本)",
    "KR_ko" => "한국어 (대한민국)",
);

$types = array(
    "rss" => "RSS Feed",
    "youtube" => "Youtube",
    "vimeo" => "Vimeo",
    "flickr" => "Flickr",
    "twitter" => "Twitter",
    "instagram" => "Instagram"
);

$modes = array(
    "robot_mode_smart" => "Smart",
    "robot_mode_manually" => "Manually"
);

$authors = get_users();

$api_data = Ai_Robot_Addon_Loader::get_instance()->get_addon_data('open-ai');
?>
<div class="wrap" id="robot-welcome-wrap">
    <form id="robot-generate-campaign-form">
        <section class="cd-slider-wrapper">
            <ul class="cd-slider">
                <li class="robot-slide visible robot-first-slide">
                    <div>
                        <img class="robot-logo-big" src="<?php echo esc_url(AI_ROBOT_URL.'/assets/images/robot.png'); ?>">
                        <p>
                        <?php
                            printf(
                                esc_html__( 'Thank you for choosing Ai Robot %1$s, the most intuitive and extensible tool to generate WordPress posts from OpenAI and ChatGPT! - %2$s', 'ai-robot' ),
                                AI_ROBOT_VERSION,
				                '<a href="https://wpairobot.com" class="robot-welcome-homepage" target="_blank">Visit Plugin Homepage</a>'
                            );
                        ?>
                        </p>
                        <?php
                            if(  isset($api_data['api_key']) && !empty($api_data['api_key'])  ){
                        ?>
                        <p>
                        <?php _e('In this short tutorial we will guide you through some of the basic settings to get the most out of our plugin. ', 'ai-robot'); ?>
                        </p>
                        <?php } else { ?>
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
                    </div>

                </li>

                <li class="robot-slide robot-slide-campaign-name">
                    <div>
                        <h2><?php _e('Campaign Name', 'ai-robot'); ?></h2>
                        <p><?php _e("Name your new campaign, then let's start auto blogging!", 'ai-robot'); ?></p>
                        <input
                            type="text"
                            name="robot_campaign_name"
                            placeholder="<?php esc_html_e( 'Enter your Campaign Name here', 'ai-robot' ); ?>"
                            value=""
                            class="robot_campaign_name"
                            aria-labelledby="robot_campaign_name"
                        />
                        <span class="robot-error-message-name" style="display: none;"><?php _e("Form name cannot be empty.", 'ai-robot'); ?></span>
                    </div>
                </li>

                <li class="robot-slide robot-generate-slide">
                    <div>
                        <h2><?php _e('Topic Keywords', 'ai-robot'); ?></h2>
                        <p><?php _e('Choose the topic keywords you\'d like to use as the news source of your campaign. You can select multiple keywords for one campaign', 'ai-robot'); ?></p>
                        <div id="robot-tags-wrap">
                            <div class="input">
                                <div class="tags"></div>
                                <input type="text" name="tag" autofocus id="robot-search" placeholder="<?php esc_attr_e('Search keywords here', 'ai-robot') ?>" value="">
                            </div>
                            <input type="hidden" value="" id="robot-selected-keywords" name="rss_selected_keywords">
                        </div>
                        <span class="robot-error-message-keywords" style="display: none;"><?php _e("Keywords cannot be empty.", 'ai-robot'); ?></span>
                        <div class="robot-search-results-wrapper">
                            <ul class="search-result-list">
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="robot-slide">
                    <div>
                        <h2><?php _e('Language', 'ai-robot'); ?></h2>
                        <p><?php _e('Choose your current language and location for new campaign. You can select only one language for each campaign.', 'ai-robot'); ?></p>
                        <span class="dropdown-el robot-init-language-selector">
                            <?php foreach ( $languages as $key => $value ) : ?>
                                <input type="radio" name="robot_init_language" value="<?php echo esc_attr( $key ); ?>" <?php if($key == 'US_en'){echo 'checked="checked"';} ?> id="<?php echo esc_attr( $key ); ?>">
                                <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></label>
                            <?php endforeach; ?>
                        </span>
                    </div>
                </li>

                <li class="robot-slide robot-slide-temperature">
                    <div class="robot-slide-temperature-settings">
                        <h2><?php _e('Temperature', 'ai-robot'); ?></h2>
                        <p><?php _e("What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.", 'ai-robot'); ?></p>
                        <input
                            type="number"
                            name="temperature"
                            value="1"
                            class="temperature"
                            aria-labelledby="temperature"
                        />
                    </div>
                    <span class="robot-error-message-temperature" style="display: none;"><?php _e("Max temperature is 2.", 'ai-robot'); ?></span>
                </li>

                <li class="robot-slide robot-slide-max-tokens">
                        <div class="robot-slide-tokens-settings">
                            <h2><?php _e('Max Tokens', 'ai-robot'); ?></h2>
                            <p><?php _e("The maximum number of tokens to generate in the chat completion. The total length of input tokens and generated tokens is limited by the model's context length.", 'ai-robot'); ?></p>
                            <input
                                type="number"
                                name="max_tokens"
                                value="500"
                                class="max_tokens"
                                aria-labelledby="max_tokens"
                            />
                        </div>
                </li>

                <li class="robot-slide robot-last-slide">
                    <div>
                        <svg style="margin-bottom: 25px;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 48 48" xml:space="preserve" width="64" height="64"><g class="nc-icon-wrapper"><path fill="#FFD764" d="M24,47C11.31738,47,1,36.68213,1,24S11.31738,1,24,1s23,10.31787,23,23S36.68262,47,24,47z"></path> <path fill="#444444" d="M17,19c-0.55273,0-1-0.44775-1-1c0-1.10303-0.89746-2-2-2s-2,0.89697-2,2c0,0.55225-0.44727,1-1,1 s-1-0.44775-1-1c0-2.20557,1.79395-4,4-4s4,1.79443,4,4C18,18.55225,17.55273,19,17,19z"></path> <path fill="#444444" d="M37,19c-0.55273,0-1-0.44775-1-1c0-1.10303-0.89746-2-2-2s-2,0.89697-2,2c0,0.55225-0.44727,1-1,1 s-1-0.44775-1-1c0-2.20557,1.79395-4,4-4s4,1.79443,4,4C38,18.55225,37.55273,19,37,19z"></path> <path fill="#FFFFFF" d="M35.6051,32C35.85382,31.03912,36,30.03748,36,29c0-0.55225-0.44727-1-1-1H13c-0.55273,0-1,0.44775-1,1 c0,1.03748,0.14618,2.03912,0.3949,3H35.6051z"></path> <path fill="#AE453E" d="M12.3949,32c1.33734,5.16699,6.02551,9,11.6051,9s10.26776-3.83301,11.6051-9H12.3949z"></path> <path fill="#FA645A" d="M18.01404,39.38495C19.77832,40.40594,21.81903,41,24,41s4.22168-0.59406,5.98596-1.61505 C28.75952,37.35876,26.54126,36,24,36S19.24048,37.35876,18.01404,39.38495z"></path></g></svg>
                        <h2><?php _e('Hooooray!', 'ai-robot'); ?></h2>
                        <p><?php _e('You\'re now ready to begin using Ai Robot! Please click the following button to generate your campaign', 'ai-robot'); ?></p>
                        <p><a href="<?php echo admin_url('admin.php?page=ai-robot') ?>" class="robot-welcome-link-button robot-generate-campaign"><?php _e('Generate your campaign', 'ai-robot'); ?></a></p>
                </li>
            </ul> <!-- .cd-slider -->

            <div class="cd-slider-navigation">
                <a class="robot-welcome-prev" style="display: none" href="#"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" xml:space="preserve" width="16" height="16"><g class="nc-icon-wrapper" fill="#ffffff"><path fill="#ffffff" d="M17,23.414L6.293,12.707c-0.391-0.391-0.391-1.023,0-1.414L17,0.586L18.414,2l-10,10l10,10L17,23.414z"></path></g></svg><?php _e('Previous', 'ai-robot'); ?></a>
                <a class="robot-welcome-next" href="#"><?php _e('Next', 'ai-robot'); ?><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" xml:space="preserve" width="16" height="16"><g class="nc-icon-wrapper" fill="#ffffff"><path fill="#ffffff" d="M7,23.414L5.586,22l10-10l-10-10L7,0.586l10.707,10.707c0.391,0.391,0.391,1.023,0,1.414L7,23.414z"></path></g></svg></a>
            </div>

            <div class="cd-svg-cover" data-step1="M1402,800h-2V0.6c0-0.3,0-0.3,0-0.6h2v294V800z" data-step2="M1400,800H383L770.7,0.6c0.2-0.3,0.5-0.6,0.9-0.6H1400v294V800z" data-step3="M1400,800H0V0.6C0,0.4,0,0.3,0,0h1400v294V800z" data-step4="M615,800H0V0.6C0,0.4,0,0.3,0,0h615L393,312L615,800z" data-step5="M0,800h-2V0.6C-2,0.4-2,0.3-2,0h2v312V800z" data-step6="M-2,800h2L0,0.6C0,0.3,0,0.3,0,0l-2,0v294V800z" data-step7="M0,800h1017L629.3,0.6c-0.2-0.3-0.5-0.6-0.9-0.6L0,0l0,294L0,800z" data-step8="M0,800h1400V0.6c0-0.2,0-0.3,0-0.6L0,0l0,294L0,800z" data-step9="M785,800h615V0.6c0-0.2,0-0.3,0-0.6L785,0l222,312L785,800z" data-step10="M1400,800h2V0.6c0-0.2,0-0.3,0-0.6l-2,0v312V800z">
                <svg height='100%' width="100%" preserveAspectRatio="none" viewBox="0 0 1400 800">
                <title><?php _e('SVG cover layer', 'ai-robot'); ?></title>
                <desc><?php _e('an animated layer to switch from one slide to the next one', 'ai-robot'); ?></desc>
                <path id="cd-changing-path" d="M1402,800h-2V0.6c0-0.3,0-0.3,0-0.6h2v294V800z"/>
                </svg>
            </div>  <!-- .cd-svg-cover -->
        </section> <!-- .cd-slider-wrapper -->
        <input type="hidden" value="<?php esc_html_e( $authors[0]->data->user_login ); ?>" name="robot_post_author">
    </form>
</div>