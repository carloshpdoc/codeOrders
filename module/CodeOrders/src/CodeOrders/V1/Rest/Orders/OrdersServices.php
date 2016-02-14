<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 14/01/2016
 * Time: 09:11
 */

namespace CodeOrders\V1\Rest\Orders;


use CodeOrders\V1\Rest\Products\ProductsRepository;
use CodeOrders\V1\Rest\Users\UsersRepository;
use Zend\Stdlib\Hydrator\ObjectProperty;

class OrdersServices
{
    /**
     * @var OrdersRepository
     */
    private $repository;
    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    public function __construct(OrdersRepository $repository, UsersRepository $usersRepository, ProductsRepository $productsRepository)
    {
        $this->repository = $repository;
        $this->usersRepository = $usersRepository;
        $this->productsRepository = $productsRepository;
    }

    public function insert($data)
    {
        $hydrator = new ObjectProperty();
        $data->user_id = $this->usersRepository->getAuthenticated()->getId();
        $data->created_at = (new \DateTime())->format('Y-m-d');
        $data->total =0;
        $items = $data->item;
        unset($data->item);

        $orderData = $hydrator->extract($data);
        $tableGateway = $this->repository->getTableGateway();

        try{

            $tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();
            $orderId = $this->repository->insert($orderData);

            $total = 0;
            foreach($items as $key=>$item)
            {
                $product = $this->productsRepository->find($item['product_id']);
                $item['order_id'] = $orderId;
                $item['price'] = $product->price;
                $item['total'] = $items[$key]['total'] = $item['quantity'] * $item['price'];
                $total +=$item['total'];

                $this->repository->insertItem($item);
            }

            $this->repository->updateOrder(['total'=>$total], $orderId);

            $tableGateway->getAdapter()->getDriver()->getConnection()->commit();

            return ['order_id'=>$orderId];

        }catch (\Exception $e){
            $tableGateway->getAdapter()->getDriver()->getConnection()->rollback();

            return 'error';
        }


    }
}