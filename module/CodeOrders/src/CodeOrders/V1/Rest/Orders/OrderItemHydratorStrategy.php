<?php
/**
 * Created by PhpStorm.
 * User: VBCN
 * Date: 14/01/2016
 * Time: 08:56
 */

namespace CodeOrders\V1\Rest\Orders;



use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class OrderItemHydratorStrategy implements StrategyInterface
{
	public function __construct(ClassMethods $hydrator)
	{
		$this ->hydrator=$hydrator;
	}
	
	 public function extract($items)
	 {
	 	foreach ($items as $item)
	 	{
	 		$data[]= $this->hydrator->extract($item);
	 		
	 		return $data;
	 	}
	 }	
	 
	 public function hydrate($value)
	 {
			throw new \RuntimeException('Hydration is not supported');	 	
	 }
}