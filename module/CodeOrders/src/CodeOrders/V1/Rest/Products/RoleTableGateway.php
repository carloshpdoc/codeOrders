<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 23/01/2016
 * Time: 23:53
 */

namespace CodeOrders\V1\Rest\Products;


class RoleTableGateway
{
    private $repository;

    public function __construct(ProductsRepository $repository)
    {

        $this->repository = $repository;
    }

}