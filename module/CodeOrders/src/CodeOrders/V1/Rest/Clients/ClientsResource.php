<?php
namespace CodeOrders\V1\Rest\Clients;

use Zend\Stdlib\Hydrator\ObjectProperty;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class ClientsResource extends AbstractResourceListener
{
    private $repository;

    /**
     * ClientsResource constructor.
     * @param $repository
     */
    public function __construct(ClientsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $userRole = $this->repository->findByUsername($this->getIdentity()->getRoleId());

        if($userRole!="admin")
        {
            return new ApiProblem(403, 'You are not an admin. Your are an :'.$userRole);
        }

        $hydrator = new ObjectProperty();
        $data = $hydrator->extract($data);

        $result = $this->repository->createPost($data);

        if($result=="error"){
            return new ApiProblem(500, 'Error processing insert Products');
        }

        return $result;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $userRole = $this->repository->findByUsername($this->getIdentity()->getRoleId());

        if($userRole!="admin")
        {
            return new ApiProblem(403, 'You are not an admin. Your are an :'.$userRole);
        }

        return $this ->repository->deleteData($id);
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        return $this->repository->findAll();
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        $userRole = $this->repository->findByUsername($this->getIdentity()->getRoleId());

        if($userRole!="admin")
        {
            return new ApiProblem(403, 'You are not an admin. Your are an :'.$userRole);
        }

        $result =  $this->repository->updateData($id, $data);

        if($result=="error"){
            return new ApiProblem(500, 'Error updating products');
        }

        return $result;
    }
}
