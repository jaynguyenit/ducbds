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

    // Generic synchronization for all search inputs in the same form
    const searchForm = document.getElementById('bds-search-form');
    if (searchForm) {
        const syncInputs = () => {
            const inputs = searchForm.querySelectorAll('select, input[type="text"], input[type="radio"]');

            inputs.forEach(input => {
                input.addEventListener('change', function () {
                    const name = this.name;
                    if (!name) return;

                    const val = this.type === 'radio' ? (this.checked ? this.value : null) : this.value;
                    if (val === null && this.type === 'radio') return;

                    // Update all other inputs with the same name
                    const targets = searchForm.querySelectorAll(`[name="${name}"]`);
                    targets.forEach(target => {
                        if (target === this) return;

                        if (target.type === 'radio') {
                            target.checked = (target.value === val);
                        } else {
                            target.value = val;
                        }
                    });
                });

                // For real-time sync of text inputs (like 's' keyword)
                if (input.type === 'text') {
                    input.addEventListener('input', function () {
                        const name = this.name;
                        const val = this.value;
                        const targets = searchForm.querySelectorAll(`input[type="text"][name="${name}"]`);
                        targets.forEach(target => {
                            if (target !== this) target.value = val;
                        });
                    });
                }
            });
        };

        syncInputs();

        // Prevent duplicate parameters in URL by disabling hidden inputs before submission
        searchForm.addEventListener('submit', function () {
            const isDesktop = window.matchMedia('(min-width: 1280px)').matches; // xl breakpoint
            const compactBar = this.querySelector('.xl\\:block');
            const mobileDrawer = document.getElementById('mobile-filter-drawer');

            if (isDesktop && compactBar) {
                // On desktop, disable inputs inside the mobile drawer
                if (mobileDrawer) {
                    const drawerInputs = mobileDrawer.querySelectorAll('select, input');
                    drawerInputs.forEach(input => {
                        // Only disable if it has a twin in the visible bar
                        if (input.name && compactBar.querySelector(`[name="${input.name}"]`)) {
                            input.disabled = true;
                        }
                    });
                }
            } else if (!isDesktop) {
                // On mobile/tablet (drawer visible), disable inputs in the desktop bar
                if (compactBar) {
                    const barInputs = compactBar.querySelectorAll('select, input');
                    barInputs.forEach(input => input.disabled = true);
                }
            }

            // Re-enable after a short delay so if the user hits back, the form is still usable
            setTimeout(() => {
                const allDisabled = searchForm.querySelectorAll('[disabled]');
                allDisabled.forEach(input => input.disabled = false);
            }, 100);
        });

    }
});

