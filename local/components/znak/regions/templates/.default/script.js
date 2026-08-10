document.addEventListener('DOMContentLoaded', function () {
    (function () {
        "use strict";

        const regions = document.querySelectorAll(".region-selector");

        function updateRegions() {
            regions.forEach(reg => {
                const activeRegion = reg.querySelector(".region-sity");
                const activeItem = reg.querySelector(".region-dropdown .active");

                if (activeRegion && activeItem) {
                    activeRegion.textContent = activeItem.textContent;
                }

                reg.querySelector(".region-dropdown")?.classList.remove("open");
            });
        }

        function positionDropdown(dropdown) {
            const rect = dropdown.getBoundingClientRect();
            const isOverflow = rect.right > window.innerWidth - 10;

            dropdown.style.left = isOverflow ? 'auto' : '0';
            dropdown.style.right = isOverflow ? '0' : 'auto';
        }

        regions.forEach(reg => {

            const activeBlock = reg.querySelector(".region-active");
            if (!activeBlock) return;

            // Открытие/закрытие
            reg.addEventListener("click", e => {
                e.stopPropagation();
                e.preventDefault();

                const dropdown = reg.querySelector(".region-dropdown");
                if (!dropdown) return;

                dropdown.classList.toggle("open");

                if (dropdown.classList.contains("open")) {
                    requestAnimationFrame(() => {
                        setTimeout(() => positionDropdown(dropdown), 10);
                    });
                } else {
                    dropdown.style.left = '';
                    dropdown.style.right = '';
                }
            });

            // Выбор города
            reg.querySelectorAll(".region-dropdown li").forEach(item => {
                item.addEventListener("click", function (e) {
                    e.stopPropagation();
                    e.preventDefault();

                    this.closest(".region-dropdown")
                        .querySelectorAll("li")
                        .forEach(li => li.classList.remove("active"));

                    this.classList.add("active");

                    const domain = this.dataset.domain;
                    if (domain) {
                        window.location.href = window.location.protocol + '//' + domain;
                    }

                    updateRegions();
                });
            });
        });

        // Закрытие при клике вне
        document.addEventListener("click", e => {
            regions.forEach(reg => {
                const dropdown = reg.querySelector(".region-dropdown");
                if (dropdown?.classList.contains("open") && !reg.contains(e.target)) {
                    dropdown.classList.remove("open");
                    dropdown.style.left = '';
                    dropdown.style.right = '';
                }
            });
        });

        // Репозиционирование при ресайзе
        let resizeTimer;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                document.querySelectorAll(".region-dropdown.open").forEach(dropdown => {
                    positionDropdown(dropdown);
                });
            }, 100);
        });

    })();
});