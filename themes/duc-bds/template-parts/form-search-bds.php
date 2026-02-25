<?php
/**
 * Template part for displaying the property search form.
 *
 * @package Duc_BDS
 */

// Helper function to get terms for select options using transients
$get_search_terms = function($taxonomy, $label) {
    $terms = duc_bds_get_cached_terms($taxonomy);
    
    echo '<option value="">' . esc_html($label) . '</option>';
    
    // Get current term if on a taxonomy page
    $current_term_slug = '';
    if (is_tax($taxonomy)) {
        $queried_object = get_queried_object();
        $current_term_slug = $queried_object->slug;
    }
    // Override with GET parameter if exists
    if (isset($_GET[$taxonomy])) {
        $current_term_slug = $_GET[$taxonomy];
    }
    
    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $selected = ($current_term_slug === $term->slug) ? 'selected' : '';
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
        $form_classes = 'xl:bg-white xl:border xl:border-gray-100 xl:rounded-2xl xl:py-2 xl:px-4 mb-0 xl:mb-8 xl:sticky xl:top-[80px] z-30 xl:shadow-sm mx-auto max-w-7xl';
    }
} elseif ($is_sidebar) {
    $form_classes = 'space-y-4 [&_select]:border [&_select]:border-gray-300 [&_select]:rounded-xl [&_select]:px-4 [&_select]:py-3 [&_select]:bg-white';
} else {
    $form_classes = 'bg-white rounded-2xl shadow-lg p-6 lg:p-8 space-y-6 max-w-4xl mx-auto [&_select]:border [&_select]:border-gray-300 [&_select]:rounded-xl [&_select]:px-4 [&_select]:py-3';
}
?>

<form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="<?php echo esc_attr($form_classes); ?>" id="bds-search-form">
    <input type="hidden" name="post_type" value="bds">

    <?php if ($is_compact) : ?>
        <?php if (!$only_drawer) : ?>
            <!-- Desktop Compact Bar (Hidden on Mobile/Tablet) -->
            <div class="hidden xl:block px-2 md:px-0">
                <div class="flex items-center gap-1.5 md:gap-2">
                    <!-- Icon Lọc - Cố định -->
                    <div class="flex-shrink-0 flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-gray-50 rounded-full text-[13px] md:text-sm font-semibold text-gray-700 border border-gray-200">
                        <svg class="w-3.5 h-3.5 md:w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293-.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        <span>Lọc</span>
                    </div>

                    <!-- Vùng scrollable cho các bộ lọc -->
                    <div class="flex-grow flex items-center gap-1.5 md:gap-2 overflow-x-auto scrollbar-hide no-scrollbar py-0.5 touch-pan-x overscroll-x-contain">
                        <?php 
                        $compact_selects = array(
                            'hinh-thuc-bds' => 'Hình thức',
                            'loai-bds'      => 'Loại hình BĐS',
                            'phuong-xa'     => 'Khu vực',
                            'huong-nha'     => 'Hướng',
                            'khu-dan-cu'    => 'Khu dân cư'
                        );

                        foreach ($compact_selects as $tax => $label) : 
                            $has_val = (isset($_GET[$tax]) && !empty($_GET[$tax])) || is_tax($tax);
                            $item_bg = $has_val ? 'bg-black border-black text-white' : 'bg-white border-gray-200 text-gray-700';
                            $icon_color = $has_val ? 'text-white' : 'text-gray-400';
                        ?>
                            <div class="relative flex-shrink-0">
                                <select name="<?php echo esc_attr($tax); ?>" class="appearance-none border rounded-full pl-2.5 pr-6 md:pl-3 md:pr-7 py-1.5 md:py-2 text-[12px] md:text-sm font-medium focus:outline-none focus:border-primary transition cursor-pointer min-w-[90px] md:min-w-[110px] <?php echo $item_bg; ?>">
                                    <?php $get_search_terms($tax, $label); ?>
                                </select>
                                <svg class="w-3 h-3 md:w-4 h-4 absolute right-2 md:right-3 top-1/2 -translate-y-1/2 <?php echo $icon_color; ?> pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        <?php endforeach; ?>

                        <!-- Khoảng giá -->
                        <?php 
                            $has_gia = (isset($_GET['khoang-gia']) && !empty($_GET['khoang-gia']));
                            $gia_bg = $has_gia ? 'bg-black border-black text-white' : 'bg-white border-gray-200 text-gray-700';
                            $gia_icon = $has_gia ? 'text-white' : 'text-gray-400';
                        ?>
                        <div class="relative flex-shrink-0">
                            <select name="khoang-gia" class="appearance-none border rounded-full pl-2.5 pr-6 md:pl-3 md:pr-7 py-1.5 md:py-2 text-[12px] md:text-sm font-medium focus:outline-none focus:border-primary transition cursor-pointer min-w-[95px] md:min-w-[120px] <?php echo $gia_bg; ?>">
                                <option value="">Khoảng giá</option>
                                <option value="1000-3000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '1000-3000') ? 'selected' : ''; ?>>1 - 3 tỷ</option>
                                <option value="3000-5000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '3000-5000') ? 'selected' : ''; ?>>3 - 5 tỷ</option>
                                <option value="5000-10000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '5000-10000') ? 'selected' : ''; ?>>5 - 10 tỷ</option>
                                <option value="10000-50000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '10000-50000') ? 'selected' : ''; ?>>10 - 50 tỷ</option>
                                <option value="50000-100000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '50000-100000') ? 'selected' : ''; ?>>50 - 100 tỷ</option>
                                <option value="500000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '500000') ? 'selected' : ''; ?>>Dưới 500 tỷ</option>
                                <option value=">500000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '>500000') ? 'selected' : ''; ?>>Trên 500 tỷ</option>
                            </select>
                            <svg class="w-3 h-3 md:w-4 h-4 absolute right-2 md:right-3 top-1/2 -translate-y-1/2 <?php echo $gia_icon; ?> pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Nút Submit - Desktop -->
                    <div class="flex-shrink-0 flex items-center gap-1.5 ml-1">
                        <button type="submit" class="bg-primary hover:bg-black text-white px-5 py-2 rounded-full text-sm font-bold shadow-sm hover:shadow-md transition whitespace-nowrap">
                            Áp dụng
                        </button>
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
                                       placeholder="VD: BDS123, Vincity..." 
                                       class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3.5 focus:border-primary focus:bg-white outline-none transition shadow-sm">
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
                                        <select name="<?php echo esc_attr($tax); ?>" class="appearance-none w-full bg-gray-50 border rounded-xl pl-3 pr-8 py-3 text-[13px] font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm <?php echo $has_val ? 'border-primary ring-1 ring-primary/10 bg-white' : 'border-gray-100'; ?>">
                                            <?php $get_search_terms($tax, 'Tất cả'); ?>
                                        </select>
                                        <svg class="w-4 h-4 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Price Range in Grid -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Khoảng giá</label>
                                <div class="relative">
                                    <select name="khoang-gia" class="appearance-none w-full bg-gray-50 border border-gray-100 rounded-xl pl-3 pr-8 py-3 text-[13px] font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm">
                                        <option value="">Tất cả</option>
                                        <option value="1000-3000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '1000-3000') ? 'selected' : ''; ?>>1 - 3 tỷ</option>
                                        <option value="3000-5000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '3000-5000') ? 'selected' : ''; ?>>3 - 5 tỷ</option>
                                        <option value="5000-10000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '5000-10000') ? 'selected' : ''; ?>>5 - 10 tỷ</option>
                                        <option value="10000-50000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '10000-50000') ? 'selected' : ''; ?>>10 - 50 tỷ</option>
                                        <option value="50000-100000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '50000-100000') ? 'selected' : ''; ?>>50 - 100 tỷ</option>
                                        <option value="500000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '500000') ? 'selected' : ''; ?>>Dưới 500 tỷ</option>
                                        <option value=">500000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '>500000') ? 'selected' : ''; ?>>Trên 500 tỷ</option>
                                    </select>
                                    <svg class="w-4 h-4 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer (Fixed Bottom Actions) -->
                <div class="flex-shrink-0 bg-white border-t border-gray-100 px-5 py-4 grid grid-cols-2 gap-3 shadow-[0_-4px_10px_rgba(0,0,0,0.03)] pb-[calc(1rem+env(safe-area-inset-bottom))]">
                    <a href="<?php echo get_post_type_archive_link('bds'); ?>" class="flex items-center justify-center bg-gray-50 text-gray-700 font-bold py-3.5 rounded-xl text-sm transition hover:bg-gray-100">
                        Xoá lọc
                    </a>
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
                       class="w-full border border-gray-200 rounded-xl px-4 py-3.5 focus:border-primary focus:bg-white outline-none transition shadow-sm">
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
                            $checked = ($current_hinh_thuc == $term->slug) ? 'checked' : '';
                    ?>
                        <label class="cursor-pointer">
                            <input type="radio" name="hinh-thuc-bds" value="<?php echo esc_attr($term->slug); ?>" class="peer hidden" <?php echo $checked; ?>>
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
                                <input type="radio" name="loai-bds" value="<?php echo esc_attr($term->slug); ?>" class="peer hidden" <?php echo ($current_loai === $term->slug) ? 'checked' : ''; ?>>
                                <span class="px-5 py-2.5 rounded-full border border-gray-200 text-sm font-semibold peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary hover:border-primary transition inline-block text-gray-700"><?php echo esc_html($term->name); ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Grid Selects -->
            <div class="<?php echo $is_sidebar ? 'space-y-4' : 'grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4'; ?>">
                <div class="relative group">
                    <select name="loai-bds" class="appearance-none w-full border border-gray-200 rounded-xl pl-3 pr-8 py-3 text-[13px] md:text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm"><?php $get_search_terms('loai-bds', 'Loại hình BĐS'); ?></select>
                    <svg class="w-4 h-4 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
                <div class="relative group">
                    <select name="phuong-xa" class="appearance-none w-full border border-gray-200 rounded-xl pl-3 pr-8 py-3 text-[13px] md:text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm"><?php $get_search_terms('phuong-xa', 'Khu vực'); ?></select>
                    <svg class="w-4 h-4 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
                <div class="relative group">
                    <select name="huong-nha" class="appearance-none w-full border border-gray-200 rounded-xl pl-3 pr-8 py-3 text-[13px] md:text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm"><?php $get_search_terms('huong-nha', 'Hướng nhà'); ?></select>
                    <svg class="w-4 h-4 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
                <div class="relative group">
                    <select name="khu-dan-cu" class="appearance-none w-full border border-gray-200 rounded-xl pl-3 pr-8 py-3 text-[13px] md:text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm"><?php $get_search_terms('khu-dan-cu', 'Khu dân cư'); ?></select>
                    <svg class="w-4 h-4 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>

                <div class="relative group col-span-2 md:col-span-1">
                    <select name="khoang-gia" class="appearance-none w-full border border-gray-200 rounded-xl pl-3 pr-8 py-3 text-[13px] md:text-sm font-medium focus:outline-none focus:border-primary focus:bg-white transition cursor-pointer shadow-sm">
                        <option value="">Khoảng giá</option>
                        <option value="1000-3000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '1000-3000') ? 'selected' : ''; ?>>1 - 3 tỷ</option>
                        <option value="3000-5000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '3000-5000') ? 'selected' : ''; ?>>3 - 5 tỷ</option>
                        <option value="5000-10000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '5000-10000') ? 'selected' : ''; ?>>5 - 10 tỷ</option>
                        <option value="10000-50000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '10000-50000') ? 'selected' : ''; ?>>10 - 50 tỷ</option>
                        <option value="50000-100000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '50000-100000') ? 'selected' : ''; ?>>50 - 100 tỷ</option>
                        <option value="500000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '500000') ? 'selected' : ''; ?>>Dưới 500 tỷ</option>
                        <option value=">500000" <?php echo (isset($_GET['khoang-gia']) && $_GET['khoang-gia'] == '>500000') ? 'selected' : ''; ?>>Trên 500 tỷ</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-primary transition pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <button type="submit" class="w-full bg-primary hover:bg-black text-white font-bold py-3 md:py-3.5 rounded-xl transition shadow-lg shadow-primary/20 active:scale-[0.98]">Tìm kiếm ngay</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>
