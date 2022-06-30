<?php

/**
 * FAQs Shortcode
 */
if (!function_exists('lightweight_faq_shortcode')) :
	/**
	 * FAQs
	 */
	function lightweight_faq_shortcode($atts)
	{
		extract(shortcode_atts(array(
			"cat"         => '',
			"num"         => '',
		), $atts));

		// query
		$args = array(
			'order'			 => 'DESC',
			'orderby'        => 'date',
			'post_type'      => 'faq',
			'category_name'  => esc_attr($cat),
			'posts_per_page' => esc_attr($num)
		);

		$lightweight_faq = new WP_Query($args);

		$output = '';

		$output .= '<div id="lightweight-faq" class="lightweight-faq" data-aos="zoom-in-up">';

		global $post;

		$allowed_html = array(
			'a' => array(
				'href'  => array(),
				'title' => array(),
				'class' => array()
			),
			'p' => array(),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
			'b' => array(),
		);

		while ($lightweight_faq->have_posts()) : $lightweight_faq->the_post();
			$posttitle = get_the_title();
			$content   = get_the_content();
			$slug      = $post->post_name;

			$output .= '
					<div class="lightweight-faq-item">
						<div class="lightweight-faq-toggle lightweight-toggler">' . esc_html($posttitle) . ' <i class="fas fa-plus"></i></div>
						<div class="lightweight-faq-content">' . nl2br(wp_kses($content, $allowed_html)) . '</div>
					</div>
				';
		endwhile;

		$output .= '
		</div>
		';

		wp_reset_postdata();

		$output = shortcode_unautop($output);
		return force_balance_tags($output);
	}
	add_shortcode('lightweight-faq', 'lightweight_faq_shortcode');
endif;
