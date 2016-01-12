<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 12/01/2016
 * Time: 09:16
 */

namespace CodeOrders\V1\Rest\Orders;


use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class OrderItemTableGatewayFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $dbAdapter = $serviceLocator->get('DbMySQL');

       $hydrator = new HydratingResultSet(new ClassMethods(), new OrderItemEntity());

       $tableGateway = new TableGateway('order_item', $dbAdapter, null, $hydrator);

       return $tableGateway;
    }
}