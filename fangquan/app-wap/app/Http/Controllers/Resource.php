<?php namespace App\Wap\Http\Controllers;

class Resource
{
    private static $js = array();
    private static $css = array();

    private static $client_type = 'browser';
    private static $touch_types = array('wechat', 'mobile', 'browser');
    private static $extra_resources = array(
        'js'  => array(),
        'css' => array(),
    );

    private static $params = array();
    private static $manifest;

    public static function addJS($data = array(), $client_type = '')
    {
        if (!empty($data)) {
            if ($client_type) {
                self::$extra_resources['js'][$client_type] = isset(self::$extra_resources['js'][$client_type]) ? self::$extra_resources['js'][$client_type] : array();
                foreach ($data as &$val) {
                    $val .= '.' . $client_type;
                }
                self::$extra_resources['js'][$client_type] = array_unique(array_merge((self::$extra_resources['js'][$client_type]), $data), SORT_REGULAR);
            } else {
                self::$js = array_unique(array_merge(self::$js, $data), SORT_REGULAR);
            }
        }
    }

    public static function addCSS($data = array(), $client_type = '')
    {
        if (!empty($data)) {
            if ($client_type) {
                self::$extra_resources['css'][$client_type] = isset(self::$extra_resources['css'][$client_type]) ? self::$extra_resources['css'][$client_type] : array();
                foreach ($data as &$val) {
                    $val .= '.' . $client_type;
                }
                self::$extra_resources['css'][$client_type] = array_unique(array_merge((self::$extra_resources['css'][$client_type]), $data), SORT_REGULAR);
            } else {
                self::$css = array_unique(array_merge(self::$css, $data), SORT_REGULAR);
            }
        }
    }

    public static function addParam($value, $key = '')
    {
        if ($key) {
            $param = isset(self::$params[$key]) ? self::$params[$key] : array();
            self::$params[$key] = array_merge($param, $value);
        } else {
            $params = array_merge(self::$params, $value);
            self::$params = $params;
        }
    }

    public static function getParam($key)
    {
        return isset(self::$params[$key]) ? self::$params[$key] : array();
    }

    public static function getAllParams()
    {
        return self::$params;
    }

    /**
     * @param $resource_type string. js/css
     * @return array
     */
    public static function getExtraResources($resource_type, $client_type)
    {
        return isset(self::$extra_resources[$resource_type][$client_type]) ? self::$extra_resources[$resource_type][$client_type] : array();
    }

    /**
     * Get JS files and extra resources if necessary.
     *  Default just JS files,
     *  if specified {{$client_type}}, then also get extra {{$client_type}} resources.
     * @param string $client_type
     * @return string
     */
    public static function getJS($client_type = '')
    {
        $touch_patches = (in_array($client_type, self::$touch_types)) ? self::getExtraResources('js', 'touch') : array();
        $resources = array_unique(array_merge(self::$js, self::getExtraResources('js', $client_type), $touch_patches), SORT_REGULAR);

        $import_js = '[';
        $len = count($resources) - 1;
        foreach ($resources as $i => $js) {
            $import_js .= "'" . $js . "'" . (($i < $len) ? ', ' : '');
        }
        $import_js .= ']';

        return $import_js;
    }

    /**
     * Get CSS files and extra resources if necessary.
     *  Default just CSS files,
     *  if specified {{$client_type}}, then also get extra {{$client_type}} resources.
     * @param string $client_type
     * @return string
     */
    public static function getCSS($client_type = '', $file_css = '')
    {
        $touch_patches = (in_array($client_type, self::$touch_types)) ? self::getExtraResources('css', 'touch') : array();
        $resources = array_unique(array_merge(self::$css, self::getExtraResources('css', $client_type), $touch_patches), SORT_REGULAR);
        $import_css = "";
        $resources = array_reverse($resources);
        foreach ($resources as $css) {
            if (!empty($file_css)) {
                $count = substr_count($file_css, '.');
                for ($i = 0; $i < $count; $i++) {
                    $css = '../' . $css;
                }
            }
            $import_css .= "@import url('" . $css . ".css');" . "\n";
        }
        return $import_css;
    }

    public static function getSuffix($resource_type, $client_type = 'browser')
    {
        return (!empty(self::$extra_resources[$resource_type][$client_type])) ? ('.' . $client_type) : '';
    }

    public static function autoGenerate($file_js, $file_css, $client_type = '')
    {

        self::$client_type = $client_type;
        $old_file_css = $file_css;

        if ($file_js) {
            $suffix = self::getSuffix('js', $client_type);
            $file_js = implode('/', explode('.', $file_js));
            $file_js = public_path() . "/www/" . $file_js . $suffix . '.js';
            $js_content = self::_autoGenerateJsContent();

            self::fileForceContents($file_js, $js_content);
        }

        if ($file_css) {
            $suffix = self::getSuffix('css', $client_type);
            $file_css = implode('/', explode('.', $file_css));
            $file_css = public_path() . "/www/" . $file_css . $suffix . '.css';
            $css_content = self::_autoGenerateCssContent($old_file_css);
            self::fileForceContents($file_css, $css_content);
        }
    }

    private static function _autoGenerateJsContent()
    {
        $content = "//This code is generated by PHP.\n";
        $content .= "//Load common code that includes config, then load the app logic for this page.\n";
        $content .= "require(" . self::getJS(self::$client_type) . ", function () {\n";
        $content .= "});";

        return $content;
    }

    private static function _autoGenerateCssContent($file_css = '')
    {
        $content = "/* This code is generated by PHP. */\n";
        $content .= self::getCSS(self::$client_type, $file_css);
        return $content;
    }

    public static function fileForceContents($dir, $contents)
    {
        $parts = explode('/', $dir);
        $file = array_pop($parts);
        $dir = '';
        foreach ($parts as $part) {
            if (!is_dir($dir .= "/$part")) {
                mkdir($dir);
            }
        }
        file_put_contents("$dir/$file", $contents);
    }

    public function getManifest()
    {
        $file = @file_get_contents(public_path($this->dest_dir . 'mix-manifest.json'));
        return json_decode($file, true);
    }

    public static function getFilePath($file_name)
    {
        $real_file = implode('/', explode('.', $file_name));
        if (getenv('APP_ENV') == 'production') {
            $file = @file_get_contents(public_path('tools/build.json'));
            $data = json_decode($file, true);
            if (!isset(self::$manifest)) {
                if (!empty($data) && !empty($data['manifest'])) {
                    foreach ($data['manifest'] as $items) {
                        foreach ($items as $key => $value) {
                            self::$manifest[$key] = $value;
                        }
                    }
                } else {
                    self::$manifest = [];
                }
            }
            if (isset(self::$manifest[$file_name])) {
                $real_file = self::$manifest[$file_name];
            }
        }
        return $real_file;
    }

}
