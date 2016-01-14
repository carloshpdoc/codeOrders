<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 14/01/2016
 * Time: 09:11
 */

namespace CodeOrders\V1\Rest\Orders;


class OrdersServices
{
    /**
     * @var OrdersRepository
     */
    private $repository;

    public function __construct(OrdersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function insert($data)
    {
        $order =$this->repository->insert($data);
        return $order;
    }
}