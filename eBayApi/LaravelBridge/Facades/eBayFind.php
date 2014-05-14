<?php namespace Gufran\EBay\LaravelBridge\Facades;

use Illuminate\Support\Facades\Facade;

class eBayFind extends Facade {

	protected static function getFacadeAccessor() { return 'ebay.service.find'; }

}
