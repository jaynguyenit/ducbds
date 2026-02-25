<?php
/**
 * The template for displaying all single bds (properties).
 */

get_header();

while ( have_posts() ) :
	the_post();

	// ACF Fields
	$ma_bds    = get_field( 'ma_bds' );
	$gia       = get_field( 'gia' );
	$rong      = get_field( 'rong' );
	$dai       = get_field( 'dai' );
	$so_pn     = get_field( 'so_pn' );
	$so_pvs    = get_field( 'so_pvs' );
	$hinh_anh  = get_field( 'hinh_anh' ); // Gallery
	$mo_ta     = get_the_content();

	// Taxonomies
	$phuong_xa  = get_the_terms( get_the_ID(), 'phuong-xa' );
	$huong_nha  = get_the_terms( get_the_ID(), 'huong-nha' );
	$loai_bds   = get_the_terms( get_the_ID(), 'loai-bds' );
	$hinh_thuc  = get_the_terms( get_the_ID(), 'hinh-thuc-bds' );

	// Format Price
	$gia_display = 'Liên hệ';
	if ( $gia ) {
		if ( $gia >= 1000 ) {
			$gia_display = ( $gia / 1000 ) . ' tỷ';
		} else {
			$gia_display = $gia . ' triệu';
		}
	}

	$dien_tich = ( $rong && $dai ) ? ( $rong * $dai ) . ' m² (' . $rong . 'x' . $dai . ')' : 'Đang cập nhật';
	?>

	<section class="bg-gray-50 pb-24 lg:pb-10 pt-6 lg:pt-10">
		<div class="max-w-7xl mx-auto px-4 md:px-6">
			<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

				<!-- LEFT COLUMN -->
				<div class="lg:col-span-8 space-y-6 md:space-y-8">
					
					<!-- Mobile Filter Trigger -->
					<div class="flex items-center justify-between lg:hidden mb-2">
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Thông tin chi tiết</h2>
                        <button type="button" class="open-filter-drawer flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 rounded-full text-[12px] font-bold text-gray-700 shadow-sm active:scale-95 transition-transform">
                            <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                            Lọc tìm kiếm
                        </button>
                    </div>

					<!-- GALLERY SLIDER -->
					<div class="bg-white rounded-2xl p-2 md:p-4 shadow-sm overflow-hidden relative">
						<?php if ( $hinh_anh ) : ?>
							<!-- Main Swiper -->
							<div class="swiper bds-main-slider aspect-[16/10] md:aspect-[16/10] min-h-[250px] md:min-h-[400px] rounded-xl overflow-hidden mb-2 md:mb-4 cursor-zoom-in group">
								<div class="swiper-wrapper">
									<?php foreach ( $hinh_anh as $img ) : ?>
										<div class="swiper-slide h-full">
											<?php 
											$img_src = is_array($img) ? $img['url'] : wp_get_attachment_url($img);
											$img_alt = is_array($img) ? $img['alt'] : get_post_meta($img, '_wp_attachment_image_alt', true);
											?>
											<img src="<?php echo esc_url( $img_src ); ?>" 
												 alt="<?php echo esc_attr( $img_alt ); ?>" 
												 class="w-full h-full object-cover"
												 data-full="<?php echo esc_url( $img_src ); ?>">
										</div>
									<?php endforeach; ?>
								</div>
								<!-- Fraction Pagination (Mobile & App Style) -->
								<div class="absolute bottom-4 right-4 z-10 bg-black/50 backdrop-blur-md text-white text-[10px] md:text-xs font-bold px-2.5 py-1 rounded-full pointer-events-none custom-fraction">
									<span class="current">1</span> / <span class="total"><?php echo count($hinh_anh); ?></span>
								</div>

								<!-- Navigation buttons (Desktop only) -->
								<div class="hidden md:flex swiper-button-next !text-white !bg-black/20 hover:!bg-black/40 !w-8 !h-8 !rounded-full after:!text-[12px] opacity-0 group-hover:opacity-100 transition"></div>
								<div class="hidden md:flex swiper-button-prev !text-white !bg-black/20 hover:!bg-black/40 !w-8 !h-8 !rounded-full after:!text-[12px] opacity-0 group-hover:opacity-100 transition"></div>
							</div>

							<!-- Thumbs Swiper -->
							<div class="swiper bds-thumb-slider h-16 sm:h-20 lg:h-24 mt-2">
								<div class="swiper-wrapper">
									<?php foreach ( $hinh_anh as $img ) : ?>
										<div class="swiper-slide rounded-lg overflow-hidden cursor-pointer opacity-60 hover:opacity-100 transition duration-300">
											<img src="<?php echo esc_url( $img['sizes']['thumbnail'] ); ?>" 
												 alt="<?php echo esc_attr( $img['alt'] ); ?>" 
												 class="w-full h-full object-cover">
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php else : ?>
							<div class="aspect-[16/10] bg-gray-100 flex items-center justify-center rounded-xl">
								<p class="text-gray-400 italic">Hiện tại chưa có hình ảnh cho sản phẩm này.</p>
							</div>
						<?php endif; ?>
					</div>

					<!-- PROPERTY INFO -->
					<div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm space-y-6">
						<div class="flex flex-col md:flex-row justify-between items-start gap-4">
							<div class="space-y-1.5 md:space-y-2">
								<h1 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">
									<?php the_title(); ?>
								</h1>
								<p class="text-gray-500 flex items-center gap-1.5 text-[13px] md:text-sm">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
									<?php 
										echo ( $phuong_xa && !is_wp_error($phuong_xa) ) ? esc_html( $phuong_xa[0]->name ) . ', TP.HCM' : 'TP.HCM';
									?>
								</p>
							</div>
							<div class="bg-primary/10 px-4 py-2.5 rounded-xl self-start">
								<p class="text-primary font-bold text-2xl whitespace-nowrap">
									<?php echo esc_html( $gia_display ); ?>
								</p>
							</div>
						</div>

						<!-- Information Chips (Modern Grid) -->
						<div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6 p-1 bg-white rounded-2xl">
							<div class="flex items-center gap-3 p-3.5 bg-gray-50 rounded-2xl border border-gray-100/50">
								<div class="w-10 h-10 flex-shrink-0 bg-white shadow-sm rounded-xl flex items-center justify-center text-primary">
									<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
								</div>
								<div class="min-w-0">
									<p class="text-[10px] text-gray-400 uppercase font-bold tracking-tight">Diện tích</p>
									<p class="text-gray-900 font-bold truncate text-[13px]"><?php echo ( $rong && $dai ) ? ( $rong * $dai ) . ' m²' : 'Đang cập nhật'; ?></p>
								</div>
							</div>

							<?php if ( ! empty( $so_pn ) ) : ?>
								<div class="flex items-center gap-3 p-3.5 bg-gray-50 rounded-2xl border border-gray-100/50">
									<div class="w-10 h-10 flex-shrink-0 bg-white shadow-sm rounded-xl flex items-center justify-center text-primary">
										<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
									</div>
									<div class="min-w-0">
										<p class="text-[10px] text-gray-400 uppercase font-bold tracking-tight">Phòng ngủ</p>
										<p class="text-gray-900 font-bold truncate text-[13px]"><?php echo esc_html( $so_pn ); ?> Phòng</p>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $so_pvs ) ) : ?>
								<div class="flex items-center gap-3 p-3.5 bg-gray-50 rounded-2xl border border-gray-100/50">
									<div class="w-10 h-10 flex-shrink-0 bg-white shadow-sm rounded-xl flex items-center justify-center text-primary">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16-10a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
									</div>
									<div class="min-w-0">
										<p class="text-[10px] text-gray-400 uppercase font-bold tracking-tight">Vệ sinh</p>
										<p class="text-gray-900 font-bold truncate text-[13px]"><?php echo esc_html( $so_pvs ); ?> Phòng</p>
									</div>
								</div>
							<?php endif; ?>

							<div class="flex items-center gap-3 p-3.5 bg-gray-50 rounded-2xl border border-gray-100/50">
								<div class="w-10 h-10 flex-shrink-0 bg-white shadow-sm rounded-xl flex items-center justify-center text-primary">
									<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 4L9 7"/></svg>
								</div>
								<div class="min-w-0">
									<p class="text-[10px] text-gray-400 uppercase font-bold tracking-tight">Hướng</p>
									<p class="text-gray-900 font-bold truncate text-[13px]"><?php echo ( $huong_nha && !is_wp_error($huong_nha) ) ? esc_html( $huong_nha[0]->name ) : 'Đang cập nhật'; ?></p>
								</div>
							</div>
						</div>

						<div class="space-y-4">
							<h3 class="text-lg font-bold text-gray-900 flex items-center gap-3">
                                <span class="w-1 h-6 bg-primary rounded-full"></span>
                                Mô tả chi tiết
                            </h3>
							<div class="prose max-w-none text-gray-600 leading-relaxed text-sm md:text-base">
								<?php if($mo_ta): ?>
									<?php the_content(); ?>
								<?php else: ?>
									<p class="italic text-gray-400">Không có mô tả chi tiết cho bất động sản này.</p>
								<?php endif; ?>
							</div>
						</div>
						
						<?php if($ma_bds): ?>
							<div class="pt-4 border-t border-gray-100">
								<p class="text-[13px] text-gray-500">Mã tin: <span class="font-bold text-gray-900"><?php echo esc_html($ma_bds); ?></span></p>
							</div>
						<?php endif; ?>

					</div>

					<!-- RELATED PROPERTIES -->
					<div class="space-y-6">
						<h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                            <span class="w-1 h-6 bg-primary rounded-full"></span>
							Bất động sản liên quan
						</h2>

						<?php
						$related_query = new WP_Query( array(
							'post_type'      => 'bds',
							'posts_per_page' => 3,
							'post__not_in'   => array( get_the_ID() ),
							'tax_query'      => ( $loai_bds && !is_wp_error($loai_bds) ) ? array(
								array(
									'taxonomy' => 'loai-bds',
									'field'    => 'term_id',
									'terms'    => $loai_bds[0]->term_id,
								),
							) : '',
						) );

						if ( $related_query->have_posts() ) :
						?>
						<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
							<?php
							while ( $related_query->have_posts() ) :
								$related_query->the_post();
								get_template_part( 'template-parts/content-bds-card' );
							endwhile;
							wp_reset_postdata();
							?>
						</div>
						<?php else: ?>
							<p class="text-gray-400 italic font-light">Không có bất động sản liên quan nào khác.</p>
						<?php endif; ?>
					</div>

				</div>

				<!-- RIGHT COLUMN (SIDEBAR) -->
				<aside class="lg:col-span-4 space-y-8">

					<div class="sticky top-24 space-y-6">
						<!-- CONTACT CARD (Desktop) -->
						<div class="hidden lg:block bg-primary rounded-2xl p-6 shadow-xl shadow-primary/10 text-white overflow-hidden relative">
                            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
							<h3 class="text-xl font-bold mb-4 relative z-10">Liên hệ tư vấn</h3>
							<p class="text-white/80 text-sm mb-6 relative z-10">Bạn quan tâm đến bất động sản này? Hãy liên hệ ngay với chúng tôi để được hỗ trợ tốt nhất.</p>
							
							<div class="space-y-4 relative z-10">
								<?php if(get_field('hotline','option')){ ?>
									<a href="tel:<?php echo get_field('hotline','option'); ?>" class="flex items-center gap-4 bg-white/10 hover:bg-white/20 p-4 rounded-2xl transition no-underline group">
										<div class="bg-white text-primary p-2.5 rounded-xl group-hover:scale-110 transition duration-300">
											<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
										</div>
										<div>
											<p class="text-[10px] text-white/60 uppercase font-bold">Hotline 24/7</p>
											<p class="font-bold text-lg"><?php echo get_field('hotline','option'); ?></p>
										</div>
									</a>
								<?php } ?>
								<?php if(get_field('zalo','option')){ ?>
									<a href="https://zalo.me/<?php echo get_field('zalo','option'); ?>" class="flex items-center gap-4 bg-white/10 hover:bg-white/20 p-4 rounded-2xl transition no-underline group">
										<div class="bg-white text-primary p-2.5 rounded-xl group-hover:scale-110 transition duration-300">
											<svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M12 2C6.48 2 2 5.58 2 10c0 1.87.79 3.59 2.1 4.89l-.51 2.37c-.12.56.38 1.05.93.9l2.45-.69C8.35 17.89 10.11 18 12 18c5.52 0 10-3.58 10-8s-4.48-8-10-8zm5 11h-5.61l5.51-5.61c.14-.14.21-.33.21-.52 0-.39-.31-.71-.7-.71h-6.41c-.28 0-.5.22-.5.5s.22.5.5.5h5.11l-5.01 5.1c-.14.15-.22.34-.22.54 0 .41.33.74.74.74h6.31c.28 0 .5-.21.5-.49 0-.28-.21-.5-.43-.5z" /></svg>
										</div>
										<div>
											<p class="text-[10px] text-white/60 uppercase font-bold">Zalo tư vấn</p>
											<p class="font-bold text-lg">Nhắn tin ngay</p>
										</div>
									</a>
								<?php } ?>
							</div>
						</div>

						<!-- SEARCH BOX (Desktop Only) -->
						<div class="hidden lg:block bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
							<h3 class="text-lg font-bold mb-4 text-gray-900">Tìm kiếm Bất động sản</h3>
							<?php get_template_part('template-parts/form-search-bds', null, array('is_sidebar' => true)); ?>
						</div>
					</div>

				</aside>

			</div>
		</div>
	</section>

	<?php 
	// Include the drawer structure for mobile
	get_template_part('template-parts/form-search-bds', null, array('is_compact' => true, 'only_drawer' => true)); 
	?>

    <!-- STICKY BOTTOM CTA (Mobile Only - Native App Style) -->
    <div id="sticky-bottom-cta" class="lg:hidden fixed bottom-0 left-0 right-0 z-50 p-4 pb-[calc(1rem+env(safe-area-inset-bottom))] bg-white/80 backdrop-blur-xl border-t border-gray-100 shadow-[0_-8px_30px_rgb(0,0,0,0.08)]">
        <div class="grid grid-cols-2 gap-3 max-w-xl mx-auto">
			<?php if(get_field('zalo','option')){ ?>
				<a href="https://zalo.me/<?php echo get_field('zalo','option'); ?>" class="flex items-center justify-center gap-2 bg-primary text-white font-bold py-3.5 rounded-2xl text-[13px] shadow-lg shadow-primary/20 active:scale-95 transition-transform duration-200">
					<svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M12 2C6.48 2 2 5.58 2 10c0 1.87.79 3.59 2.1 4.89l-.51 2.37c-.12.56.38 1.05.93.9l2.45-.69C8.35 17.89 10.11 18 12 18c5.52 0 10-3.58 10-8s-4.48-8-10-8zm5 11h-5.61l5.51-5.61c.14-.14.21-.33.21-.52 0-.39-.31-.71-.7-.71h-6.41c-.28 0-.5.22-.5.5s.22.5.5.5h5.11l-5.01 5.1c-.14.15-.22.34-.22.54 0 .41.33.74.74.74h6.31c.28 0 .5-.21.5-.49 0-.28-.21-.5-.43-.5z" /></svg>
					Zalo tư vấn
				</a>
			<?php } ?>
			<?php  if(get_field('hotline','option')){ ?>
				<a href="tel:<?php echo get_field('hotline','option'); ?>" class="flex items-center justify-center gap-2 bg-primary text-white font-bold py-3.5 rounded-2xl text-[13px] shadow-lg shadow-primary/20 active:scale-95 transition-transform duration-200">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
					Gọi ngay
				</a>
			<?php } ?>
        </div>
    </div>

	<!-- LIGHTBOX MODAL -->
	<div id="gallery-lightbox" class="fixed inset-0 z-[9999] bg-black/95 hidden items-center justify-center">
		<!-- Close Button -->
		<button id="close-lightbox" class="absolute top-6 right-6 z-50 text-white hover:text-gray-300 transition focus:outline-none">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
			</svg>
		</button>
		
		<!-- Modal Swiper -->
		<div class="swiper modal-swiper w-full h-full p-4 md:p-0">
			<div class="swiper-wrapper">
				<?php if ( $hinh_anh ) : ?>
					<?php foreach ( $hinh_anh as $img ) : ?>
						<div class="swiper-slide flex items-center justify-center h-full w-full">
							<img src="<?php echo esc_url( $img['url'] ); ?>" 
								 alt="<?php echo esc_attr( $img['alt'] ); ?>" 
								 class="max-w-full max-h-full object-contain select-none shadow-2xl mx-auto">
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<!-- Navigation arrows -->
			<div class="swiper-button-next !text-white !w-12 !h-12 after:!text-2xl"></div>
			<div class="swiper-button-prev !text-white !w-12 !h-12 after:!text-2xl"></div>
		</div>
	</div>

	<!-- SWIPER INITIALIZATION -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Elements for Fraction Pagination
			const fractionCurrent = document.querySelector('.custom-fraction .current');
			const fractionTotal = document.querySelector('.custom-fraction .total');
			const lightbox = document.getElementById('gallery-lightbox');
			const closeBtn = document.getElementById('close-lightbox');

			// Initialize Thumb Slider
			const thumbSwiper = new Swiper('.bds-thumb-slider', {
				spaceBetween: 8,
				slidesPerView: 4,
				freeMode: true,
				watchSlidesProgress: true,
				breakpoints: {
					640: { 
						slidesPerView: 5,
						spaceBetween: 10
					},
					1024: { 
						slidesPerView: 7,
						spaceBetween: 12
					}
				}
			});

			// Initialize Main Slider
			const mainSwiper = new Swiper('.bds-main-slider', {
				spaceBetween: 10,
				grabCursor: true,
				loop: true,
				speed: 600,
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
				thumbs: thumbSwiper ? { swiper: thumbSwiper } : undefined,
				on: {
					slideChange: function(swiper) {
						if (fractionCurrent) {
							fractionCurrent.textContent = (swiper.realIndex + 1);
						}
					}
				}
			});

			// Initialize Modal Swiper (Lightbox)
			const modalSwiper = new Swiper('.modal-swiper', {
				slidesPerView: 1,
				spaceBetween: 0,
				centeredSlides: true,
				grabCursor: true,
				zoom: {
					maxRatio: 3,
					minRatio: 1,
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
				keyboard: {
					enabled: true,
				},
			});

			// Lightbox Logic via Swiper Click
			mainSwiper.on('click', function(swiper, e) {
				// Only trigger if a slide was clicked
				if (e.target.closest('.swiper-slide')) {
					const index = swiper.realIndex;
					lightbox.classList.remove('hidden');
					lightbox.classList.add('flex');
					document.body.style.overflow = 'hidden';
					
					modalSwiper.update();
					modalSwiper.slideTo(index, 0);
				}
			});

			const closeLightbox = () => {
				lightbox.classList.add('hidden');
				lightbox.classList.remove('flex');
				document.body.style.overflow = '';
			};

			if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
			
			lightbox.addEventListener('click', (e) => {
				if (e.target.classList.contains('swiper-slide') || e.target === lightbox) {
					closeLightbox();
				}
			});

			document.addEventListener('keydown', (e) => {
				if (e.key === 'Escape') closeLightbox();
			});
		});
	</script>

	<?php
endwhile;

get_footer();
