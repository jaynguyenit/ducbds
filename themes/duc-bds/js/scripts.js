document.addEventListener('DOMContentLoaded', function () {
    const openBtns = document.querySelectorAll('.open-filter-drawer');
    const closeBtns = document.querySelectorAll('.close-filter-drawer');
    const drawer = document.getElementById('mobile-filter-drawer');
    const body = document.body;

    if (drawer) {
        const overlay = document.getElementById('mobile-filter-overlay');
        const panel = document.getElementById('mobile-filter-panel');

        const toggleDrawer = (isOpen) => {
            const bottomCTA = document.getElementById('sticky-bottom-cta');

            if (isOpen) {
                // Show container
                drawer.classList.remove('invisible', 'opacity-0', 'pointer-events-none');
                drawer.classList.add('visible', 'opacity-100');

                // Animate overlay (fade)
                if (overlay) overlay.classList.replace('opacity-0', 'opacity-100');

                // Animate panel (slide up)
                if (panel) panel.classList.replace('translate-y-full', 'translate-y-0');

                body.classList.add('overflow-hidden');

                // Hide bottom CTA with transition
                if (bottomCTA) {
                    bottomCTA.style.opacity = '0';
                    bottomCTA.style.pointerEvents = 'none';
                    setTimeout(() => { bottomCTA.style.display = 'none'; }, 300);
                }
            } else {
                // Animate overlay (fade out)
                if (overlay) overlay.classList.replace('opacity-100', 'opacity-0');

                // Animate panel (slide down)
                if (panel) panel.classList.replace('translate-y-0', 'translate-y-full');

                // Show bottom CTA
                if (bottomCTA) {
                    bottomCTA.style.display = '';
                    setTimeout(() => {
                        bottomCTA.style.opacity = '1';
                        bottomCTA.style.pointerEvents = 'auto';
                    }, 10);
                }

                // Delay hiding container to allow animation
                setTimeout(() => {
                    drawer.classList.add('invisible', 'opacity-0', 'pointer-events-none');
                    drawer.classList.remove('visible', 'opacity-100');
                    body.classList.remove('overflow-hidden');
                }, 300);
            }
        };

        openBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                console.log('Open Filter Drawer Clicked');
                toggleDrawer(true);
            });
        });

        closeBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                toggleDrawer(false);
            });
        });

        // Close drawer on form submission (optional but good for UX)
        const form = drawer.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                // Let the submission happen, but we can visually close for better feedback
                // toggleDrawer(false); 
            });
        }
    }
});
