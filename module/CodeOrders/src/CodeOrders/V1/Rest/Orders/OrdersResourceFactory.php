<?php
namespace CodeOrders\V1\Rest\Orders;

class OrdersResourceFactory
{
    public function __invoke($services)
    {
        $ordersRepository = $services->get('CodeOrders\V1\Rest\Orders\OrdersRepository');
        $ordersServices = $services->get('CodeOrders\V1\Rest\Orders\OrdersServices');
        return new OrdersResource($ordersRepository, $ordersServices);
    }
}
