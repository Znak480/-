class ActionPool{

}

class ZnakBasketComponent{

    constructor({result, ajaxUrl, root, empty, params}){
        //cached items in component
        this.items = new Map();

        this.templates = {};

        this.total = result.TOTAL_DATA;

        this.ajaxUrl = ajaxUrl;

        this.root = this.__entity(document, root);
        this.empty = this.__entity(document, empty);

        this.itemsRoot = this.__entity(this.root, 'basket-items'); 
        this.totalRoot = this.__entity(this.root, 'basket-total');    

        this.result = result;
        this.params = params;
        this.pool = new Map();

        this.updateTimer = null;

        this.requestProcessing = false;
    }

    //Точка входа для работы компонента
    init(){
        this.basketPage = document.querySelector("[data-page='cart']");
        this.emptyPage = document.querySelector("[data-page='empty']");


        this.__bindEvent();

        this.__applyServerState(this.__normalizeState(this.result));

        this.__updatePage();
    }

    __updatePage(){
        if(this.items.size > 0){
            this.basketPage.classList.remove("hidden");
            this.emptyPage.classList.add("hidden");
        }else{
            this.basketPage.classList.add("hidden");
            this.emptyPage.classList.remove("hidden");
        }
    }


    __switchTimer(){
        clearTimeout(this.updateTimer);

        if(this.requestProcessing === true){
            return;
        } 
        
        if(this.pool.size === 0){
            return;
        }

        this.updateTimer = setTimeout(() => this.__trySendPool(), 300);
    }

    __trySendPool(){
        if (this.requestProcessing) return;

        this.requestProcessing = true;

        const batch = new Map(this.pool);
        this.pool.clear();  
        try{
            for(const [key, value] of batch.entries()){
                Object.entries(value)
                    .map(([id, data]) => ({
                        id: Number(id),   
                        ...data         
                    }))
                    .forEach((value) => this.__requestData(key, value));
            }
        }catch(e){
             for (const [action, value] of batch.entries()) {
                if (!this.pool.has(action)) this.pool.set(action, {});
                Object.assign(this.pool.get(action), value);
            }
            console.error("POOL SEND ERROR", e);
        } finally{
             this.requestProcessing = false;

             if(this.pool.size > 0) this.__switchTimer();
        }   
    }

    selectItem(id, select = true){
        const item = this.items.get(id);
       
        if (!item) return;

        item.SELECTED = select;
        
        if (!this.pool.has("select")) {
            this.pool.set("select", {});
        }

        this.pool.get("select")[id] = { value: select };

        this.__switchTimer();
    }

    selectAllItem(select = true){
        if(this.items.size === 0) return;
        this.root.classList.add('changed');
        this.__requestData("selectAll", {value: select});
    }

    setQuantity(id, quantity){
        const item = this.items.get(id);
        if(!item) return;

        item.QUANTITY = quantity;

        if (!this.pool.has("quantity")) {
            this.pool.set("quantity", {});
        }
        this.pool.get("quantity")[id] = { quantity };

        this.__switchTimer();
    }

    delete(id){
        this.root.classList.add('changed');

        const item = this.items.get(id);
        if(!item) return;
        this.__requestData("delete", {id: id});
    }

    deleteSelected(){
        if(this.items.size === 0) return;
        this.root.classList.add('changed');

        this.__requestData("deleteSelected", {});
    }

    useCard(have = true){
        this.root.classList.add('changed');
        this.__requestData("useCard", {value: have});
    }

    __normalizeState(raw){
        return {
            items:       raw.items       ?? raw.ITEMS       ?? [],
            total:       raw.total       ?? raw.TOTAL_DATA  ?? {},
            selectedAll: raw.selectedAll ?? raw.SELECTED_ALL ?? false,
        };
    }

    __removeItemWithAnimation(id){
        const node = this.__itemNode(id);
        if (!node) return;

        node.classList.remove('is-loading');
        node.classList.add('is-removing');

        const done = () => node.remove();
        node.addEventListener('transitionend', done, { once: true });
        setTimeout(done, 400);
    }

    __applyServerState({items, total, selectedAll}){
        const incoming = new Map(items.map(i => [i.PRODUCT_ID, i]));
        const template = this.__getTemplate("basket-item-template");

        for (const id of [...this.items.keys()]){
            if (!incoming.has(id)){
                this.__removeItemWithAnimation(id);
                this.items.delete(id);
            }
        }
       
        incoming.forEach((item, id) => {
            const prev = this.items.get(id);    
            const node = this.__itemNode(id);
    
            if(!node){
                const wrap = document.createElement('div');
                wrap.innerHTML = this.__render(template, item);
                this.itemsRoot.appendChild(wrap.firstElementChild); 
            }else if(JSON.stringify(prev) !== JSON.stringify(item)){
                const wrap = document.createElement('div');
                wrap.innerHTML = this.__render(template, item);
                
                node.replaceWith(wrap.firstElementChild);
               
            }
            this.items.set(id, item)
        })

        this.total = total;

        this.__renderTotalData(total)
        this.__renderDeleteSelected();
        const selectAll = this.__entity(this.root, "select-all");
        selectAll.checked = selectedAll;
        
        this.__updatePage();
    }   


    __renderDeleteSelected(){
        let haveSelected = false;
        let count = 0;
        this.items.forEach((value, key) =>{
            if(value.SELECTED){
                haveSelected = true;
                count++;
            }
        });

        const button = this.__entity(this.root, "delete-selected");
        if(!button){
            return;
        }

        if(!haveSelected){
            button.textContent = BX.message("DELETE_SELECTED_EMPTY");
            button.disabled = true;
        }else{
            button.textContent = BX.message("DELETE_SELECTED_HAS").replace("#COUNT#", count);
            button.disabled = false;
        }
        
    }


    __renderTotalData(total){
        const totalTemplate = this.__getTemplate("basket-total-template");

        const wrap = document.createElement('div');
        wrap.innerHTML = this.__render(totalTemplate, total);

        this.totalRoot.replaceChildren(wrap.firstElementChild);

        const button = this.__entity(this.totalRoot, "basket-checkout-button");
        
        if(total.TOTAL_COUNT === 0){
            this.totalRoot.classList.add('unselected');
            button.textContent = BX.message('BASKET_EMPTY');;
            button.classList.add("disabled");
            button.disabled = true;
        }else{
            this.totalRoot.classList.remove('unselected');
            button.textContent = BX.message('BASKET_ORDER')
            button.classList.remove("disabled");
            button.disabled = false;
        }
    }

    __itemNode(id){
        return this.itemsRoot.querySelector(`[data-product-id="${id}"]`);
    }

    //События корзины click delete, change quantity, select и дригие,
    __bindEvent(){
        this.root.addEventListener("change", e => this.__onChange(e));
        this.root.addEventListener("click", e => this.__onClick(e));
    }

    __onClick(e){
        const delBtn = e.target.closest('[data-entity="delete-button"]');
        if(delBtn){
            const id = parseInt(delBtn.closest('[data-product-id]')?.dataset.productId, 10);
            if (!id) return;

            this.delete(id);
            return;
        }

        const delAllBtn = e.target.closest('[data-entity="delete-selected"]')
        if(delAllBtn){
            this.deleteSelected();
            return;
        }

        const checkoutBtn = e.target.closest('[data-entity="basket-checkout-button"]')
        if(checkoutBtn){
            document.location.href = this.params.PATH_TO_ORDER;
            return;
        }
    }

    __onChange(e){
        const cb = e.target.closest('[data-entity="product-checkbox"]');
        if (cb) {
            const id = parseInt(cb.closest('[data-product-id]')?.dataset.productId, 10);
            if (!id) return;
            this.selectItem(id, cb.checked);
            return;
        }

        const selectedAll = e.target.closest("[data-entity='select-all']");
        if(selectedAll){
            this.selectAllItem(selectedAll.checked);
            return;
        }

        const useCard = e.target.closest("[data-entity='have-card-checkbox']");
        if(useCard){
            this.useCard(useCard.checked);
            return;
        }
       
        const input = e.target.closest('[data-entity="basket-item-quantity"]');
        if (input) {
            const id = parseInt(input.closest('[data-product-id]')?.dataset.productId, 10);
            if (!id) return;

            const item = this.items.get(id);
            if (!item) return;

            const raw = parseFloat(input.value);
            if (!Number.isFinite(raw) || raw < 1) {
                input.value = item.QUANTITY || 1;
                return;
            }
            
            this.setQuantity(id, raw);
            return;
        }
    }

    __entity(root, name){ return root.querySelector(`[data-entity="${name}"]`); }
    __entities(root, name)   { return root.querySelectorAll(`[data-entity="${name}"]`); }


    __requestData(action, data = {},){
        const fd = new FormData();
        fd.append('action', action);
        fd.append('sessid', BX.bitrix_sessid());
        fd.append('data', JSON.stringify(data));

        const self = this;
        return fetch(this.ajaxUrl, {
            method: 'POST',
            body: fd,
            credentials: 'same-origin', 
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Ошибка сети: ' + response.status);
            }
            return response.json();
        })
        .then(function (data) {
            if (!data.success) {
                throw new Error(data.error || 'Неизвестная ошибка');
            }
            
            self.__applyServerState(self.__normalizeState(data));
            setTimeout(()=> self.root.classList.remove('changed'), 500)
            
        });
    }

    __getTemplate(templateSelector){

        if(!this.templates.hasOwnProperty(templateSelector)){
            let template = BX(templateSelector);
			this.templates[templateSelector] = BX.type.isDomNode(template) ? template.innerHTML : '';
        }

        return this.templates[templateSelector];
    }

    __render(template, data){
        const cloneData = structuredClone(data);

        return Mustache.render(template, cloneData);
    }
}

