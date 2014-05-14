<?php namespace Gufran\LaravelBridge\Facades;

use Illuminate\Support\Facades\Facade;

class eBayTrade extends Facade {

	protected static function getFacadeAccessor() { return 'ebay.service.trade'; }

}
