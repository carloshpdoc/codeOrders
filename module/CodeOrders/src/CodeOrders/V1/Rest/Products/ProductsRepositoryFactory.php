<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 13/12/2015
 * Time: 20:05
 */

namespace CodeOrders\V1\Rest\Products;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\ClassMethods;

class ProductsRepositoryFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('DbAdapter');
        //  $usersMapper = new UsersMapper();
        //  $hydrator = new HydratingResultSet($usersMapper, new UsersEntity());
        $hydrator = new HydratingResultSet(new ClassMethods(), new ProductsEntity());

        $tableGateway = new TableGateway('products', $dbAdapter, null, $hydrator);

     //   $productsRepository = new ProductsRepository($tableGateway);

        $roleTableGateway = $serviceLocator->get('CodeOrders\V1\Rest\Orders\RoleTableGateway');

        return new ProductsRepository($tableGateway, $roleTableGateway);
    }
}