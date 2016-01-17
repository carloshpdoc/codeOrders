<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 14/01/2016
 * Time: 09:11
 */

namespace CodeOrders\V1\Rest\Orders;


use Zend\Stdlib\Hydrator\ObjectProperty;

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
        $hydrator = new ObjectProperty();
        $data = $hydrator->extract($data);

        $orderData = $data;
        unset($orderData['item']);
        $items = $data['item'];

        $tableGateway = $this->repository->getTableGateway();

        try{

            $tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();

            $orderId =$this->repository->insert($orderData);

            foreach($items as $item)
            {
                $item['order_id'] = $orderId;

                $this->repository->insertItem($item);
            }

            $tableGateway->getAdapter()->getDriver()->getConnection()->commit();

            return ['order_id'=>$orderId];

        }catch (\Exception $e){
            $tableGateway->getAdapter()->getDriver()->getConnection()->rollback();

            return 'error';
        }


    }
}