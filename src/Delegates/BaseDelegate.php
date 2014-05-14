<?php namespace Gufran\EBay\Delegates;

use DTS\eBaySDK\Services\BaseService;
use DTS\eBaySDK\Types\BaseType;

abstract class BaseDelegate {

	/**
	 * Service object to perform operations with request
	 *
	 * @var \DTS\eBaySDK\Services\BaseService
	 */
	protected $service;

	/**
	 * Request object
	 *
	 * @var \DTS\eBaySDK\Types\BaseType
	 */
	protected $request;

	/**
	 * Method to operate on request
	 *
	 * @var string
	 */
	protected $method;

	/**
	 * @param BaseService $service
	 * @param BaseType    $request
	 * @param string      $method
	 */
	public function __construct(BaseService $service, BaseType $request, $method)
	{
		$this->service = $service;
		$this->request = $request;
		$this->method = $method;
	}

	/**
	 * run the request on service object and return the results
	 *
	 * @return BaseType
	 */
	public function run()
	{
		return $this->service->{$this->method}($this->request);
	}

	/**
	 * Dynamic mutators
	 *
	 * @param $method
	 * @param $arguments
	 *
	 * @return $this
	 */
	public function __call($method, $arguments)
	{
		if(substr($method, 0, 3) === 'set')
		{
			$property = lcfirst(substr($method, 3));
			if(property_exists($this->request, $property))
			{
				$this->request->$property = $arguments[0];
				return $this;
			}
		}

		throw new \BadMethodCallException
		('Method ' . $method . ' not implemented on ' . get_class($this->request));
	}
}