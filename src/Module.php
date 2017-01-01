<?php
namespace Pacificnm\Install;

use Zend\Console\Adapter\AdapterInterface as Console;

class Module
{
    /**
     *
     * @param Console $console
     * @return string[]|string[][]
     */
    public function getConsoleUsage(Console $console)
    {
        return array(
            'install' => 'installs base application',
        );
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/../config/pacificnm.install.global.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/'
                ),
            ),
        );
    }
}
