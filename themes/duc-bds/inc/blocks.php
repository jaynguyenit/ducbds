<?php
/**
 * Register ACF Blocks and Fields
 */

add_action( 'acf/init', 'duc_bds_register_blocks' );
function duc_bds_register_blocks() {

	// Check function exists.
	if ( function_exists( 'acf_register_block_type' ) ) {

		// Register Property Listing block.
		acf_register_block_type(
			array(
				'name'            => 'property-listing',
				'title'           => __( 'Danh sách Bất động sản', 'duc-bds' ),
				'description'     => __( 'Khối tùy chỉnh để hiển thị danh sách BĐS theo phân loại.', 'duc-bds' ),
				'render_template' => 'template-parts/block/content-property-listing.php',
				'category'        => 'formatting',
				'icon'            => 'admin-home',
				'keywords'        => array( 'property', 'listing', 'bds', 'bat dong san' ),
			)
		);

		// Register Post Listing block.
		acf_register_block_type(
			array(
				'name'            => 'post-listing',
				'title'           => __( 'Danh sách Tin tức', 'duc-bds' ),
				'description'     => __( 'Hiển thị danh sách bài viết/tin tức từ Blog.', 'duc-bds' ),
				'render_template' => 'template-parts/block/content-post-listing.php',
				'category'        => 'formatting',
				'icon'            => 'admin-post',
				'keywords'        => array( 'post', 'news', 'blog', 'tin tuc' ),
			)
		);
	}
}

/**
 * Register Field Groups for Blocks
 */
add_action( 'acf/init', 'duc_bds_register_block_fields' );
function duc_bds_register_block_fields() {
	if ( function_exists( 'acf_add_local_field_group' ) ) {

		// Property Listing Fields
		acf_add_local_field_group(
			array(
				'key'      => 'group_block_property_listing',
				'title'    => 'Cấu hình Khối Danh sách BĐS',
				'fields'   => array(
					array(
						'key'   => 'field_block_pl_title',
						'label' => 'Tiêu đề khối',
						'name'  => 'title',
						'type'  => 'text',
						'default_value' => 'Bất động sản nổi bật',
					),
					// Terms for Loại hình BĐS
					array(
						'key'               => 'field_block_pl_terms_loai_bds',
						'label'             => 'Lọc theo: Loại hình BĐS',
						'name'              => 'terms_loai-bds',
						'type'              => 'taxonomy',
						'taxonomy'          => 'loai-bds',
						'field_type'        => 'multi_select',
						'add_term'          => 0,
						'save_terms'        => 0,
						'load_terms'        => 0,
						'return_format'     => 'id',
						'multiple'          => 1,
					),
					// Terms for Hình thức BĐS
					array(
						'key'               => 'field_block_pl_terms_hinh_thuc',
						'label'             => 'Lọc theo: Hình thức BĐS',
						'name'              => 'terms_hinh-thuc-bds',
						'type'              => 'taxonomy',
						'taxonomy'          => 'hinh-thuc-bds',
						'field_type'        => 'multi_select',
						'add_term'          => 0,
						'save_terms'        => 0,
						'load_terms'        => 0,
						'return_format'     => 'id',
						'multiple'          => 1,
					),
					// Terms for Phường / Xã
					array(
						'key'               => 'field_block_pl_terms_phuong_xa',
						'label'             => 'Lọc theo: Phường / Xã',
						'name'              => 'terms_phuong-xa',
						'type'              => 'taxonomy',
						'taxonomy'          => 'phuong-xa',
						'field_type'        => 'multi_select',
						'add_term'          => 0,
						'save_terms'        => 0,
						'load_terms'        => 0,
						'return_format'     => 'id',
						'multiple'          => 1,
					),
					// Terms for Loại đường
					array(
						'key'               => 'field_block_pl_terms_loai_duong',
						'label'             => 'Lọc theo: Loại đường',
						'name'              => 'terms_loai-duong',
						'type'              => 'taxonomy',
						'taxonomy'          => 'loai-duong',
						'field_type'        => 'multi_select',
						'add_term'          => 0,
						'save_terms'        => 0,
						'load_terms'        => 0,
						'return_format'     => 'id',
						'multiple'          => 1,
					),
					// Terms for Hướng nhà
					array(
						'key'               => 'field_block_pl_terms_huong_nha',
						'label'             => 'Lọc theo: Hướng nhà',
						'name'              => 'terms_huong-nha',
						'type'              => 'taxonomy',
						'taxonomy'          => 'huong-nha',
						'field_type'        => 'multi_select',
						'add_term'          => 0,
						'save_terms'        => 0,
						'load_terms'        => 0,
						'return_format'     => 'id',
						'multiple'          => 1,
					),
					// Terms for Tình trạng
					array(
						'key'               => 'field_block_pl_terms_tinh_trang',
						'label'             => 'Lọc theo: Tình trạng',
						'name'              => 'terms_tinh-trang',
						'type'              => 'taxonomy',
						'taxonomy'          => 'tinh-trang',
						'field_type'        => 'multi_select',
						'add_term'          => 0,
						'save_terms'        => 0,
						'load_terms'        => 0,
						'return_format'     => 'id',
						'multiple'          => 1,
					),
					array(
						'key'           => 'field_block_pl_count',
						'label'         => 'Số lượng hiển thị',
						'name'          => 'posts_per_page',
						'type'          => 'number',
						'default_value' => 5,
						'min'           => 1,
						'max'           => 20,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/property-listing',
						),
					),
				),
			)
		);

		// Post Listing Fields
		acf_add_local_field_group(
			array(
				'key'      => 'group_block_post_listing',
				'title'    => 'Cấu hình Khối Danh sách Tin tức',
				'fields'   => array(
					array(
						'key'   => 'field_block_post_title',
						'label' => 'Tiêu đề khối',
						'name'  => 'title',
						'type'  => 'text',
						'default_value' => 'Tin tức Bất Động Sản',
					),
					array(
						'key'   => 'field_block_post_subtitle',
						'label' => 'Mô tả ngắn',
						'name'  => 'subtitle',
						'type'  => 'textarea',
						'rows'  => 2,
						'default_value' => 'Cập nhật thông tin thị trường, xu hướng & chính sách mới nhất',
					),
					array(
						'key'     => 'field_block_post_mode',
						'label'   => 'Chế độ hiển thị',
						'name'    => 'mode',
						'type'    => 'select',
						'choices' => array(
							'latest'   => 'Bài viết mới nhất',
							'manual'   => 'Chọn bài viết tùy chọn',
						),
						'default_value' => 'latest',
						'ui' => 1,
					),
					array(
						'key'           => 'field_block_post_manual',
						'label'         => 'Chọn các bài viết',
						'name'          => 'selected_posts',
						'type'          => 'relationship',
						'post_type'     => array('post'),
						'filters'       => array('search', 'taxonomy'),
						'return_format' => 'id',
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_block_post_mode',
									'operator' => '==',
									'value'    => 'manual',
								),
							),
						),
					),
					array(
						'key'           => 'field_block_post_count',
						'label'         => 'Số lượng bài viết',
						'name'          => 'posts_per_page',
						'type'          => 'number',
						'default_value' => 3,
						'min'           => 1,
						'max'           => 12,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_block_post_mode',
									'operator' => '==',
									'value'    => 'latest',
								),
							),
						),
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/post-listing',
						),
					),
				),
			)
		);
	}
}
