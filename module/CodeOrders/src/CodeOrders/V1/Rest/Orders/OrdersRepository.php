<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 12/01/2016
 * Time: 09:25
 */

namespace CodeOrders\V1\Rest\Orders;


use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Stdlib\Hydrator\ClassMethods;

class OrdersRepository
{
    /**
     * @var AbstractTableGateway
     */
    private $tableGateway;
    /**
     * @var AbstractTableGateway
     */
    private $orderItemTableGateway;

    public function __construct(AbstractTableGateway $tableGateway, AbstractTableGateway $orderItemTableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->orderItemTableGateway = $orderItemTableGateway;
    }

    public function  findAll()
    {
        $hydrator = new ClassMethods();
        $hydrator->addStrategy('items', new OrderItemHydratorStrategy(new ClassMethods()));

        $orders= $this->tableGateway->select();
        $res=[];

        foreach($orders as $order){
            $items = $this->orderItemTableGateway->select(['order_id'=>$order->getId()]);

            foreach($items as $item){
                $order->addItem($item);
            }

            $data = $hydrator->extract($order);
            $res[] = $data;
        }


        return $res;

    }
};