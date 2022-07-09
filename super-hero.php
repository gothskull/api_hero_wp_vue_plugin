<?php

/**
 *
 *Plugin Name:       Super Hero API
 *Plugin URI:        bogotawebcompany.com
 *Description:       Plugin desarrollado para integrar el API de super hero.
 *Version:           1.0.0
 *Author:            Hernando j Chaves
 *Author URI:        bogotawebcompany.com
 *License:           GPL-2.0+
 *License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *Text Domain:       
 */

if (!defined('ABSPATH')) : die;
endif;

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) :
    require_once dirname(__FILE__) . '/vendor/autoload.php';
endif;

if (!class_exists('MainSuperHero')) :

    final class MainSuperHero
    {

        public function __construct()
        {
            $this->hero_define_constant();
            add_action('plugins_loaded', [$this, 'hero_plugins_loaded']);
            register_activation_hook(__FILE__, [$this, 'hero_activation']);
            register_deactivation_hook(__FILE__, [$this, 'hero_deactivation']);
        }
        /**
         * Define Constantes
         *
         * @return void
         */
        public function hero_define_constant()
        {
            if (!defined('HERO_VERSION')) :
                define('HERO_VERSION', '1.0.0');
            endif;

            if (!defined('HERO_DOMAIN')) :
                define('HERO_DOMAIN', 'super-hero');
            endif;

            if (!defined('HERO_PATH')) :
                define('HERO_PATH', trailingslashit(plugin_dir_path(__FILE__)));
            endif;

            if (!defined('HERO_URL')) :
                define('HERO_URL', trailingslashit(plugins_url('', __FILE__)));
            endif;
        }

        /**
         * Carga las clases
         *
         * @return void
         */
        public function hero_plugins_loaded()
        {
            new Settings();
            new ShortCodeClass();
            new ScriptsClass();
            new MenuClass();
        }

        /**
         * Aciones al activar el plugin
         *
         * @return void
         */
        public function hero_activation()
        {
        }

        /**
         * Aciones al desactivar el plugin
         *
         * @return void
         */
        public function hero_deactivation()
        {
            (new Settings())->hero_remove_options();
        }

        /**
         * Implementa Singleton
         *
         * @return void
         */
        public static function hero_instance()
        {
            static $instance = false;

            if (!$instance) :
                $instance = new Self();
            endif;

            return $instance;
        }
    }

    if (!function_exists('hero_run')) :
        function hero_run()
        {
            return MainSuperHero::hero_instance();
        }
        hero_run();
    endif;
endif;
