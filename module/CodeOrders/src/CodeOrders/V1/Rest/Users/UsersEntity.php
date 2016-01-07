<?php
namespace CodeOrders\V1\Rest\Users;

use Zend\Stdlib\Hydrator\HydratorInterface;

class UsersEntity //implements HydratorInterface
{
    protected $id;
    protected $username;
    protected $password;
    protected $first_name;
    protected $last_name;
    protected $role;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return UsersEntity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return UsersEntity
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return UsersEntity
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return UsersEntity
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return UsersEntity
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     * @return UsersEntity
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

/*
    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
  /*  public function extract($object)
    {
        return[
            'id'=> $this->id,
            'username'=>$this->username,
            'password'=>$this->password,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name
        ];
    }*/

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
   /* public function hydrate(array $data, $object)
    {
        $object->id = $data['id'];
        $object->username =$data['username'];
        $object->password = $data['password'];
        $object->first_name = $data['first_name'];
        $object->last_name = $data['last_name'];
        return $object;
    }*/
}
