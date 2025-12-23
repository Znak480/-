$(document).ready(function () {
    $('[data-agree-form1]').each(function () {
        var $form = $(this);
        var $checkbox = $form.find('[data-agree-checkbox]');
        var $submitBtn = $form.find('button[type="submit"], input[type="submit"]');

        if ($checkbox.length && $submitBtn.length) {
            // Блокируем кнопку при загрузке
            $submitBtn.prop('disabled', true);

            // Событие изменения чекбокса
            $checkbox.on('change', function () {
                $submitBtn.prop('disabled', !$(this).is(':checked'));
            });

            // Проверка при отправке
            $form.on('submit', function (e) {
                if (!$checkbox.is(':checked')) {
                    e.preventDefault();
                    alert('Пожалуйста, отметьте обязательный чекбокс');
                }
            });
        }
    });
});