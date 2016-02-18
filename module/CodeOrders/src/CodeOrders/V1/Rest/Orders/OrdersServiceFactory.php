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
        $usersRepository = $serviceLocator->get('CodeOrders\V1\Rest\Users\UsersRepository');
        $productsRepository = $serviceLocator->get('CodeOrders\V1\Rest\Products\ProductsRepository');

        return new OrdersServices($orderRepository, $usersRepository, $productsRepository);
    }
}