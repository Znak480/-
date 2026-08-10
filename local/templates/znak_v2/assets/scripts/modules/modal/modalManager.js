import { Modal } from "./modal.js";
import { overlayHandler } from "./overlay.js";
import { windowHolder } from './windowHolder.js';

/* This function is used to manage modal windows and overlay
    It's manager for widows + overlay */
export function modalManager(holder) {
    const windowStack = [];
    const overlay = overlayHandler();

    function open(id, data = {}) {
        const config = holder.get(id);

        if (!config) {
            console.warn(`Window by id:${id} not found for open`);
            return;
        }

        if (windowStack.includes(id)) {
            console.warn(`Window by id:${id} is open`);
            return;
        }

        console.log(data)
        const instance = new Modal('.app', {
            id: config.id,
            ...config,
            title: data.title || config.title,
            content: data.content || config.content,
            
        });

        instance.render();
        instance.open();

        instance.modal?.addEventListener('modal:close', (e) => {
            close(e.detail.id);
        });


        windowStack.push({ id, instance });

        overlay.open();
    }

    function close(id) {
        const index = windowStack.findIndex(el => el.id === id);

        if (index === -1) {
            console.warn(`Window by id:${id} not found for close`);
            return;
        }

        const { instance } = windowStack[index];

        instance.close();
        instance.destroy();

        windowStack.splice(index, 1);

        if (windowStack.length === 0 && overlay.isOpen()) {
            overlay.close();
        }
    }

    function closeAll() {
        while (windowStack.length > 0) {
            const { instance } = windowStack.pop();
            instance.close();
            instance.destroy();
        }
        overlay.close();
    }

    function isOpen(id) {
        return windowStack.some(item => item.id === id);
    }

    function getInstance(id) {
        const item = windowStack.find(el => el.id === id);
        return item?.instance || null;
    }

    $(document).on("overlay:close", () => {
        const lastElement = windowStack[windowStack.length - 1];

        if (!lastElement) return;

        close(lastElement.id);
    });

    return {
        open,
        close,
        closeAll,
        isOpen,
        getInstance
    }
}