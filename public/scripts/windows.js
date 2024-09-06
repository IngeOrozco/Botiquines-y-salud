/* ----------------------- Funcion Ajax ----------------------- */
window.win_func_ajax = function func_ajax(data) {
    if (json = data.box) {
        json = json.replace(/'/g, '"')
        json = JSON.parse(json)
    }

    $.ajax({
        url: data.ajax,
        data: json,
        type: 'POST',

        success: function (html) {
            $(data.redirect ?? document.body).html(html)
        }
    })
}

/* ----------------------- Funcion Regresar ----------------------- */
window.win_func_redirect = function Func_Redirect(url, val = true) {
    if (window.history.length > 1 && val === true) {
        window.history.replaceState({}, document.title, window.location.href)
        window.history.back()
    } else {
        window.location.href = url
    }
}
