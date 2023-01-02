<?php

declare(strict_types=1);

namespace Themes\Two\View\Composers;

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class ThemeComposer {
    /**
     * Demo name.
     */
    public static string $demo = 'demo-111';
    /**
     * Theme execution mode(dev, preview, export, release).
     */
    public static string $viewMode = 'dev';

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view) {
        $view->with('_theme', $this);
    }

    /**
     * Get the route or URL.
     *
     * @return string
     */
    public static function getPageUrl(string $path, string $demo = '', string $mode = null) {
        $params = [];
        if (isset($_REQUEST['rtl']) && $_REQUEST['rtl']) {
            $params['rtl'] = 1;
        }
        if (isset($_REQUEST['demo']) && $_REQUEST['demo']) {
            $params['demo'] = $_REQUEST['demo'];
        }

        if (null !== $mode) {
            if ($mode) {
                $params['mode'] = $mode;
            }
        } elseif (isset($_REQUEST['mode']) && $_REQUEST['mode']) {
            $params['mode'] = $_REQUEST['mode'];
        }

        if (! empty($demo)) {
            $params['demo'] = $demo;
        }

        $a = '';
        if (count($params) && '#' !== $path) {
            $a = '?'.http_build_query($params);
        }

        // check if the route exist in the laravel
        $name = str_replace('/', '.', $path);
        if (Route::has($name)) {
            return route($name).$a;
        }

        // otherwise return as url
        return url($path).$a;
    }

    /**
     * Get media path.
     *
     * @return string
     */
    public static function getMediaUrlPath(string $file = '') {
        return '/media/'.$file;
    }

    /**
     * Get the option's value from config.
     *
     * @param string|bool   $path
     * @param callable|null $default
     *
     * @return mixed|string
     */
    public static function getOption(string $scope, $path = false, $default = null) {
        $demo = self::getDemo() ?? 'demo1';

        // Map the config path
        if (array_key_exists($scope, config($demo.'.general', []))) {
            $scope = 'general.'.$scope;
        }

        if (in_array($scope, ['page', 'pages'])) {
            $scope = 'pages';
            $segments = request()->segments();
            foreach ($segments as $key => $value) {
                if (is_numeric($value)) {
                    $segments[$key] = '*';
                }
            }
            $scope .= '.'.implode('.', $segments);
        }

        // Get current page path
        $deepPath = '';
        if (\is_string($path)) {
            $deepPath = '.'.str_replace('/', '.', $path);
        }

        // Demo config
        $demoConfig = config($demo.'.'.$scope.$deepPath, $default);

        // check if it is a callback
        if (is_callable($demoConfig) && ! is_string($demoConfig)) {
            $demoConfig = $demoConfig();
        }

        return $demoConfig;
    }

    /**
     * Get current demo.
     *
     * @return string
     */
    public static function getDemo() {
        if (class_exists('request')) {
            return request()->input('demo', self::$demo);
        }

        return self::$demo;
    }

    public static function printHtmlAttributes($scope) {
        $Attributes = [];

        if (isset(self::$htmlAttributes[$scope]) && ! empty(self::$htmlAttributes[$scope])) {
            echo Util::getHtmlAttributes(self::$htmlAttributes[$scope]);
        }

        echo '';
    }

    public static function printHtmlClasses($scope, $full = true) {
        if (isset(self::$htmlClasses[$scope]) && ! empty(self::$htmlClasses[$scope])) {
            $classes = implode(' ', self::$htmlClasses[$scope]);

            if ($full) {
                echo Util::getHtmlClass(self::$htmlClasses[$scope]);
            } else {
                echo Util::getHtmlClass(self::$htmlClasses[$scope], false);
            }
        } else {
            echo '';
        }
    }

    public static function printCssVariables($scope) {
        $Attributes = [];

        if (isset(self::$cssVariables[$scope]) && ! empty(self::$cssVariables[$scope])) {
            echo Util::getCssVariables(self::$cssVariables[$scope]);
        }
    }

    public static function appendVersionToUrl($path) {
        // only at preview version
        if ('preview' == self::$viewMode) {
            $path .= '?v='.self::getOption('theme/version');
        }

        return $path;
    }

    /**
     * Print fonts in the HTML head.
     *
     * @param string $value
     */
    public static function includeFonts($value = '') {
        if (self::hasOption('assets', 'fonts/google')) {
            $fonts = self::getOption('assets', 'fonts/google');

            echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family='.implode('|', $fonts).'"/>';
        }
    }

    /**
     * Check if the option has a value.
     *
     * @param false $path
     *
     * @return bool
     */
    public static function hasOption($scope, $path = false) {
        return (bool) self::getOption($scope, $path);
    }

    /**
     * Summary of hasVendorFiles.
     *
     * @param mixed $type
     *
     * @return bool
     */
    public static function hasVendorFiles($type) {
        return (bool) self::getVendorFiles($type);
    }

    public static function getVendorFiles($type) {
        $files = [];
        $vendors = self::getOption('vendors');

        $globalVendors = self::getOption('assets', 'vendors');
        $pageVendors = self::getOption('page', 'assets/vendors');

        if ($globalVendors && count($globalVendors) > 0) {
            foreach ($globalVendors as $name) {
                if (isset($vendors[$name]) && is_array($vendors[$name]) && isset($vendors[$name][$type])) {
                    foreach ($vendors[$name][$type] as $each) {
                        $files[] = $each;
                    }
                }
            }
        }

        if ($pageVendors && count($pageVendors) > 0) {
            foreach ($pageVendors as $name) {
                if (isset($vendors[$name]) && is_array($vendors[$name]) && isset($vendors[$name][$type])) {
                    foreach ($vendors[$name][$type] as $each) {
                        $files[] = $each;
                    }
                }
            }
        }

        return array_unique($files);
    }

    /**
     * Summary of getViewMode.
     *
     * @return string
     */
    public static function getViewMode() {
        return self::$viewMode;
    }
}
