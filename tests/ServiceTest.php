<?php

use Gufran\EBay\Service;

class ServiceTest extends PHPUnit_Framework_TestCase {

	protected $baseService;

	/**
	 * @var Service
	 */
	protected $service;

	public function setUp()
	{
		parent::setUp();
		$this->baseService = Mockery::mock('DTS\eBaySDK\Services\BaseService');
		$this->service = new Service($this->baseService);
	}

	/** @test */
	public function finding_returns_finding_service_delegate()
	{
		$delegate = $this->service->finding('findItemsByKeywords');
		$this->assertInstanceOf('Gufran\EBay\Delegates\FindServiceDelegate', $delegate);
	}

	/** @test */
	public function trading_returns_trading_service_delegate()
	{
		$delegate = $this->service->trading('geteBayOfficialTime');
		$this->assertInstanceOf('Gufran\EBay\Delegates\TradeServiceDelegate', $delegate);
	}

	/** @test */
	public function shopping_returns_shopping_service_delegate()
	{
		$delegate = $this->service->shopping('GeteBayTime');
		$this->assertInstanceOf('Gufran\EBay\Delegates\ShopServiceDelegate', $delegate);
	}
} 