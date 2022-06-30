<?php

/**
 * FAQs Post Type
 */
if (!function_exists('lightweight_faq_post_type')) :
	function lightweight_faq_post_type()
	{
		/**
		 * FAQs
		 */
		register_post_type(
			'FAQ',
			array(
				'public'              => true,
				'has_archive'         => 'faq-item',
				'menu_position'       => 25,
				'menu_icon'           => 'dashicons-buddicons-topics',
				'exclude_from_search' => false,

				'labels' => array(
					'name'               => esc_html__('FAQs', 'lwfaqs'),
					'singular_name'      => esc_html__('FAQ', 'lwfaqs'),
					'menu_name'          => esc_html__('FAQs', 'lwfaqs'),
					'name_admin_bar'     => esc_html__('FAQ', 'lwfaqs'),
					'add_new'            => esc_html__('Add New', 'lwfaqs'),
					'add_new_item'       => esc_html__('Add New FAQ', 'lwfaqs'),
					'new_item'           => esc_html__('New FAQ', 'lwfaqs'),
					'edit_item'          => esc_html__('Edit FAQ', 'lwfaqs'),
					'view_item'          => esc_html__('View FAQ', 'lwfaqs'),
					'all_items'          => esc_html__('All FAQs', 'lwfaqs'),
					'search_items'       => esc_html__('Search FAQs', 'lwfaqs'),
					'not_found'          => esc_html__('No FAQs found.', 'lwfaqs'),
					'not_found_in_trash' => esc_html__('No FAQs found in Trash.', 'lwfaqs'),
				),

				'taxonomies' => array(
					"category"
				),

				'supports' => array(
					"title",
					"editor",
				),
			)
		);
	}
	add_action('init', 'lightweight_faq_post_type');
endif;
