(function($){
    let backend = function() {
        this.settingsPage()
    }
    backend.prototype.constructor = backend;
    backend.prototype.settingsPage = function() {
        this.suggestionField();
    }
    backend.prototype.suggestionField = function() {
        let $wrap = $('.suggestion-field-setting');

        let $orderByWrap = $('.suggestion-orderby-field', $wrap);
        let $resetWrap = $('.suggestion-load-top-10-field', $wrap);
        let $listWrap = $('.suggestion-top-10-field', $wrap);

        let fieldTooggle = function() {
            let status = $('> select', $orderByWrap).val();
            $resetWrap.hide()
            $listWrap.hide()
            if('manual' == status) {
                $resetWrap.show()
                $listWrap.show()
            }
        }

        let $list = $('.suggestion-lists', $listWrap);

        $('> select', $orderByWrap).on('change', fieldTooggle);
        fieldTooggle();

        $('[data-keywords]', $resetWrap).on('click', function(event){
            let keywords = $(this).data('keywords')
            $('input[type=text]', $list).each(function(fieldIdx, $field){
                let thisVale = typeof keywords[fieldIdx] != 'undefined' ? keywords[fieldIdx] : '';
                $(this).val(thisVale);
            })
        })

        $list.sortable({
            placeholder: 'list-item suggestion-list-holder',
        });

        $('[data-remove]', $list).on('click', function(){
            let $list = $(this).closest('li.list-item');
            $('input[type=text]', $list).val('');
        })
    }
    window.lava = window.lava || {}
    window.lava.ajax_search = new backend;
})(jQuery);