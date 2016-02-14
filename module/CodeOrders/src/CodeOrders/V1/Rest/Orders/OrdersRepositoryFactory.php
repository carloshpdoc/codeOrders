<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 12/01/2016
 * Time: 09:31
 */

namespace CodeOrders\V1\Rest\Orders;


use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class OrdersRepositoryFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $dbAdapter =$serviceLocator ->get('DbAdapter');

       $hydrator = new HydratingResultSet(new ClassMethods, new OrdersEntity());

       $tableGateway = new TableGateway('orders',$dbAdapter, NULL, $hydrator);

       $orderItemTableGateway = $serviceLocator->get('CodeOrders\V1\Rest\Orders\OrderItemTableGateway');

       $userRoleTableGateway = $serviceLocator->get('CodeOrders\V1\Rest\Orders\UserRoleTableGateway');

        $clientsTableGateway = $serviceLocator->get('CodeOrders\V1\Rest\Clients\ClientsTableGateway');

       return new OrdersRepository($tableGateway, $orderItemTableGateway, $userRoleTableGateway, $clientsTableGateway);
    }
}