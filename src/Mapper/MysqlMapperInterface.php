<?php
namespace Pacificnm\Install\Mapper;

interface MysqlMapperInterface
{
    
    /**
     * 
     * @param string $sql
     */
    public function installTabel($sql);
}
