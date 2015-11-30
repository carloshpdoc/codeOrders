<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 28/11/2015
 * Time: 21:59
 */

namespace CodeOrders\V1\Rest\Users;


use Zend\Db\TableGateway\TableGatewayInterface;

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
        return$this->tableGateway->select();
    }
}