<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 23/01/2016
 * Time: 19:06
 */

namespace CodeOrders\V1\Rest\Orders;



class UserRoleTableGateway
{
    private $repository;

    /**
     * UserRoleTableGateway constructor.
     * @param $getRole
     */
    public function __construct(OrdersRepository $repository)
    {
        $this->repository = $repository;
    }

    /*public function findByUsername($username)
    {
        return $this->UserRoleTableGateway->select(['username'=>$username])->current();
    }*/
}