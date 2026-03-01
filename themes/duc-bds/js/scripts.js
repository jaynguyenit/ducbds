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
        // Initialize Select2 for multi-select dropdowns
        const initSelect2 = () => {
            const $selects = jQuery('.select2-multi');
            if ($selects.length > 0) {
                $selects.each(function () {
                    const $this = jQuery(this);
                    let placeholderText = $this.attr('data-placeholder') || $this.find('option[value=""]').first().text() || 'Chọn...';

                    $this.select2({
                        placeholder: placeholderText,
                        allowClear: false,
                        width: '100%',
                        closeOnSelect: false
                    });

                    // Fix placeholder visibility on initial load and after selection
                    const updatePlaceholder = () => {
                        const $container = $this.next('.select2-container');
                        const $searchField = $container.find('.select2-search__field');
                        const selectedCount = ($this.val() || []).length;

                        if (selectedCount === 0) {
                            $searchField.attr('placeholder', placeholderText).css('width', '100%');
                        } else {
                            $searchField.attr('placeholder', '').css('width', 'auto');
                        }
                    };

                    $this.on('change', updatePlaceholder);
                    $this.on('select2:unselect', () => {
                        setTimeout(updatePlaceholder, 1);
                    });

                    setTimeout(updatePlaceholder, 100);
                });

                // Add custom styles for Select2 to match the theme's design
                const style = document.createElement('style');
                style.innerHTML = `
                    /* Main Selection Box */
                    .select2-container--default .select2-selection--multiple {
                        border-radius: 0.75rem;
                        border-color: #e5e7eb;
                        padding: 0 12px !important;
                        min-height: 48px;
                        display: flex;
                        align-items: center;
                        background-color: #fff;
                        transition: all 0.2s;
                        cursor: text;
                        overflow: hidden;
                    }
                    .select2-container--default.select2-container--focus .select2-selection--multiple {
                        border-color: var(--color-primary);
                    }
                    .select2-container--default .select2-selection__rendered {
                        display: flex !important;
                        flex-wrap: wrap;
                        gap: 6px;
                        padding: 6px 0 !important;
                        margin: 0 !important;
                        width: 100%;
                        align-items: center;
                        list-style: none;
                        justify-content: flex-start !important;
                        z-index: 1;
                        top:0
                    }
                    
                    /* Force Left Aligned Placeholder & Search Input */
                    .select2-container--default .select2-selection--multiple .select2-search--inline {
                        margin: 0 !important;
                        padding: 0 !important;
                        flex: 1;
                        display: flex;
                        align-items: center;
                        order: 999;
                        min-width: 30px;
                    }
                    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field {
                        margin: 0 !important;
                        padding: 0 !important;
                        height: 32px !important;
                        line-height: 32px !important;
                        text-align: left !important;
                        font-family: inherit;
                        font-size: 14px !important;
                        color: #111827;
                        width: 100% !important;
                        background: transparent !important;
                        border: none !important;
                        outline: none !important;
                        display: block !important;
                        position: absolute;
                        left: 10px;
                    }
                    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field::placeholder {
                        color: #9ca3af !important;
                        text-align: left !important;
                        opacity: 1 !important;
                    }

                    /* Prevent iOS Zoom on focus by using 16px font-size */
                    @media (max-width: 1023px) {
                        .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field {
                            font-size: 16px !important;
                        }
                    }
                    
                    /* Selected Tags (Choices) */
                    .select2-container--default .select2-selection--multiple .select2-selection__choice {
                        background-color: #111827;
                        border: none;
                        border-radius: 20px;
                        padding: 0 12px 0 28px !important;
                        color: #fff !important;
                        font-size: 11px;
                        font-weight: 600;
                        margin: 2px 0 !important;
                        position: relative;
                        height: 26px;
                        display: flex;
                        align-items: center;
                        white-space: nowrap;
                    }
                    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                        color: #fff !important;
                        position: absolute;
                        left: 10px;
                        top: 50%;
                        transform: translateY(-50%);
                        margin: 0 !important;
                        padding: 0 !important;
                        border: none;
                        font-size: 16px !important;
                        font-weight: bold;
                        line-height: 1;
                    }
                    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
                        color: #ef4444 !important;
                        background: transparent;
                    }
                    
                    /* Dropdown Menu - Simplified (No Checkboxes) */
                    .select2-dropdown {
                        border-radius: 1rem;
                        border: 1px solid #f3f4f6;
                        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                        z-index: 99999;
                        margin-top: 8px;
                        overflow: hidden;
                        background: #fff;
                    }
                    .select2-results__option {
                        padding: 10px 16px !important;
                        font-size: 14px;
                        position: relative;
                        color: #374151;
                        transition: all 0.1s;
                        cursor: pointer;
                    }
                    
                    /* Clear checkboxes if any pseudo-elements exist */
                    .select2-results__option:before, .select2-results__option:after {
                        display: none !important;
                    }
                    
                    /* Highlight Selected Option with Primary Color */
                    .select2-results__option[aria-selected="true"] {
                        background-color: #eab308 !important;
                        color: #fff !important;
                        font-weight: 600;
                    }
                    
                    .select2-results__option--highlighted {
                        background-color: #f3f4f6 !important;
                        color: #111827 !important;
                    }
                    
                    /* Handle hover on selected items */
                    .select2-results__option[aria-selected="true"].select2-results__option--highlighted {
                        background-color: #d1a007 !important;
                    }

                    /* Desktop Compact Bar Style */
                    .xl\\:block .select2-container--default .select2-selection--multiple {
                        min-height: 48px;
                        border-radius: 20px;
                        padding: 0 16px !important;
                        min-width: 140px;
                        background-color: #f9fafb;
                    }
                    .xl\\:block .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field {
                        height: 38px !important;
                        line-height: 38px !important;
                    }
                    .xl\\:block .select2-container--default .select2-selection--multiple .select2-selection__choice {
                        height: 24px;
                        font-size: 10px;
                        padding-left: 24px !important;
                    }
                    .xl\\:block .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                        left: 8px;
                        font-size: 14px !important;
                    }
                `;
                document.head.appendChild(style);
            }
        };

        const syncInputs = () => {
            const inputs = searchForm.querySelectorAll('select, input[type="text"], input[type="radio"], input[type="checkbox"]');

            inputs.forEach(input => {
                input.addEventListener('change', function () {
                    let name = this.name;
                    if (!name) return;

                    // Support array names like hinh-thuc-bds[]
                    const isArray = name.endsWith('[]');
                    const baseName = isArray ? name.slice(0, -2) : name;

                    let val;
                    if (this.type === 'radio') {
                        val = this.checked ? this.value : null;
                    } else if (this.type === 'checkbox') {
                        // For checkboxes with same name array, get all checked values
                        const checked = searchForm.querySelectorAll(`input[name="${name}"]:checked`);
                        val = Array.from(checked).map(i => i.value);
                    } else if (this.multiple) {
                        val = jQuery(this).val();
                    } else {
                        val = this.value;
                    }

                    if (val === null && this.type === 'radio') return;

                    // Update all other inputs with the same base name
                    const targets = searchForm.querySelectorAll(`[name="${name}"], [name="${baseName}"]`);
                    targets.forEach(target => {
                        if (target === this) return;

                        if (target.type === 'radio') {
                            target.checked = (target.value === val);
                        } else if (target.type === 'checkbox') {
                            if (Array.isArray(val)) {
                                target.checked = val.includes(target.value);
                            } else {
                                target.checked = (target.value === val);
                            }
                        } else {
                            if (jQuery(target).hasClass('select2-multi')) {
                                jQuery(target).val(val).trigger('change.select2');
                            } else {
                                target.value = val;
                            }
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

        initSelect2();
        syncInputs();

        // Custom Price Dropdown Handling
        jQuery('.custom-price-dropdown').each(function () {
            const $dropdown = jQuery(this);
            const $btn = $dropdown.find('button');
            const $menu = $dropdown.find('.price-menu');
            const $label = $dropdown.find('.price-label');

            // Toggle menu
            $btn.on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                jQuery('.price-menu').not($menu).addClass('hidden');
                $menu.toggleClass('hidden');
            });

            // Select predefined option
            $dropdown.find('.price-opt').on('click', function () {
                const val = jQuery(this).data('value');
                const text = jQuery(this).text();

                $dropdown.find('input[name="khoang-gia"]').val(val);
                $dropdown.find('input[name="gia_min"]').val('');
                $dropdown.find('input[name="gia_max"]').val('');

                const color = (text === 'Khoảng giá') ? '#9FA6B2' : '#111827';
                $label.text(text).css('color', color);
                $menu.addClass('hidden');

                // Style active
                $dropdown.find('.price-opt').removeClass('bg-primary/10 text-primary font-bold');
                jQuery(this).addClass('bg-primary/10 text-primary font-bold');
            });

            // Apply custom range
            $dropdown.find('.apply-custom-price').on('click', function () {
                const min = $dropdown.find('.min-input').val();
                const max = $dropdown.find('.max-input').val();

                if (min || max) {
                    $dropdown.find('input[name="khoang-gia"]').val('');
                    $dropdown.find('input[name="gia_min"]').val(min);
                    $dropdown.find('input[name="gia_max"]').val(max);

                    let label = 'Tùy chỉnh: ';
                    if (min && max) label += `${min} - ${max} tỷ`;
                    else if (min) label += `>= ${min} tỷ`;
                    else label += `<= ${max} tỷ`;

                    $label.text(label).css('color', '#111827');
                    $menu.addClass('hidden');
                    $dropdown.find('.price-opt').removeClass('bg-primary/10 text-primary font-bold');
                }
            });
        });

        // Close when clicking outside
        jQuery(document).on('click', function () {
            jQuery('.price-menu').addClass('hidden');
        });
        jQuery('.price-menu').on('click', function (e) {
            e.stopPropagation();
        });

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
                        if (input.name && (compactBar.querySelector(`[name="${input.name}"]`) || compactBar.querySelector(`[name="${input.name.replace('[]', '')}"]`))) {
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

        // Reset Form without reloading
        jQuery('.reset-search-form').on('click', function () {
            const $form = jQuery(this).closest('form');

            // Clear inputs
            $form.find('input[type="text"], input[type="number"], input[type="hidden"]').val('');
            $form.find('input[type="checkbox"]').prop('checked', false);

            // Reset Select2
            if (jQuery.fn.select2) {
                $form.find('.select2-multi').val(null).trigger('change.select2');
            }

            // Reset Price Dropdown Label
            const $priceLabels = $form.find('.price-label');
            $priceLabels.text('Khoảng giá').css('color', '#9FA6B2');

            // Reset Price Dropdown Active Classes
            $form.find('.price-opt').removeClass('bg-primary/10 text-primary font-bold');
        });
    }

    // Copy Property Link functionality
    const copyBtn = document.getElementById('copy-property-link');
    if (copyBtn) {
        copyBtn.addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            const originalContent = this.innerHTML;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(() => {
                    // Visual feedback
                    this.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span>Đã sao chép!</span>
                    `;
                    this.classList.replace('bg-gray-100', 'bg-green-100');
                    this.classList.replace('text-gray-700', 'text-green-700');

                    setTimeout(() => {
                        this.innerHTML = originalContent;
                        this.classList.replace('bg-green-100', 'bg-gray-100');
                        this.classList.replace('text-green-700', 'text-gray-700');
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                });
            } else {
                // Fallback for older browsers or non-secure contexts
                const textArea = document.createElement("textarea");
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    this.innerHTML = '<span>Đã sao chép!</span>';
                    setTimeout(() => { this.innerHTML = originalContent; }, 2000);
                } catch (err) {
                    console.error('Fallback copy failed', err);
                }
                document.body.removeChild(textArea);
            }
        });
    }
});
