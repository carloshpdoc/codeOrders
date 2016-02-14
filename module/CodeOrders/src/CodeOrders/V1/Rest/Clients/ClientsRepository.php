<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 25/01/2016
 * Time: 09:44
 */

namespace CodeOrders\V1\Rest\Clients;



use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Paginator\Adapter\DbTableGateway;
use ZF\ApiProblem\ApiProblem;

class ClientsRepository
{
    private $tableGateway;

    private  $roleTableGateway;

    /**
     * ClientsRepository constructor.
     * @param $tableGateway
     */
    public function __construct(AbstractTableGateway $tableGateway, AbstractTableGateway $roleTableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->roleTableGateway = $roleTableGateway;
    }

    public function  findAll()
    {
        $paginatorAdapter = new DbTableGateway($this->tableGateway);

        return new ClientsCollection($paginatorAdapter);
    }

    public function find($id)
    {
        $resultSet = $this->tableGateway->select(['id'=>(int)$id]);

        return $resultSet->current();
    }

    public function findByUsername($username)
    {
        $t = $this->roleTableGateway->select(['username'=>$username])->current();

        return $t->getRole();
    }

    public function createPost($data)
    {
        try {

            $this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();

            $this->tableGateway->insert($data);

            $this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();

            $id = $this->tableGateway->getLastInsertValue();

            return $id;

        } catch (\Exception $e) {
            $this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();

            return 'error';
        }

    }

    public function deleteData($id)
    {
        $result = $this->find($id);
        if(!$result)
        {
            return new ApiProblem(404,'Registro não encontrado');
        }

        $this->tableGateway->delete(['id'=>(int)$id]);
        return true;

    }

    public function updateData($id,$data)
    {
        try {

            $this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();

            $this->tableGateway->update((array)$data, ["id"=>(int)$id]);

            $this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();

            return $this->find($id);
        } catch (\Exception $e) {
            $this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();

            return 'error';
        }
    }
}