<?php
namespace Pacificnm\Install\Mapper\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Install\Mapper\MysqlMapper;

class MysqlMapperFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Pacificnm\Install\Mapper\MysqlMapper
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $readAdapter = $serviceLocator->get('db2');
        
        $writeAdapter = $serviceLocator->get('db1');
        
        return new MysqlMapper($readAdapter, $writeAdapter);
    }
}
