(function($){

    "use strict";

    var AiRobotLicense = {

        init: function()
        {
            // Document ready.
            this._bind();
        },

        /**
         * Binds events for the Ai Robot License.
         *
         * @since 1.0.0
         * @access private
         * @method _bind
         */
        _bind: function()
        {
            $( document ).on('click', '.robot-trigger-license-action', AiRobotLicense._connect );
        },

        /**
         * connect remote api
         *
         */
        _connect: function( event ) {

            event.preventDefault();

            console.log('click license action');

            var formdata = $('.robot-license-form').serializeArray();
            var fields = {};
            $(formdata ).each(function(index, obj){
                fields[obj.name] = obj.value;
            });

            console.log(fields);

            $.ajax({
                    url  : Ai_Robot_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    data : {
                        action       : 'ai_robot_license_connect',
                        fields_data  : fields,
                        _ajax_nonce  : Ai_Robot_Data._ajax_nonce,
                    },
                    beforeSend: function() {
                        $('.robot-license-action').html('<div id="loader-6"><span></span><span></span><span></span><span></span><span></span><div>');
                    },
                })
                .fail(function( jqXHR ){
                    console.log( jqXHR.status + ' ' + jqXHR.responseText);
                    //window.location.href = "admin.php?page=ai-robot-license";
                })
                .done(function ( option ) {
                    if( false === option.success ) {
                        console.log(option);
                    } else {
                        console.log(option);
                    }

                    $('.robot-license-verify-message').html(option.data);
                    window.location.href = "admin.php?page=ai-robot-license";

                });

        },



    };

    /**
     * Initialize AiRobotLicense
     */
    $(function(){
        AiRobotLicense.init();
    });

})(jQuery);
