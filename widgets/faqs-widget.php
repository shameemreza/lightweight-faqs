<?php

/**
 * Elementor FAQs Widget
 */
class Lightweight_Faq_Widget extends \Elementor\Widget_Base
{
	/**
	 * Widget name
	 */
	public function get_name()
	{
		return 'faqs';
	}
	/**
	 * Widget title
	 */
	public function get_title()
	{
		return esc_html__('Lightweight FAQs', 'lwfaqs');
	}
	/**
	 * Widget icon
	 */
	public function get_icon()
	{
		return 'eicon-posts-ticker';
	}
	/**
	 * Widget category
	 */
	public function get_categories()
	{
		return ['lightweight-faq-widgets'];
	}
	/**
	 * Widget controls
	 */
	protected function _register_controls()
	{
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Settings', 'lwfaqs'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => esc_html__('Category', 'lwfaqs'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => esc_html__('faqs-category', 'lwfaqs'),
			]
		);

		$this->add_control(
			'number',
			[
				'label'       => esc_html__('Number of faq items to display', 'lwfaqs'),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'input_type'  => 'number',
				'placeholder' => esc_html__('6', 'lwfaqs'),
				'default'     => esc_html__('6', 'lwfaqs'),
			]
		);

		$this->end_controls_section();
	}
	/**
	 * Render widget output
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$cat = esc_attr($settings['category']);
		$num = esc_attr($settings['number']);

		echo do_shortcode('[lightweight-faq cat="' . $cat . '" num="' . $num . '"]');
	}
}
