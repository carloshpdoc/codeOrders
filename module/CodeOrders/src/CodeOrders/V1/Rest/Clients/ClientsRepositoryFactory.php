<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 25/01/2016
 * Time: 09:45
 */

namespace CodeOrders\V1\Rest\Clients;


use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class ClientsRepositoryFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('CodeOrders\V1\Rest\Clients\ClientsTableGateway');

        $roleTableGateway = $serviceLocator->get('CodeOrders\V1\Rest\Clients\RoleClientsTableGateway');

        return new ClientsRepository($tableGateway, $roleTableGateway);
    }
}