var FXT = (function(FXT, $){

    $(function() {
        FXT.QuickMeta.init();
    });

    /**
     * Add click event to handle refreshing the featured
     * status of an item
     */
    FXT.QuickMeta = {
        init: function() {
            $('.post_meta_quick').on('change', this.updateState);
        },

        updateState: function(e) {
            var $this = $(this),
                $val = $this.val();

            if($this.attr('type') == 'checkbox')
                $val = $this.is(':checked') ? $this.val() : 0;


            $.post(ajaxurl, {
                 value: $val
                ,post_id: $this.data('post_id')
                ,field: $this.attr('name')
                ,action: 'testimonials_quick_meta'
            });
        }
    }

    return FXT;

})(FXT || {}, jQuery);