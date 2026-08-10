BX.ready(function(){
    document.querySelectorAll(".catalog-card").forEach(card => {
        const list = card.querySelector('.catalog-card-links');
        const toggleButton = card.querySelector('.btn-show-more');
        
        if (!list) {
            if (toggleButton) toggleButton.style.display = 'none';
            return;
        }
        
        const items = list.querySelectorAll('.catalog-card-link');
        const visibleCount = parseInt(list.dataset.visible) || 5;
        
        if (!toggleButton) return;
        
        const btnContentHolder = toggleButton.querySelector('span');
        if (!btnContentHolder) return;

        if (items.length === 0) {
            toggleButton.style.display = 'none';
            return;
        }

        items.forEach((item, index) => {
            if (index >= visibleCount) {
                item.style.display = 'none';
            }
        });

        
        if (items.length <= visibleCount) {
            toggleButton.style.display = 'none';
        } else {
           
            const hiddenCount = items.length - visibleCount;
            btnContentHolder.textContent = `Еще ${hiddenCount}`;
            let isExpanded = false;

            toggleButton.addEventListener('click', () => {
                isExpanded = !isExpanded;
                toggleButton.classList.toggle('active', isExpanded);
                
                items.forEach((item, index) => {
                    if (index >= visibleCount) {
                        item.style.display = isExpanded ? 'block' : 'none';
                    }
                });

                btnContentHolder.textContent = isExpanded 
                    ? 'Свернуть' 
                    : `Еще ${hiddenCount}`;
            });
        }
    });
});