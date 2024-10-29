(function($){

    "use strict";

    var AiRobotList = {

        init: function()
        {
            // Document ready.
            $( document ).ready( AiRobotList._loadPopup() );
            $( document ).ready( AiRobotList._displayDetails() );



            this._bind();
        },

        /**
         * Binds events for the Ai Robot List.
         *
         * @since 1.0.0
         * @access private
         * @method _bind
         */
        _bind: function()
        {
            $( document ).on('click', '.robot-dropdown-anchor', AiRobotList._displayActions );
            $( document ).on('click', '.robot-close-popup', AiRobotList._closePopup );
            $( document ).on('click', '.robot-delete-action', AiRobotList._deleteAction );
            $( document ).on('click', '#robot-check-all-campaigns', AiRobotList._checkAll );
            $( document ).on('click', '.robot-bulk-action-button', AiRobotList._preparePost );

        },

        /**
         * Display Actions
         *
         */
        _displayActions: function( event ) {

            event.preventDefault();


            if($(this).closest('.robot-dropdown').find('.robot-dropdown-list').hasClass('active')){
                $(this).closest('.robot-dropdown').find('.robot-dropdown-list').removeClass('active');
            }else{
                $(this).closest('.robot-dropdown').find('.robot-dropdown-list').addClass('active');
            }

        },

        /**
         * Load Popup
         *
         */
        _loadPopup: function( ) {

            $('.open-popup-delete').magnificPopup({
                type:'inline',
                midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
                // Delay in milliseconds before popup is removed
                removalDelay: 300,

                // Class that is added to popup wrapper and background
                // make it unique to apply your CSS animations just to this exact popup
                callbacks: {
                    beforeOpen: function() {
                        this.st.mainClass = this.st.el.attr('data-effect');
                    }
                },
            });

        },

        /**
         * Close Popup
         *
         */
        _closePopup: function( ) {

            $('.open-popup-delete').magnificPopup('close');

        },

        /**
         * Delete Action
         *
         */
        _deleteAction: function( ) {

            var data = $(this).data('campaign-id');

            $('.robot-delete-id').val(data);


        },

        /**
         * Check All
         *
         */
        _checkAll: function( ) {

            if($(this).prop('checked')){
                $('.robot-check-single-campaign').prop('checked', true);
            }else{
                $('.robot-check-single-campaign').prop('checked', false);

            }

        },

        /**
         * Prepare data before post action
         *
         */
        _preparePost: function( ) {

            var ids = [];
            $('.robot-check-single-campaign').each(function( index ) {
                if($(this).prop('checked')){
                    var value = $(this).val();
                    ids.push(value);
                }
            });

            $('#robot-select-campaigns-ids').val(ids);

        },

        /**
         * Display Campaign Details
         *
         */
        _displayDetails: function( ) {

            var indicator = $('.robot-accordion-open-indicator');
            indicator.on('click', function(){
                $(this).closest('.robot-accordion-item').find('.robot-accordion-item-body').toggleClass('robot-campaign-detail-hide');
                $(this).closest('.robot-accordion-item').find('.robot-accordion-item-date').toggleClass('robot-campaign-detail-hide');
            });



        },


    };

    /**
     * Initialize AiRobotList
     */
    $(function(){
        AiRobotList.init();
    });

})(jQuery);
