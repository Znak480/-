export class Modal {
    modal = null;

    constructor(container, options = {}) {
        const wrapper = document.querySelector(container);

        if (!wrapper) {
            throw new Error(`Container "${wrapper}" not found`);
        }

        this.id = options.id;
        this.container = wrapper;
        this.opened = false;

        this.options = {
            ...options,
        };
    }

    render() {
        if (this.modal) {
            console.warn(`Modal "${this.id}" already rendered`);
            return this;
        }

        if (!this.options.selector) {
            this._createModal();
            this._isDynamic = true;
        } else {
            this.modal = document.querySelector(this.options.selector);
            if (!this.modal) {
                throw new Error(`Modal with selector "${this.options.selector}" not found`);
            }
            this.modal.dataset.modalId = this.id;
            this._isDynamic = false;

        }

        this.header = this.modal.querySelector(".modal-header");
        this.body = this.modal.querySelector(".modal-body");
        this.footer = this.modal.querySelector(".modal-footer");
        this.closeBtn = this.modal.querySelectorAll("[data-close]");

        this._bindEvents();
    }

    open() {
        this.modal?.classList.add("open");
        this.opened  = true;
    }

    close() {
        this.modal?.classList.remove("open");
        this.opened  = false;
    }

    destroy() {
        if (this._isDynamic) {
            this.modal.remove();
        }

        this._unbindEvents();

        this.modal = null;
        this.opened  = false;
    }

    isOpen() {
        return this.opened;
    }

    setTitle(title) {
        const titleEl = this.header?.querySelector('.modal-title');
        if (titleEl) {
            titleEl.textContent = title;
        }
        return this;
    }

    setPart(part, html) {
        const parts = {
            header: this.header,
            body: this.body,
            footer: this.footer
        };

        const element = parts[part];
        if (!element) {
            console.warn(`Part "${part}" not found in modal "${this.id}"`);
            return this;
        }

        element.innerHTML = html;
        return this;
    }

    clear() {
        this.body && (this.body.innerHTML = '');
        this.header && (this.header.innerHTML = '');
        this.footer && (this.footer.innerHTML = '');
        return this;
    }

    _createModal() {
        const html = `
                <div class="modal" data-modal-id="${this.id}">
                    <div class="modal-header">
                        <h2 class="modal-title">${this.options.title}</h2>
                        <button class="modal-close" data-close>X</button>
                    </div>
                        <div class="modal-body">
                            ${this.options.content}
                        </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary modal-close" data-close>Закрыть</button>
                    </div> 
                </div> 
            `;

        this.container.insertAdjacentHTML('beforeend', html);
        this.modal = this.container.querySelector(`[data-modal-id="${this.id}"]`);
    }

    _bindEvents() {
        if (!this.modal) return;

        this._handleClose = (event) => {
            event.preventDefault();
            event.stopPropagation();
            this.close();

            this.modal.dispatchEvent(new CustomEvent('modal:close', {
                detail: { id: this.id },
                bubbles: true
            }));
        };

        this.closeBtn?.forEach((el) => el.addEventListener("click", this._handleClose));


    }

    _unbindEvents() {
        if (!this.modal) return;
        this.closeBtn?.forEach((el) => el.removeEventListener("click", this._handleClose));
    }
}

