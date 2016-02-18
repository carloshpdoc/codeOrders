<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 28/11/2015
 * Time: 21:59
 */

namespace CodeOrders\V1\Rest\Users;

//use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbTableGateway;
use ZF\ApiProblem\ApiProblem;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;


class UsersRepository
{

    /**
     * @var TableGateway
     */
    private $tableGateway;
    /**
     * @var AuthenticatedIdentity
     */
    private $auth;

    public function __construct(TableGateway $tableGateway, AuthenticatedIdentity $auth)
    {
        $this->tableGateway = $tableGateway;
        $this->auth = $auth;
    }

    public function  findAll()
    {
        $tableGateway = $this->tableGateway;
        $paginatorAdapter = new DbTableGateway($tableGateway);

       // return$this->tableGateway->select();
        return new UsersCollection($paginatorAdapter);
    }

    public function find($id)
    {
     $resultSet = $this->tableGateway->select(['id'=>(int)$id]);

      return $resultSet->current();
    }
	
	public function findByUsername($username)
    {
		return $this->tableGateway->select(['username'=>$username])->current();
    }

    /*public function findById($username)
    {
      $user = $this->tableGateway->select(['username'=>$username])->current();

      return $user->getId();
    }*/

    public function createPost($data)
    {
        $this->tableGateway->insert((array)$data);
        $id = $this->tableGateway->lastInsertValue;
        return $this->find($id);

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
        $this->tableGateway->update((array)$data, ["id"=>(int)$id]);
        return $this->find($id);
    }

    public function getAuthenticated()
    {
        $username =$this->auth->getAuthenticationIdentity()['user_id'];
        return $this->findByUsername($username);

    }

}