export function showMore(settings = {}) {
    const {
          container = '',
        itemSelector = '',
        visibleCount = 3,
        divider = '',
        button: {
            buttonSelector = '',
            buttonTextHolder = '',
            buttonTextExpanded = 'Скрыть',
            buttonTextCollapsed = 'Еще {{count}}'
        } = {},
        animation = true,
        animationDuration = 300,
    } = settings;



    if (!settings.container || !settings.itemSelector || !settings.button.buttonSelector) {
        console.warn('showMore: Не все обязательные параметры указаны');
        return;
    }

    const $container = $(settings.container);
    if (!$container.length) {
        console.warn(`showMore: Контейнер "${settings.container}" не найден`);
        return;
    }


    $container.each(function () {
        const $items = $(this).find(settings.itemSelector);

        const $parent = $(this).parent();

        const $button = $parent.find(settings.button.buttonSelector);

        if (!$parent.length || !$button.length) {
            return;
        }

        const $divider = $parent.find(settings.divider);

        const visibleCount = settings.visibleCount;
        const totalItems = $items.length;

        if (totalItems <= visibleCount) {
            $button.hide();

            if ($divider.length) {
                $divider.hide();
            }
            return;
        }

        let isExpanded = false;
        const hiddenCount = totalItems - visibleCount;

        function updateButtonText(expanded) {
            const $textHolder = buttonTextHolder ? 
                $button.find(buttonTextHolder) : $button;

            if (!$textHolder.length) {
                return;
            }

            if(expanded) {
                $textHolder.text(buttonTextExpanded);
            }else{
                const label = buttonTextCollapsed.replace('{{count}}', hiddenCount);
                $textHolder.text(label);
            }
        }

        function toggleItems(show) {
            const $hiddenItems = $items.slice(visibleCount);

            if (show) {
                if (settings.animation) {
                    $hiddenItems.css({
                        opacity: 0,
                    }).show().each(function (index) {
                        $(this).delay(index * 20).animate({
                            opacity: 1,
                            transform: 'translateY(-10px)'
                        }, settings.animationDuration, 'swing');
                    });
                } else {
                    $hiddenItems.show();
                }
            } else {
                if (settings.animation) {
                    $hiddenItems.animate({
                        opacity: 0,
                        transform: 'translateY(-10px)'
                    }, settings.animationDuration, 'swing', function () {
                        $(this).hide();
                    });
                } else {
                    $hiddenItems.hide();
                }
            }
        }

        $items.slice(visibleCount).hide();
        updateButtonText(isExpanded);

        $button.on('click', function (e) {
            e.preventDefault();
            isExpanded = !isExpanded;

            toggleItems(isExpanded);
            updateButtonText(isExpanded);
            console.log(isExpanded)
        })
    })
}


$(document).ready(function () {


    

})