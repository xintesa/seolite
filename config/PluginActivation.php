<?php

namespace Seolite\Config;

use Cake\ORM\TableRegistry;
use Croogo\Core\PluginManager;

class PluginActivation
{
    public function beforeActivation()
    {
        return true;
    }

    public function onActivation()
    {
        $CroogoPlugin = new PluginManager();
        $result = $CroogoPlugin->migrate('Seolite');
        if ($result) {
            $Setting = TableRegistry::get('Croogo/Settings.Settings');
            $Setting->write('Seolite.installed', true);
        }

        return $result;
    }

    public function beforeDeactivation()
    {
        return true;
    }

    public function onDeactivation()
    {
        $Setting = TableRegistry::get('Croogo/Settings.Settings');;
        $Setting->deleteKey('Seolite.installed');
    }
}
