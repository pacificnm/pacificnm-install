<?php
namespace Install\Mapper;

interface MysqlMapperInterface
{
    
    /**
     * 
     * @param string $sql
     */
    public function installTabel($sql);
}
