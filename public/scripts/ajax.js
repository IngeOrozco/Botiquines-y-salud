window.addEventListener('load', () => {
    var allAjaxForm = document.querySelectorAll('.ajax-form')

    if (allAjaxForm) {
        allAjaxForm.forEach(ajaxForm => {
            if (!ajaxForm.hasEventListener) {
                ajaxForm.addEventListener('click', (e) => {
                    if (e.target.tagName == 'BUTTON' && e.target.type == 'submit') {
                        e.preventDefault()

                        data = {}
                        data[e.target.name] = ''
                        
                        new FormData(ajaxForm).forEach(function (value, key) {
                            data[key] = value
                        })

                        $.ajax({
                            url: ajaxForm.action,
                            data: data,
                            type: 'POST',
                        
                            success: function (rta) {
                                $(ajaxForm.dataset.redirect).html(rta)
                            }
                        })
                    }
                })

                ajaxForm.hasEventListener = true
            }
        })
    }

    document.addEventListener('click', (e) => {
        if (e.target.dataset.ajax && e.target.tagName != 'SELECT') {
            ajax = e.target.dataset.ajax
            redirect = e.target.dataset.redirect ?? null

            if (ajax != 'remove') {
                box = e.target.dataset.box ?? null

                window.win_func_ajax({ 'ajax': ajax, 'box': box, 'redirect': redirect })
            } else {
                $(redirect).html('')
            }
        }
    })
})