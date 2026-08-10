import { Modal } from './modal.js';
import { overlayHandler } from './overlay.js';
import { windowHolder } from './windowHolder.js';
import { modalManager } from './modalManager.js';

const holder = windowHolder();
const manager = modalManager(holder);

export const modalSystem = {
    register: (config) => holder.hold(config),
    open: (id) => manager.open(id),
    close: (id) => manager.close(id),
    closeAll: () => manager.closeAll(),
    isOpen: (id) => manager.isOpen(id),
    show: (id, config = {}) => {
        const instance = manager.getInstance(id);
      
        if (instance && instance?.isOpen()) {
            if (config.content) {
                const { part, data } = config.content;
                instance.setPart(part, data);
            }
            if (config.title) {
                instance.setTitle(config.title);
            }
            return instance;
        }
        
        return manager.open(id, {
            content: config.content.data || '',
            title: config.title || ''
        });
    },
    getInstance: (id) => manager.getInstance(id),

    unregister: (id) => holder.unhold(id),
};