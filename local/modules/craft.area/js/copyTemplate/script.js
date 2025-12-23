function CraftCopyTemplate(replace = null) {

    const NAME_SELECTOR_SOURCE = 'data-copy-source';
    const NAME_SELECTOR_TARGET = 'data-copy-target';
    const NAME_TEMPLATE = 'data-copy-template';

    const SELECTOR_SOURCE = `[${NAME_SELECTOR_SOURCE}]`;
    const SELECTOR_TARGET = `[${NAME_SELECTOR_TARGET}]`;

    let $document = $(document);

    main();

    function main() {

        $document.on('click', SELECTOR_SOURCE, function (event) {
            event.preventDefault();

            let $this = $(this);

            let key = $this.attr(NAME_SELECTOR_SOURCE);
            if (key.length <= 0) {
                return;
            }


            let template = $this.attr(NAME_TEMPLATE);
            if (template.length <= 0) {
                return;
            }

            let $target = $(`[${NAME_SELECTOR_TARGET}="${key}"]`);
            if ($target.length !== 1) {
                return;
            }


            if (typeof replace === 'function') {
                replace($this, $target, template);
            } else {
                $target.append(template);
            }
        });
    }
}