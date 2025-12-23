/**
 * @param params {{ajaxUrl: string}}
 */
let JediArea = function (params) {

    let {ajaxUrl} = params;

    const NAME_SELECTOR_MAGICK_INPUT = 'data-magick-input';
    const NAME_SELECTOR_MAGICK_FORM = 'data-magick-form';
    const NAME_SELECTOR_INSERT = 'data-insert';
    const NAME_SELECTOR_INSERT_TARGET = 'data-insert-target';
    const NAME_SELECTOR_ADD_ROW_COMPLEX = 'data-add-row-complex';
    const NAME_SELECTOR_ADD_ROW_COMPLEX_TARGET = 'data-add-row-complex-target';

    const SELECTOR_CONTENT_BLOCK_LIST = '[data-content-block-list]';
    const SELECTOR_CONTENT_BLOCK_ITEM = '[data-content-block-item]';
    const SELECTOR_CONTENT_BLOCK_ACTION_REMOVE = '[data-content-block-action-remove]';
    const SELECTOR_ADD_ROW_BUTTON = '[data-add-row-content-block]';
    const SELECTOR_SELECT_TYPE_BLOCK = '[data-select-type-block]';
    const SELECTOR_MAGICK_FORM = `[${NAME_SELECTOR_MAGICK_FORM}]`;
    const SELECTOR_INSERT = `[${NAME_SELECTOR_INSERT}]`;
    const SELECTOR_INSERT_TARGET = `[${NAME_SELECTOR_INSERT_TARGET}]`;
    const SELECTOR_ADD_ROW_COMPLEX = `[${NAME_SELECTOR_ADD_ROW_COMPLEX}]`;
    const SELECTOR_ADD_ROW_COMPLEX_TARGET = `[${NAME_SELECTOR_ADD_ROW_COMPLEX_TARGET}]`;

    const $CONTENT_BLOCK_LIST = $(SELECTOR_CONTENT_BLOCK_LIST);
    const $SELECT_TYPE_BLOCK = $(SELECTOR_SELECT_TYPE_BLOCK);

    const $document = $(document);

    const SELECTOR_SYS_MSG = '[data-sys-msg]';
    const $SYS_MSG = $(SELECTOR_SYS_MSG);

    init();

    function init() {

        if (!ajaxUrl) {
            return;
        }

        $document.on('click', SELECTOR_ADD_ROW_COMPLEX, function (event) {
            event.preventDefault();

            let $this = $(this);

            let fieldId = parseInt($this.data('field-id'));
            if (!fieldId) {
                return;
            }

            let formData = new FormData();
            formData.append('fieldId', fieldId);
            formData.append('action', 'addRowComplexField');

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    let {template} = data;

                    if (template) {
                        $(SELECTOR_ADD_ROW_COMPLEX_TARGET).append($(template));
                    }

                });
        });

        $document.on('click', SELECTOR_ADD_ROW_BUTTON, function (event) {
            event.preventDefault();

            let $this = $(this);

            let typeBlockValue = $SELECT_TYPE_BLOCK.val();
            if (!typeBlockValue) {
                renderError('Выберите тип блока');
                return;
            }

            let areaId = $this.data('area-id');
            if (!areaId) {
                renderError('Не указан ID контент-блока');
                return;
            }

            let index = ($(SELECTOR_CONTENT_BLOCK_ITEM).length) + 1;

            let formData = new FormData();
            formData.append('action', 'getSettingsRow');
            formData.append('type', typeBlockValue);
            formData.append('areaId', areaId);
            formData.append('index', index);

            fetch(ajaxUrl, {
                body: formData,
                method: 'POST'
            })
                .then(response => response.json())
                .then(data => {
                    let {template} = data;

                    if (template) {
                        $CONTENT_BLOCK_LIST.append(template);
                    }
                })
                .catch(error => {
                    renderError(error);
                });

        });

        $document.on('change', SELECTOR_CONTENT_BLOCK_ACTION_REMOVE, function (event) {
            event.preventDefault();

            let $this = $(this);

            let $parent = $this.parents(SELECTOR_CONTENT_BLOCK_ITEM);
            if (!$parent.length) {
                return;
            }

            $parent.addClass('hidden');
        });

        $document.on('click', SELECTOR_INSERT, function (event) {
            event.preventDefault();

            let $this = $(this);

            let key = $this.attr(NAME_SELECTOR_INSERT);
            if (key.length <= 0) {
                return;
            }


            let tpl = $this.data('tpl');
            if (!tpl || tpl.length <= 0) {
                return;
            }

            let $target = $(`[${NAME_SELECTOR_INSERT_TARGET}="${key}"]`);
            if ($target.length <= 0) {
                return;
            }

            $target.append($(tpl));
        });

        $document.on('submit', SELECTOR_MAGICK_FORM, function (event) {
            event.preventDefault();

            let $this = $(this);

            let key = $this.attr(NAME_SELECTOR_MAGICK_FORM);

            if (key.length <= 0) {
                return;
            }

            let $input = $(`[data-magick-input="${key}"]`);

            if ($input.length !== 1) {
                return;
            }


            let fd = new FormData(event.target);

            fd.append('action', 'json');

            fetch(ajaxUrl, {
                method: 'POST',
                body: fd
            })
                .then(response => response.json())
                .then(data => {
                    let {json} = data;
                    if (json) {
                        $input.val(json);
                    }
                });


            if (typeof Fancybox !== 'undefined') {
                Fancybox.close();
            }

        });
    }


    function renderError(errorMessage) {
        $SYS_MSG.html(errorMessage);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    Fancybox.bind("[data-fancybox]");
});
