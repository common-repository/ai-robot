(function($){

    "use strict";

    var AiRobotWizard = {

        init: function()
        {
            // Document ready.
            this._bind();
        },

        /**
         * Binds events for the Ai Robot Wizard.
         *
         * @since 1.0.0
         * @access private
         * @method _bind
         */
        _bind: function()
        {

            $( document ).on('click', '.robot-wizard-permissions', AiRobotWizard._showPermission );
            $( document ).on('click', '.robot-wizard-opt-in', AiRobotWizard._optIn );
            $( document ).on('click', '.robot-wizard-skip', AiRobotWizard._skip );

        },

        /**
         * Show permission details
         *
         */
        _showPermission: function( event ) {

            event.preventDefault();

            if ($("#robot_wizard_set_up").hasClass("wizard-set-up")){
				$("#robot_wizard_set_up").css("display", "none");
				$("#robot_wizard_set_up").removeClass("wizard-set-up");
			}else{
				$("#robot_wizard_set_up").css("display", "block");
				$("#robot_wizard_set_up").addClass("wizard-set-up");
			}
        },

        /**
         * Opt-in
         *
         */
        _optIn: function( event ) {

            event.preventDefault();

            console.log('click opt in');

            $.ajax({
                    url  : Ai_Robot_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    data : {
                        action       : 'ai_robot_save_user_data',
                        type         : 'opt-in',
                        _ajax_nonce  : Ai_Robot_Data._ajax_nonce,
                    },
                    beforeSend: function() {
                    },
                })
                .fail(function( jqXHR ){
                    console.log( jqXHR.status + ' ' + jqXHR.responseText);
                    window.location.href = "admin.php?page=ai-robot";
                })
                .done(function ( option ) {
                    if( false === option.success ) {
                        console.log(option);
                    } else {
                        console.log(option);
                        window.location.href = "admin.php?page=ai-robot";
                    }

                });

        },

        /**
         * Skip opt in
         *
         */
        _skip: function( event ) {

            event.preventDefault();

            console.log('click skip.');

            $.ajax({
                url  : Ai_Robot_Data.ajaxurl,
                type : 'POST',
                dataType: 'json',
                data : {
                    action       : 'ai_robot_save_user_data',
                    type         : 'skip',
                    _ajax_nonce  : Ai_Robot_Data._ajax_nonce,
                },
                beforeSend: function() {
                },
            })
            .fail(function( jqXHR ){
                console.log( jqXHR.status + ' ' + jqXHR.responseText);
            })
            .done(function ( option ) {
                if( false === option.success ) {
                    console.log(option);
                } else {
                    console.log(option);
                    window.location.href = "admin.php?page=ai-robot";
                }

            });

        },

    };

    /**
     * Initialize AiRobotWizard
     */
    $(function(){
        AiRobotWizard.init();
    });

})(jQuery);
