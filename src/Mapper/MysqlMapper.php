<?php
namespace Pacificnm\Install\Mapper;

use Zend\Db\Adapter\AdapterInterface;

class MysqlMapper implements MysqlMapperInterface
{

    /**
     *
     * @var AdapterInterface
     */
    protected $readAdapter;

    /**
     *
     * @var AdapterInterface
     */
    protected $writeAdapter;

    public function __construct(AdapterInterface $readAdapter, AdapterInterface $writeAdapter)
    {
        $this->readAdapter = $readAdapter;
        
        $this->writeAdapter = $writeAdapter;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Pacificnm\Install\Mapper\InstallMapperInterface::installTabel()
     */
    public function installTabel($sql)
    {
        $resultSet = $this->writeAdapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
    }
}
