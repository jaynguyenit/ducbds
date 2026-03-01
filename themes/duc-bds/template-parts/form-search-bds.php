<?php
/**
 * Template part for displaying the property search form.
 *
 * @package Duc_BDS
 */

// Helper function to get terms for select options using transients
$get_search_terms = function($taxonomy, $label, $show_empty = true) {
    $terms = duc_bds_get_cached_terms($taxonomy);
    
    if ($show_empty) {
        echo '<option value="">' . esc_html($label) . '</option>';
    }
    
    // Get current terms if on a taxonomy page
    $current_term_slugs = array();
    if (is_tax($taxonomy)) {
        $queried_object = get_queried_object();
        $current_term_slugs[] = $queried_object->slug;
    }
    // Override with GET parameter if exists
    if (isset($_GET[$taxonomy])) {
        $val = $_GET[$taxonomy];
        if (is_array($val)) {
            $current_term_slugs = array_map('sanitize_text_field', $val);
        } else {
            $current_term_slugs = array(sanitize_text_field($val));
        }
    }
    
    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $selected = in_array($term->slug, $current_term_slugs) ? 'selected' : '';
            $indent = isset($term->depth) && $term->depth > 0 ? str_repeat('&nbsp;&nbsp;&nbsp;', $term->depth) : '';
            echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . $indent . esc_html($term->name) . '</option>';
        }
    }
};
?>

<?php
// Get arguments passed from get_template_part
$is_sidebar = isset($args['is_sidebar']) ? $args['is_sidebar'] : false;
$is_compact = isset($args['is_compact']) ? $args['is_compact'] : false;

$only_drawer = isset($args['only_drawer']) ? $args['only_drawer'] : false;

// Dynamic CSS classes based on location
if ($is_compact) {
    if ($only_drawer) {
        $form_classes = 'md:hidden'; // Completely hide the form container on desktop
    } else {
        $form_classes = 'xl:bg-white xl:border xl:border-gray-100 xl:rounded-2xl xl:py-2 xl:px-4 mb-0 xl:mb-8 xl:shadow-sm mx-auto max-w-7xl';
    }
} elseif ($is_sidebar) {
    $form_classes = 'space-y-4 [&_select]:border [&_select]:border-gray-300 [&_select]:rounded-xl [&_select]:px-4 [&_select]:py-3 [&_select]:bg-white';
} else {
    $form_classes = 'bg-white rounded-2xl shadow-lg p-6 lg:p-8 space-y-6 max-w-4xl mx-auto [&_select]:border [&_select]:border-gray-300 [&_select]:rounded-xl [&_select]:px-4 [&_select]:py-3';
}
    // Common price options for all forms
    $price_options = array(
        '' => 'Tất cả',
        '1000-3000' => '1 - 3 tỷ',
        '3000-5000' => '3 - 5 tỷ',
        '5000-10000' => '5 - 10 tỷ',
        '10000-50000' => '10 - 50 tỷ',
        '50000-100000' => '50 - 100 tỷ',
        '500000' => 'Dưới 500 tỷ',
        '>500000' => 'Trên 500 tỷ'
    );

    // Determine current price label
    $current_price_label = 'Khoảng giá';
    $g_min = isset($_GET['gia_min']) ? intval($_GET['gia_min']) : 0;
    $g_max = isset($_GET['gia_max']) ? intval($_GET['gia_max']) : 0;
    $g_khoang = isset($_GET['khoang-gia']) ? $_GET['khoang-gia'] : '';

    if ($g_min > 0 || $g_max > 0) {
        if ($g_min > 0 && $g_max > 0) $current_price_label = 'Tùy chỉnh: ' . $g_min . ' - ' . $g_max . ' tỷ';
        elseif ($g_min > 0) $current_price_label = 'Tùy chỉnh: >= ' . $g_min . ' tỷ';
        else $current_price_label = 'Tùy chỉnh: <= ' . $g_max . ' tỷ';
    } elseif (!empty($g_khoang) && isset($price_options[$g_khoang]) && $g_khoang !== '') {
        $current_price_label = $price_options[$g_khoang];
    }

    $price_label_color = ($current_price_label !== 'Khoảng giá') ? '#111827' : '#9FA6B2';
?>

<form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="<?php echo esc_attr($form_classes); ?>" id="bds-search-form">
    <input type="hidden" name="post_type" value="bds">

    <?php if ($is_compact) : ?>
        <?php if (!$only_drawer) : ?>
            <!-- Desktop Compact Bar (Theo style Trang chủ) -->
            <div class="hidden xl:block">
                <div class="space-y-6 py-4">
                    <!-- Keyword search -->
                    <div class="relative">
                        <input type="text" name="s" value="<?php echo get_search_query(); ?>" 
                               placeholder="Nhập tiêu đề hoặc mã BĐS..." 
                               class="w-full border border-gray-100 rounded-xl px-4 py-3 focus:border-primary focus:bg-white outline-none transition bg-gray-50/50">
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>

                    <!-- Filter Links (Hinh thuc & Loai hinh) -->
                    <div class="flex flex-wrap gap-x-2 gap-y-4 items-center">
                        <div class="flex flex-wrap gap-2">
                            <?php
                            $hinh_thuc_terms = duc_bds_get_cached_terms('hinh-thuc-bds');
                            $current_hinh_thuc = isset($_GET['hinh-thuc-bds']) ? $_GET['hinh-thuc-bds'] : '';
                            if (!empty($hinh_thuc_terms) && !is_wp_error($hinh_thuc_terms)) :
                                foreach ($hinh_thuc_terms as $term) :
                                    $checked = (is_array($current_hinh_thuc) ? in_array($term->slug, $current_hinh_thuc) : ($current_hinh_thuc == $term->slug)) ? 'checked' : '';
                            ?>
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="hinh-thuc-bds[]" value="<?php echo esc_attr($term->slug); ?>" class="peer hidden" <?php echo $checked; ?>>
                                    <span class="px-5 py-2 rounded-full border border-gray-100 text-[13px] font-semibold peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary hover:border-primary transition inline-block text-gray-600 bg-gray-50/50"><?php echo esc_html($term->name); ?></span>
                                </label>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="w-px h-6 bg-gray-200 mx-1"></div>

                        <div class="flex flex-wrap gap-2">
                            <?php
                            $featured_loai_ids = get_field('loại_hinh_bds_noi_bat', 'options');
                            if (!empty($featured_loai_ids)) {
                                $loai_bds_terms = get_terms(array(
                                    'taxonomy'   => 'loai-bds',
                                    'include'    => $featured_loai_ids,
                                    'hide_empty' => false,
                                    'orderby'    => 'include',
                                ));
                                
                                $current_loai = isset($_GET['loai-bds']) ? $_GET['loai-bds'] : '';
                                if (!empty($loai_bds_terms) && !is_wp_error($loai_bds_terms)) {
                                    foreach ($loai_bds_terms as $term) {
                                        $checked = (is_array($current_loai) ? in_array($term->slug, $current_loai) : ($current_loai === $term->slug)) ? 'checked' : '';
                                        echo '<label class="cursor-pointer">
                                                <input type="checkbox" name="loai-bds[]" value="' . esc_attr($term->slug) . '" class="peer hidden" ' . $checked . '>
                                                <span class="px-5 py-2 rounded-full border border-gray-100 text-[13px] font-semibold peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary hover:border-primary transition inline-block text-gray-600 bg-gray-50/50">' . esc_html($term->name) . '</span>
                                            </label>';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Grid Filter Selects -->
                    <div class="grid grid-cols-3 gap-4">
                        <?php 
                        $compact_filters = array(
                            'loai-bds'   => 'Loại hình BĐS',
                            'phuong-xa'  => 'Khu vực',
                            'huong-nha'  => 'Hướng nhà',
                            'khu-dan-cu' => 'Khu dân cư'
                        );
                        foreach ($compact_filters as $tax => $label) : 
                        ?>
                            <div class="relative group">
                                <select name="<?php echo esc_attr($tax); ?>[]" multiple="multiple" data-placeholder="<?php echo $label; ?>" class="select2-multi appearance-none w-full border border-gray-100 rounded-xl pl-3 pr-8 py-3 text-base xl:text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer bg-gray-50/50">
                                    <?php $get_search_terms($tax, $label, false); ?>
                                </select>
                                <svg class="w-4 h-4 absolute right-2.5 top-6 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        <?php endforeach; ?>

                        <div class="relative custom-price-dropdown" id="price-dropdown-compact">
                            <button type="button" class="appearance-none w-full border border-[#e5e7eb] rounded-[20px] px-3 py-3 text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer bg-[#f9fafb] flex items-center justify-between group h-[48px]">
                                <span class="price-label font-normal" style="color: <?php echo $price_label_color; ?>"><?php echo esc_html($current_price_label); ?></span>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            
                            <!-- Hidden inputs to store values -->
                            <input type="hidden" name="khoang-gia" value="<?php echo isset($_GET['khoang-gia']) ? esc_attr($_GET['khoang-gia']) : ''; ?>">
                            <input type="hidden" name="gia_min" value="<?php echo isset($_GET['gia_min']) ? esc_attr($_GET['gia_min']) : ''; ?>">
                            <input type="hidden" name="gia_max" value="<?php echo isset($_GET['gia_max']) ? esc_attr($_GET['gia_max']) : ''; ?>">

                            <!-- Dropdown Menu -->
                            <div class="absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-[100] hidden price-menu">
                                <div class="max-h-60 overflow-y-auto no-scrollbar py-1">
                                    <?php 
                                    foreach($price_options as $val => $text): 
                                        $is_active = (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == $val) ? 'bg-primary/10 text-primary font-bold' : '';
                                    ?>
                                        <div class="px-4 py-2.5 text-sm hover:bg-gray-50 cursor-pointer price-opt <?php echo $is_active; ?>" data-value="<?php echo $val; ?>"><?php echo $text; ?></div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <!-- Custom Range -->
                                <div class="border-t border-gray-50 px-4 py-3 bg-gray-50/50 mt-1">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase mb-2">Tùy chỉnh (Tỷ)</p>
                                    <div class="flex items-center gap-2">
                                        <input type="number" placeholder="Từ" class="min-input w-full bg-white border border-gray-200 rounded-lg px-2 py-1.5 text-base md:text-xs outline-none focus:border-primary" value="<?php echo isset($_GET['gia_min']) ? esc_attr($_GET['gia_min']) : ''; ?>">
                                        <span class="text-gray-400">-</span>
                                        <input type="number" placeholder="Đến" class="max-input w-full bg-white border border-gray-200 rounded-lg px-2 py-1.5 text-base md:text-xs outline-none focus:border-primary" value="<?php echo isset($_GET['gia_max']) ? esc_attr($_GET['gia_max']) : ''; ?>">
                                    </div>
                                    <button type="button" class="apply-custom-price w-full mt-2 bg-primary text-white text-[11px] font-bold py-1.5 rounded-lg hover:bg-black transition">Áp dụng</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <button type="submit" class="w-full h-[48px] bg-primary hover:bg-black text-white font-bold rounded-xl transition shadow-lg shadow-primary/20 active:scale-[0.98]">Tìm ngay</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Mobile/Tablet Drawer Search Overlay & Panel -->
        <div id="mobile-filter-drawer" class="fixed inset-0 z-[9999] opacity-0 invisible transition-all duration-300 pointer-events-none xl:hidden">
            <!-- Glassmorphism Overlay (Click to close) -->
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 close-filter-drawer" id="mobile-filter-overlay"></div>
            
            <!-- Content Panel -->
            <div id="mobile-filter-panel" class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl transform translate-y-full transition-transform duration-300 max-h-[90dvh] flex flex-col">
                <!-- Handle bar for aesthetic -->
                <div class="flex-shrink-0 flex justify-center py-2.5">
                    <div class="w-10 h-1 rounded-full bg-gray-200"></div>
                </div>

                <!-- Header -->
                <div class="flex-shrink-0 flex items-center justify-between px-5 pb-3 bg-white border-b border-gray-100 z-10">
                    <h3 class="font-bold text-lg text-gray-900">Lọc Bất Động Sản</h3>
                    <button type="button" class="close-filter-drawer p-2 -mr-1 text-gray-900 bg-gray-100 rounded-full active:bg-gray-200 transition-colors" aria-label="Đóng">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Body (Scrollable Content) -->
                <div class="flex-grow overflow-y-auto px-5 py-6 scrollbar-hide">
                    <div class="flex flex-col space-y-6">
                        <!-- Keyword Search in Drawer (Full Width) -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Từ khóa / Mã BĐS</label>
                            <div class="relative">
                                <input type="text" name="s" value="<?php echo get_search_query(); ?>" 
                                       placeholder="Nhập tiêu đề hoặc mã BĐS..." 
                                       class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3.5 text-base focus:border-primary focus:bg-white outline-none transition shadow-sm">
                                <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                        </div>

                        <!-- Taxonomies & Price Grid (2 Columns) -->
                        <div class="grid grid-cols-2 gap-4">
                            <?php 
                            $drawer_selects = array(
                                'hinh-thuc-bds' => 'Hình thức',
                                'loai-bds'      => 'Loại hình BĐS',
                                'phuong-xa'     => 'Khu vực',
                                'huong-nha'     => 'Hướng nhà',
                                'khu-dan-cu'    => 'Khu dân cư'
                            );

                            foreach ($drawer_selects as $tax => $label) : 
                                $has_val = (isset($_GET[$tax]) && !empty($_GET[$tax])) || is_tax($tax);
                            ?>
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider"><?php echo $label; ?></label>
                                    <div class="relative">
                                        <select name="<?php echo esc_attr($tax); ?>[]" multiple="multiple" data-placeholder="<?php echo $label; ?>" class="select2-multi appearance-none w-full bg-gray-50 border rounded-xl pl-3 pr-8 py-3 text-base font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm <?php echo $has_val ? 'border-primary ring-1 ring-primary/10 bg-white' : 'border-gray-100'; ?>">
                                            <?php $get_search_terms($tax, $label, false); ?>
                                        </select>
                                        <svg class="w-4 h-4 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Khoảng giá Custom Dropdown (Drawer) -->
                            <div class="space-y-2 custom-price-dropdown" id="price-dropdown-drawer">
                                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Khoảng giá</label>
                                <div class="relative">
                                    <button type="button" class="appearance-none w-full bg-white border border-[#e5e7eb] rounded-xl pl-4 pr-8 py-3 text-base font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer text-left flex items-center justify-between group">
                                        <span class="price-label font-normal" style="color: <?php echo $price_label_color; ?>"><?php echo esc_html($current_price_label); ?></span>
                                        <svg class="w-4 h-4 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </button>
                                    
                                    <input type="hidden" name="khoang-gia" value="<?php echo isset($_GET['khoang-gia']) ? esc_attr($_GET['khoang-gia']) : ''; ?>">
                                    <input type="hidden" name="gia_min" value="<?php echo isset($_GET['gia_min']) ? esc_attr($_GET['gia_min']) : ''; ?>">
                                    <input type="hidden" name="gia_max" value="<?php echo isset($_GET['gia_max']) ? esc_attr($_GET['gia_max']) : ''; ?>">

                                    <div class="absolute bottom-full left-0 mb-2 w-full bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-[100] hidden price-menu">
                                        <div class="max-h-60 overflow-y-auto no-scrollbar py-1">
                                            <?php foreach($price_options as $val => $text): 
                                                $is_active = (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == $val) ? 'bg-primary/10 text-primary font-bold' : '';
                                            ?>
                                                <div class="px-4 py-2.5 text-sm hover:bg-gray-50 cursor-pointer price-opt <?php echo $is_active; ?>" data-value="<?php echo $val; ?>"><?php echo $text; ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="border-t border-gray-50 px-4 py-4 bg-gray-50/50 mt-1">
                                            <p class="text-[11px] font-bold text-gray-400 uppercase mb-3">Tùy chỉnh (Tỷ)</p>
                                            <div class="grid grid-cols-2 gap-2 mb-3">
                                                <input type="number" placeholder="Từ" class="min-input w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-base outline-none focus:border-primary" value="<?php echo isset($_GET['gia_min']) ? esc_attr($_GET['gia_min']) : ''; ?>">
                                                <input type="number" placeholder="Đến" class="max-input w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-base outline-none focus:border-primary" value="<?php echo isset($_GET['gia_max']) ? esc_attr($_GET['gia_max']) : ''; ?>">
                                            </div>
                                            <button type="button" class="apply-custom-price w-full bg-primary text-white text-base font-bold py-2.5 rounded-lg hover:bg-black transition">Áp dụng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer (Fixed Bottom Actions) -->
                <div class="flex-shrink-0 bg-white border-t border-gray-100 px-5 py-4 grid grid-cols-2 gap-3 shadow-[0_-4px_10px_rgba(0,0,0,0.03)] pb-[calc(1rem+env(safe-area-inset-bottom))]">
                    <button type="button" class="reset-search-form flex items-center justify-center bg-gray-50 text-gray-700 font-bold py-3.5 rounded-xl text-sm transition hover:bg-100">
                        Xoá lọc
                    </button>
                    <button type="submit" class="bg-primary text-white font-bold py-3.5 rounded-xl text-sm transition hover:bg-black shadow-lg shadow-primary/20">
                        Áp dụng
                    </button>
                </div>
            </div>
        </div>
    <?php else : ?>
        <!-- Original Full Form (Used in Home/Sidebar) -->
        <?php if (!$is_sidebar) : ?>
            <p class="text-xl md:text-2xl font-bold text-gray-900 mb-6">Tìm kiếm Bất Động Sản</p>
        <?php endif; ?>

        <div class="space-y-4 md:space-y-6">
            <!-- Keyword search -->
            <div class="relative">
                <input type="text" name="s" value="<?php echo get_search_query(); ?>" 
                       placeholder="Nhập tiêu đề hoặc mã BĐS..." 
                       class="w-full border border-gray-200 rounded-xl px-4 py-3.5 text-base focus:border-primary focus:bg-white outline-none transition shadow-sm">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>

            <!-- Radio: Bán / Cho thuê -->
            <div class="flex flex-wrap gap-x-2 gap-y-4 items-center">
                <div class="flex flex-wrap gap-2">
                    <?php
                    $hinh_thuc_terms = duc_bds_get_cached_terms('hinh-thuc-bds');
                    $current_hinh_thuc = isset($_GET['hinh-thuc-bds']) ? $_GET['hinh-thuc-bds'] : '';
                    if (!empty($hinh_thuc_terms) && !is_wp_error($hinh_thuc_terms)) :
                        foreach ($hinh_thuc_terms as $index => $term) :
                            $checked = (is_array($current_hinh_thuc) ? in_array($term->slug, $current_hinh_thuc) : ($current_hinh_thuc == $term->slug)) ? 'checked' : '';
                    ?>
                        <label class="cursor-pointer">
                            <input type="checkbox" name="hinh-thuc-bds[]" value="<?php echo esc_attr($term->slug); ?>" class="peer hidden" <?php echo $checked; ?>>
                            <span class="px-5 py-2.5 rounded-full border border-gray-200 text-sm font-semibold peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary hover:border-primary transition inline-block text-gray-700"><?php echo esc_html($term->name); ?></span>
                        </label>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="hidden md:block w-px h-8 bg-gray-100 mx-2"></div>

                <!-- Featured Categories (loai-bds) -->
                <div class="flex flex-wrap gap-2">
                    <?php
                    // Get featured categories from ACF Options
                    $featured_loai_ids = get_field('loại_hinh_bds_noi_bat', 'options');
                    $loai_bds_terms = array();

                    if (!empty($featured_loai_ids)) {
                        $loai_bds_terms = get_terms(array(
                            'taxonomy'   => 'loai-bds',
                            'include'    => $featured_loai_ids,
                            'hide_empty' => false,
                            'orderby'    => 'include', // Keep the order set in ACF
                        ));
                    }
                    
                    $current_loai = isset($_GET['loai-bds']) ? $_GET['loai-bds'] : '';
                    ?>

                    <?php if (!empty($loai_bds_terms) && !is_wp_error($loai_bds_terms)) : ?>
                        <?php foreach ($loai_bds_terms as $term) : ?>
                            <label class="cursor-pointer">
                                <input type="checkbox" name="loai-bds[]" value="<?php echo esc_attr($term->slug); ?>" class="peer hidden" <?php echo (is_array($current_loai) ? in_array($term->slug, $current_loai) : ($current_loai === $term->slug)) ? 'checked' : ''; ?>>
                                <span class="px-5 py-2.5 rounded-full border border-gray-200 text-sm font-semibold peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary hover:border-primary transition inline-block text-gray-700"><?php echo esc_html($term->name); ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Grid Selects -->
            <div class="<?php echo $is_sidebar ? 'space-y-4' : 'grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4'; ?>">
                <div class="relative group col-span-2 md:col-span-1">
                    <select name="loai-bds[]" multiple="multiple" data-placeholder="Loại hình BĐS" class="select2-multi appearance-none w-full border border-gray-200 rounded-xl pl-3 pr-8 py-3 text-base md:text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm"><?php $get_search_terms('loai-bds', 'Loại hình BĐS', false); ?></select>
                    <svg class="w-4 h-4 absolute right-2.5 top-6 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
                <div class="relative group">
                    <select name="phuong-xa[]" multiple="multiple" data-placeholder="Khu vực" class="select2-multi appearance-none w-full border border-gray-200 rounded-xl pl-3 pr-8 py-3 text-base md:text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm"><?php $get_search_terms('phuong-xa', 'Khu vực', false); ?></select>
                    <svg class="w-4 h-4 absolute right-2.5 top-6 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
                <div class="relative group">
                    <select name="huong-nha[]" multiple="multiple" data-placeholder="Hướng nhà" class="select2-multi appearance-none w-full border border-gray-200 rounded-xl pl-3 pr-8 py-3 text-base md:text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm"><?php $get_search_terms('huong-nha', 'Hướng nhà', false); ?></select>
                    <svg class="w-4 h-4 absolute right-2.5 top-6 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
                <div class="relative group">
                    <select name="khu-dan-cu[]" multiple="multiple" data-placeholder="Khu dân cư" class="select2-multi appearance-none w-full border border-gray-200 rounded-xl pl-3 pr-8 py-3 text-base md:text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm"><?php $get_search_terms('khu-dan-cu', 'Khu dân cư', false); ?></select>
                    <svg class="w-4 h-4 absolute right-2.5 top-6 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>

                <!-- Khoảng giá Custom Dropdown (Home/Sidebar) -->
                <div class="relative group custom-price-dropdown col-span-1" id="price-dropdown-home">
                    <button type="button" class="appearance-none w-full border border-gray-200 rounded-xl pl-2 pr-8 py-3 text-base md:text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer text-left flex items-center justify-between bg-white">
                        <span class="price-label font-normal" style="color: <?php echo $price_label_color; ?>"><?php echo esc_html($current_price_label); ?></span>
                        <svg class="w-4 h-4 absolute right-2.5 top-6 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    
                    <input type="hidden" name="khoang-gia" value="<?php echo isset($_GET['khoang-gia']) ? esc_attr($_GET['khoang-gia']) : ''; ?>">
                    <input type="hidden" name="gia_min" value="<?php echo isset($_GET['gia_min']) ? esc_attr($_GET['gia_min']) : ''; ?>">
                    <input type="hidden" name="gia_max" value="<?php echo isset($_GET['gia_max']) ? esc_attr($_GET['gia_max']) : ''; ?>">

                    <div class="absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-[100] hidden price-menu">
                        <div class="max-h-60 overflow-y-auto no-scrollbar py-1">
                            <?php foreach($price_options as $val => $text): 
                                $is_active = (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == $val) ? 'bg-primary/10 text-primary font-bold' : '';
                            ?>
                                <div class="px-4 py-2.5 text-sm hover:bg-gray-50 cursor-pointer price-opt <?php echo $is_active; ?>" data-value="<?php echo $val; ?>"><?php echo $text; ?></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="border-t border-gray-50 px-4 py-4 bg-gray-50/50 mt-1">
                            <p class="text-[11px] font-bold text-gray-400 uppercase mb-3">Tùy chỉnh (Tỷ)</p>
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                <input type="number" placeholder="Từ" class="min-input w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-base outline-none focus:border-primary" value="<?php echo isset($_GET['gia_min']) ? esc_attr($_GET['gia_min']) : ''; ?>">
                                <input type="number" placeholder="Đến" class="max-input w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-base outline-none focus:border-primary" value="<?php echo isset($_GET['gia_max']) ? esc_attr($_GET['gia_max']) : ''; ?>">
                            </div>
                            <button type="button" class="apply-custom-price w-full bg-primary text-white text-sm font-bold py-2.5 rounded-lg hover:bg-black transition">Áp dụng</button>
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <button type="submit" class="w-full bg-primary hover:bg-black text-white font-bold py-3 md:py-3.5 rounded-xl transition shadow-lg shadow-primary/20 active:scale-[0.98]">Tìm kiếm ngay</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>
