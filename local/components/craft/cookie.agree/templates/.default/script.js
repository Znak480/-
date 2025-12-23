document.addEventListener('DOMContentLoaded', function () {
    $(document).on('click', '[data-accept-cookie-button]', function () {
        if (BX !== undefined) {
            BX.ajax.runComponentAction(
                'craft:cookie.agree',
                'execute',
                {
                    mode: 'class',
                    sessid: BX.bitrix_sessid()
                }
            ).then(function (response) {
                let {status} = response;
                if (status && status === 'success') {
                    $('[data-accept-cookie]').remove();
                }
            });
        }
    });
});