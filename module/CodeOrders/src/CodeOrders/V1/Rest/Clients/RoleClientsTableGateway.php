<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 25/01/2016
 * Time: 10:22
 */

namespace CodeOrders\V1\Rest\Clients;


class RoleClientsTableGateway
{
    private $repository;

    /**
     * RoleClientsTableGateway constructor.
     * @param $repository
     */
    public function __construct(ClientsRepository $repository)
    {
        $this->repository = $repository;
    }
}