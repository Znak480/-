function PriceDeliveryHandler() {

    const SELECTOR_FORM = '[data-dost-price-form]';
    const $form = $(SELECTOR_FORM);

    init();

    function init() {
        $form.submit(function (event) {
            event.preventDefault();

            let $this = $(this);
            let isFormValid = true;
            //рег. выражение для e-mail
            let reg_mail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            //рег. выражение для телефона
            let reg_phone = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/;

            $this.find('input[type=text], textarea').each(function () {
                if ($(this).val() == '' ||
                    (reg_mail.test($(this).val().trim()) == false && $(this).attr('name') == 'email') ||
                    (reg_phone.test($(this).val()) == false && $(this).attr('name') == 'phone')) {
                    $(this).css('border', "1px solid red");
                    isFormValid = false;
                } else {
                    $(this).css("border", "1px solid rgb(148,150,152)");
                }

            });

            var check = $this.find('input[name=check]').prop('checked');
            if (!check) {
                isFormValid = false;
                $this.find('.checkbox').css('color', "red");
            } else {
                $this.find('.checkbox').css('color', "rgb(42,45,50)");
            }


            var agree = $this.find('[data-agree-checkbox]').prop('checked');
            if (!agree) {
                isFormValid = false;
                $this.find('[data-agree-checkbox]').css('outline', "1px solid red");
            } else {
                $this.find('[data-agree-checkbox]').css('outline', "none");
            }

            if (isFormValid) {

                BX.ajax.runComponentAction(
                    'craft:form.optovikam.delivery',
                    'execute',
                    {
                        mode: 'class',
                        sessid: BX.bitrix_sessid(),
                        method: 'POST',
                        data: new FormData($this.get(0)),
                    }
                )
                    .then(function (response) {
                        let {status, data} = response;

                        if (status === 'success') {
                            $('.black-bg, .contact-success-modal').fadeIn(500);
                        }
                    });
            }
            return false;
        });
    }

}

document.addEventListener('DOMContentLoaded', function () {
    new PriceDeliveryHandler();
});
