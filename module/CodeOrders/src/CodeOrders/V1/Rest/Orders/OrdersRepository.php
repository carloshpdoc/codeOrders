<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 12/01/2016
 * Time: 09:25
 */

namespace CodeOrders\V1\Rest\Orders;


use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\ObjectProperty;

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
    /**
     * @var AbstractTableGateway
     */
    private $UserRoleTableGateway;

    public function __construct(AbstractTableGateway $tableGateway, AbstractTableGateway $orderItemTableGateway, AbstractTableGateway $UserRoleTableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->orderItemTableGateway = $orderItemTableGateway;
        $this->UserRoleTableGateway = $UserRoleTableGateway;
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
                $order->addItems($item);
            }

            $data = $hydrator->extract($order);
            $res[] = $data;
        }

        $arrayAdapter = new ArrayAdapter($res);
        $ordersCollection = new OrdersCollection($arrayAdapter);

        return $ordersCollection;

    }

    public function insert( array $data)
    {
        $this->tableGateway->insert($data);
        $id= $this->tableGateway->getLastInsertValue();

        return $id;
    }

    public function insertItem(array $data)
    {
        $this->orderItemTableGateway->insert($data);

        return $this->orderItemTableGateway->getLastInsertValue();
    }

    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    public function findByUsername($username)
    {
        $user = $this->UserRoleTableGateway->select(['username'=>$username])->current();

        return $user->getRole();
    }

   /* public function findById($username)
    {*/
    /*    $user = $this->UserRoleTableGateway->select(['username'=>$username])->current();

        return $user->getId();*/
    //}

    public function find($id, $name)
    {
        $hydrator = new ClassMethods();
        $hydrator->addStrategy('items', new OrderItemHydratorStrategy(new ClassMethods()));

        $resultSet = $this->tableGateway->select(['id'=>$id])->current();
        $res=[];

            $items = $this->orderItemTableGateway->select(['order_id'=>$resultSet->getId()]);

            foreach($items as $item){
                $resultSet->addItems($item);
            }

            $data = $hydrator->extract($resultSet);
            $res[] = $data;

        $arrayAdapter = new ArrayAdapter($res);
        $ordersCollection = new OrdersCollection($arrayAdapter);

        $user = $this->UserRoleTableGateway->select(['username'=>$name])->current();

        $id = $user->getId();

        $idUser = $resultSet->getUserId();

        if($id==$idUser){
            return $ordersCollection;
        }else{
            return false;
        }
    }

    public function deleteData($id)
    {
       /* $result = $this->find($id);
        if(!$result)
        {
            return new ApiProblem(404,'Registro não encontrado');
        }*/

        $this->tableGateway->delete(['id'=>(int)$id]);
        return true;

    }
}