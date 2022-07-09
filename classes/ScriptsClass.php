<?php

if (!defined('ABSPATH')) : die;
endif;

if (!class_exists('ScriptsClass')) :

    class ScriptsClass
    {
        public function __construct()
        {
            add_action('wp_enqueue_scripts', [$this, 'hero_all_scripts']);
        }

        public function hero_all_scripts()
        {
            $this->hero_add_scripts($this->hero_scripts());
            $this->hero_add_styles($this->hero_styles());
        }
        /**
         * Encola los scripts
         *
         * @param [type] $scripts
         * @return void
         */
        public function hero_add_scripts($scripts)
        {
            $this->hero_loop_scripts($scripts);
        }
        /**
         * Carga los scripts
         *
         * @return Array
         */
        public function hero_scripts()
        {
            $scripts = [
                'manifest' => [
                    'src'       => HERO_URL . '/assets/js/manifest.js',
                    'deps'      => [],
                    'ver'       => \filemtime(HERO_PATH . '/assets/js/manifest.js'),
                    'in_footer' => true,
                ],
                'vendor' => [
                    'src'       => HERO_URL . '/assets/js/vendor.js',
                    'deps'      => ['manifest'],
                    'ver'       => \filemtime(HERO_PATH . '/assets/js/vendor.js'),
                    'in_footer' => true,
                ],
                'mainjs' => [
                    'src'       => HERO_URL . '/assets/js/main.js',
                    'deps'      => ['vendor'],
                    'ver'       => \filemtime(HERO_PATH . '/assets/js/main.js'),
                    'in_footer' => true,
                ],
            ];

            return $scripts;
        }
        /**
         * Encola los estilos
         *
         * @param [type] $styles
         * @return void
         */
        public function hero_add_styles($styles)
        {
            $this->hero_loop_scripts($styles);
        }
        /**
         * Recorre Estilos y Scripts
         *
         * @param [type] $scripts
         * @return void
         */
        public function hero_loop_scripts($scripts)
        {
            foreach ($scripts as $handle => $script) :
                $deps      = isset($script['deps']) ? $script['deps']  : '';
                $ver       = isset($script['ver']) ? $script['ver']    : '';
                $media     = isset($script['media']) ? $script['media'] : '';
                $in_footer = isset($script['in_footer']) ? $script['in_footer'] : '';
                wp_register_style($handle, $script['src'], $deps, $ver, $media);
                if ($media) :
                endif;
                wp_register_script($handle, $script['src'], $deps, $ver, $in_footer);
                wp_enqueue_script($handle);

            endforeach;
        }
        /**
         * Carga los estilos
         *
         * @return Array
         */
        public function hero_styles()
        {
            $styles = [
                'tailwind' => [
                    'src'   => HERO_URL . '/assets/css/tailwind.css',
                    'deps'  => [],
                    'ver'   => '3.1.4',
                    'media' => 'all',
                ],
                'custom' => [
                    'src'   => HERO_URL . '/assets/css/custom.css',
                    'deps'  => [],
                    'ver'   => \filemtime(HERO_PATH . '/assets/css/custom.css'),
                    'media' => 'all',
                ],
            ];

            return $styles;
        }
    }

endif;
