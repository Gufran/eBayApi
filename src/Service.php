<?php namespace Gufran\EBay;

use DTS\eBaySDK\Services\BaseService;
use Gufran\EBay\Delegates\FindServiceDelegate;
use Gufran\EBay\Delegates\ShopServiceDelegate;
use Gufran\EBay\Delegates\TradeServiceDelegate;

class Service {

	/**
	 * @var BaseService;
	 */
	protected $service;

	/**
	 * @var string
	 */
	protected $findingApiNamespace = "\\DTS\\eBaySDK\\Finding\\Types\\";

	/**
	 * @var string
	 */
	protected $tradingApiNamespace = "\\DTS\\eBaySDK\\Trading\\Types\\";

	/**
	 * @var string
	 */
	protected $shoppingApiNamespace = "\\DTS\\eBaySDK\\Shopping\\Types\\";

	/**
	 * @var string
	 */
	protected $findingRequestAppend = 'Request';

	/**
	 * @var string
	 */
	protected $shoppingRequestAppend = 'RequestType';

	/**
	 * @var string
	 */
	protected $tradingRequestAppend = 'RequestType';

	/**
	 * @param BaseService $service
	 */
	public function __construct(BaseService $service)
	{
		$this->service = $service;
	}

	/**
	 * Prepare Finding api delegate object
	 *
	 * @param $method
	 *
	 * @return \Gufran\EBay\Delegates\FindServiceDelegate
	 */
	public function finding($method)
	{
		$request = $this->createRequestObject('finding', $method);
		return new FindServiceDelegate($this->service, $request, $method);
	}

	/**
	 * Prepare trading service delegate object
	 *
	 * @param $method
	 *
	 * @return TradeServiceDelegate
	 */
	public function trading($method)
	{
		$request = $this->createRequestObject('trading', $method);
		return new TradeServiceDelegate($this->service, $request, $method);
	}

	/**
	 * Prepare shopping service delegate object
	 *
	 * @param $method
	 *
	 * @return ShopServiceDelegate
	 */
	public function shopping($method)
	{
		$request = $this->createRequestObject('shopping', $method);
		return new ShopServiceDelegate($this->service, $request, $method);
	}

	/**
	 * @param $type
	 * @param $method
	 *
	 * @return \DTS\eBaySDK\Types\BaseType
	 */
	private function createRequestObject($type, $method)
	{
		$namespace = $type . 'ApiNamespace';
		$serviceAppend = $type . 'RequestAppend';

		if( ! property_exists($this, $namespace))
			throw new \InvalidArgumentException('Invalid Class Namespace [' . $namespace . ']');

		$className = $this->$namespace . $method . $this->$serviceAppend;

		if( ! class_exists($className))
			throw new \InvalidArgumentException('Class [' . $className . '] does not exists');

		return new $className();
	}
} 