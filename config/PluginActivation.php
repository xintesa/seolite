<?php

namespace Seolite\Config;

class PluginActivation
{
    public function beforeActivation()
    {
        return true;
    }

    public function onActivation()
    {
        $CroogoPlugin = new \Croogo\Extensions\CroogoPlugin();
        $result = $CroogoPlugin->migrate('Seolite');
        if ($result) {
            $Setting = \Cake\ORM\TableRegistry::get('Croogo/Settings.Settings');
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
        $Setting = \Cake\ORM\TableRegistry::get('Croogo/Settings.Settings');;
        $Setting->deleteKey('Seolite.installed');
    }
}
