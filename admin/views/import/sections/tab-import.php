<?php
$import_data = false;
if (isset($_FILES['import_file'])) {
    if ($_FILES['import_file']['error'] > 0) {
        echo '<div class="error"><p>'.__('Invalid file or file size too big.', 'ai-robot').'</p></div>';
    }else {
        $file_name = $_FILES['import_file']['name'];
		$ext = explode(".", $file_name);
        $file_ext = strtolower(end($ext));
        $file_size = $_FILES['import_file']['size'];
        if ($file_ext == "json") {
            $encode_data = file_get_contents($_FILES['import_file']['tmp_name']);
            $import_data = json_decode($encode_data, true);
        }else {
			echo '<div class="error"><p>'.__('Invalid file or file size too big.', 'ai-robot').'</p></div>';
        }
    }

    /* Import campaigns */
    if(is_array($import_data)){
        foreach($import_data as $key => $item){
            $form_model = new Ai_Robot_Custom_Form_Model();
            $form_model->settings = $item;
            // status
            $form_model->status = Ai_Robot_Custom_Form_Model::STATUS_PUBLISH;
            // Save data
            $form_model->save();
        }
    }
    echo '<div class="updated"><p>'.__('Campaings has been imported successfully.', 'ai-robot').'</p></div>';
}


?>
<div id="import" class="robot-box-tab active" data-nav="import" >

    <div class="robot-box-header">
        <h2 class="robot-box-title"><?php esc_html_e( 'Import', 'ai-robot' ); ?></h2>
    </div>

    <form class="robot-settings-form" method="post" action="" enctype="multipart/form-data">

    <div class="robot-box-body">
        <div class="robot-box-settings-row">
            <div class="robot-box-settings-col-1">
                <span class="robot-settings-label"><?php esc_html_e( 'Import Campaigns', 'ai-robot' ); ?></span>
                <span class="robot-description"><?php esc_html_e( 'Import new campaigns from your other sites.', 'ai-robot' ); ?></span>
            </div>
            <div class="robot-box-settings-col-2">
                <div class="robot-import-file-wrapper">
					<input type="file" name="import_file" id="robot-import-file-input" />
				</div>
            </div>
        </div>
    </div>

    <div class="robot-box-footer">
        <div class="robot-actions-left">
            <button class="robot-button robot-button-blue" type="submit">
                <span class="robot-loading-text"><?php esc_html_e( 'Import', 'ai-robot' ); ?></span>
            </button>
        </div>
    </div>

    </form>



</div>


