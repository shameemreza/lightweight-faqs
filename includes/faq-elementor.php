<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
/**
 * FAQs Extension Class
 */
final class Lightweight_Faq_Extension
{
    /**
     * Plugin Version
     *
     * @since 1.0.0
     *
     * @var string The plugin version.
     */
    const VERSION = '1.0.0';
    /**
     * Minimum Elementor Version
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    /**
     * Minimum PHP Version
     */
    const MINIMUM_PHP_VERSION = '7.0';
    /**
     * Instance
     */
    private static $_instance = null;
    /**
     * Ensures only one instance of the class is loaded or can be loaded.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('init', [$this, 'i18n']);
        add_action('plugins_loaded', [$this, 'init']);
    }
    /**
     * Load plugin localization files.
     */
    public function i18n()
    {
        load_plugin_textdomain('lwfaqs');
    }
    /**
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed load the files required to run the plugin.
     */
    public function init()
    {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        // Register widgets
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
    }
    /**
     * Warning when the site doesn't have Elementor installed or activated.
     */
    public function admin_notice_missing_main_plugin()
    {
        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'lwfaqs'),
            '<strong>' . esc_html__('Lightweight FAQs Extension', 'lwfaqs') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'lwfaqs') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    /**
     * Warning when the site doesn't have a minimum required Elementor version.
     */
    public function admin_notice_minimum_elementor_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'lwfaqs'),
            '<strong>' . esc_html__('Lightweight FAQs Extension', 'lwfaqs') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'lwfaqs') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    /**
     * Warning when the site doesn't have a minimum required PHP version.
     */
    public function admin_notice_minimum_php_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'lwfaqs'),
            '<strong>' . esc_html__('Lightweight FAQs Extension', 'lwfaqs') . '</strong>',
            '<strong>' . esc_html__('PHP', 'lwfaqs') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    /**
     * Include Files
     */
    public function includes()
    {
        require_once(__DIR__ . '/../widgets/faqs-widget.php');
    }
    /**
     * Register Widget
     */
    public function register_widgets()
    {
        // Include plugin files
        $this->includes();
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Lightweight_Faq_Widget());
    }
}
Lightweight_Faq_Extension::instance();
