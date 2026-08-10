/* This function is used to storage/hold modal windows or
   many other things windows, that used in project*/
export function windowHolder() {
    const holder = [];

    function __checkConfig(config) {
        return true;
    }

    function hold(config) {
        if (!__checkConfig(config)) return;

        const exists = get(config.id)
        console.log(holder, exists)
        if (exists) {
            console.warn("Window already exists");
            return;
        }

        holder.push(config);
    }

    function get(id) {
        let searched = null
        
        holder.forEach((el) => {
            if (id === el.id) searched = el;
        });

        return searched;
    }

    function unhold(id) {
        const index = holder.findIndex(el => el.id === id);

        if (index === -1) {
            console.warn(`Window by id:${id} not found`);
            return;
        }

        holder.splice(index, 1);
    }

    function isHold(id) {
        return !!get(id);
    }

    return {
        hold,
        unhold,
        get,
        isHold,
    }
}
