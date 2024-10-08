<?php

namespace AdminLTE\View;

use \App\View\AppView;
use \Cake\Core\App;
use \Cake\Utility\Inflector;

class AdminLTEView extends AppView
{
    protected function _paths(?string $plugin = NULL, bool $cached = true): array
    {
        $prefix = is_string($this->request->getParam('prefix')) ? Inflector::camelize($this->request->getParam('prefix')) : false;
        $theme = $this->theme;

        $templatePaths = App::path(static::NAME_TEMPLATE);

        $pluginPaths = [];
        $themePaths = [];

        foreach ($templatePaths as $templateCurrent) {
            if (!empty($theme)) {
                if (!empty($plugin)) {
                    for ($i = 0, $count = count($templatePaths); $i < $count; $i++) {
                        if ($prefix) {
                            $pluginPaths[] = $templatePaths[$i] . 'plugin' . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR . 'Plugin' . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . $prefix . DIRECTORY_SEPARATOR;
                        }

                        $pluginPaths[] = $templatePaths[$i] . 'plugin' . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR . 'Plugin' . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR;
                    }
                }

                if ($prefix) {
                    $themePaths[] = $templateCurrent . 'plugin' . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR . $prefix . DIRECTORY_SEPARATOR;
                }

                $themePaths[] = $templateCurrent . 'plugin' . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR;
            }
        }

        $paths = array_merge(
            $pluginPaths,
            $themePaths,
            parent::_paths($plugin, $cached)
        );

        return $this->_paths = $paths;
    }
}
