<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 14/01/2016
 * Time: 09:12
 */

namespace CodeOrders\V1\Rest\Orders;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OrdersServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $orderRepository = $serviceLocator->get('CodeOrders\V1\Rest\Orders\OrdersRepository');

        return new OrdersServices($orderRepository);
    }
}