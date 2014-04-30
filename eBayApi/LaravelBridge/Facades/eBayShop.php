<?php namespace Gufran\LaravelBridge\Facades;

use Illuminate\Support\Facades\Facade;

class eBayShop extends Facade {

	protected function getFacadeAccessor() { return 'ebay.service.shop'; }
	
} 