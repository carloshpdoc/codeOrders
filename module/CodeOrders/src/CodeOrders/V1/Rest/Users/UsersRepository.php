<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 28/11/2015
 * Time: 21:59
 */

namespace CodeOrders\V1\Rest\Users;

use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbTableGateway;


class UsersRepository
{

    /**
     * @var TableGatewayInterface
     */
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function  findAll()
    {
        $tableGateway = $this->tableGateway;
        $paginatorAdapter = new DbTableGateway($tableGateway);

       // return$this->tableGateway->select();
        return new UsersCollection($paginatorAdapter);
    }

    public function find($id)
    {
     $resultSet = $this->tableGateway->select(['id'=>(int)$id]);

      return $resultSet->current();
    }


    public function createPost($data)
    {
        $this->tableGateway->insert((array)$data);
       // $id = $this->tableGateway->lastInsertValue;
       // return $this->fetch($id);

    }

}