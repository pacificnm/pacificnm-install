<?php
namespace Install\Mapper\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Install\Mapper\MysqlMapper;

class MysqlMapperFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Install\Mapper\MysqlMapper
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $readAdapter = $serviceLocator->get('db2');
        
        $writeAdapter = $serviceLocator->get('db1');
        
        return new MysqlMapper($readAdapter, $writeAdapter);
    }
}
