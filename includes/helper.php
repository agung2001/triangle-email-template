<?php

namespace Triangle\Includes;

!defined( 'WPINC ' ) or die;

/**
 * Helper library for Triangle plugins
 *
 * @package    Triangle
 * @subpackage Triangle\Includes
 */

class Helper {

    /**
     * Get files within directory
     * @return  void
     * @var     string  $dir   plugin hooks directory (Api, Controller)
     * @pattern bridge
     */
    public function getDirFiles($dir, &$results = array()) {
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                $this->getDirFiles($path, $results);
            }
        }
        return $results;
    }

}