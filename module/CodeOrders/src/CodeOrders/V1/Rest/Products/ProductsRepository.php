<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 13/12/2015
 * Time: 20:09
 */

namespace CodeOrders\V1\Rest\Products;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Paginator\Adapter\DbTableGateway;

class ProductsRepository
{
    private $tableGateway;

    public function __construct(AbstractTableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function  findAll()
    {
        $tableGateway = $this->tableGateway;
        $paginatorAdapter = new DbTableGateway($tableGateway);

        // return$this->tableGateway->select();
        return new ProductsCollection($paginatorAdapter);
    }

    public function find($id)
    {
        $resultSet = $this->tableGateway->select(['id'=>(int)$id]);

        return $resultSet->current();
    }

    public function createData(array $data)
    {
        try {

            $this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();

            $this->tableGateway->insert($data);

            $this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();

            $id = $this->tableGateway->getLastInsertValue();

            return $id;

        } catch (\Exception $e) {
            $this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();

            return 'error';
        }
    }
}