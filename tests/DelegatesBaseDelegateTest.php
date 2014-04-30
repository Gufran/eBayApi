<?php

class DelegatesBaseDelegateTest {

	/**
	 * @var Gufran\EBay\Delegates\BaseDelegate
	 */
	protected $delegate;

	/**
	 * @var Mockery\MockInterface
	 */
	protected $type;

	/**
	 * @var Mockery\MockInterface
	 */
	protected $service;

	/**
	 * @var string
	 */
	protected $method;

	public function setUp()
	{
		$this->service = Mockery::mock('DTS\eBaySDK\Services\BaseService');
		$this->type = Mockery::mock('DTS\eBaySDK\Types\BaseType');
		$this->method = 'getEbayTime';

		$this->delegate = new \Gufran\EBay\Delegates\FindServiceDelegate($this->service, $this->type, $$this->method);
	}

	/** @test */
	public function it_can_invoke_service_object()
	{
		$this->service->shouldReceive($this->method)->once()->with($this->type);
		$this->delegate->run();
	}
} 