export function overlayHandler(options = {}) {
    const { onOpen, onClose } = options;

    const $body = $("body");
    const $app = $(".app");

    let $overlay = $app.find(".overlay");

    if ($overlay.length === 0) {
        $overlay = $("<div class='overlay'></div>");
        $app.append($overlay);
    }

    function open() {
        $overlay.addClass("active")
        $body.addClass("overlay-open");

        if (onOpen && typeof onOpen === "function") {
            onOpen($overlay);
        }

        $overlay.on("click", function (e) {
            if (e.target === this) {
                close();
            }
        });

        $overlay.trigger("overlay:open")
    }

    function close() {
        $overlay.removeClass("active");
        $body.removeClass("overlay-open");

        if (onClose && typeof onClose === "function") {
            onClose($overlay);
        }

        $overlay.off("click");

        $overlay.trigger("overlay:close")
    }

    return {
        $overlay,
        open,
        close,
        toggle: () => $overlay.toggleClass("active"),
        isOpen: () => $overlay.hasClass("active"),
    };
}