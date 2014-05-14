<?php namespace Gufran\EBay\API;

use Gufran\EBay\Service;

abstract class ApiService {

	/**
	 * binding container and resolver
	 *
	 * @var array
	 */
	protected static $resolver;

	/**
	 * mapping service type to object instance
	 *
	 * @var array
	 */
	protected $objectMap = array(
		'shopping' => 'eBayShop',
	    'trading' => 'eBayTrade',
	    'finding' => 'eBayFind'
	);

	/**
	 * set object resolver on class
	 *
	 * @param array $resolver
	 */
	public static function setObjectResolver(array $resolver)
	{
		self::$resolver = $resolver;
	}

	/**
	 * Get delegate instance form service
	 *
	 * @param $method
	 * @param $arguments
	 *
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		$serviceType = $this->getServiceType();
		$serviceObject = $this->getServiceObject($serviceType);
		$service = new Service($serviceObject);

		return $service->{$serviceType}($method);
	}

	/**
	 * Get service object for service type
	 *
	 * @param $serviceType
	 *
	 * @return \DTS\eBaySDK\Services\BaseService
	 */
	private function getServiceObject($serviceType)
	{
		if( ! in_array($serviceType, array_keys($this->objectMap)))
			throw new \InvalidArgumentException('Unknown service request [' . $serviceType . ']');

		$accessor = $this->objectMap[$serviceType];

		if( ! array_key_exists($accessor, self::$resolver))
			throw new \InvalidArgumentException('Cant resolve service request [' . $serviceType . '] by [' . $accessor . ']');

		return call_user_func(self::$resolver[$accessor]);
	}

	/**
	 * Get the type of service
	 * Valid return values are shopping, trading and finding
	 *
	 * @return string
	 */
	abstract protected function getServiceType();
} 