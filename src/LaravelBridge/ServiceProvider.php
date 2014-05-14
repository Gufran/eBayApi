<?php namespace Gufran\EBay\LaravelBridge;

use DTS\eBaySDK\Finding\Services\FindingService;
use DTS\eBaySDK\HttpClient\HttpClient;
use DTS\eBaySDK\Shopping\Services\ShoppingService;
use DTS\eBaySDK\Trading\Services\TradingService;
use Gufran\EBay\API\ApiService;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider {

	public function register()
	{
		$objectMap = array();
		$app = $this->app;

		$objectMap['eBayFind'] = function() use ($app)
		{
			$appId = $app['config']->get('ebayApi::app_id');
			$countryCode = strtoupper($app['config']->get('ebayApi::global_id'));
			$globalId = constant("DTS\\eBaySDK\\Constants\\GlobalIds::$countryCode");

			return new FindingService(new HttpClient(), compact('appId', 'globalId'));
		};

		$objectMap['eBayShop'] = function() use($app)
		{
			$apiVersion = $app['config']->get('api_version', 849);
			$countryCode = $app['config']->get('ebayApi::global_id');
			$siteId = constant("DTS\\eBaySDK\\Constants\\SiteIds::$countryCode");
			$appId = $app['config']->get('ebayApi::application_id');

			return new ShoppingService(new HttpClient(), compact('apiVersion', 'siteId', 'appId'));
		};

		$objectMap['eBayTrade'] = function() use($app)
		{
			$apiVersion = $app['config']->get('ebayApi::api_version', 859);
			$countryCode = $app['config']->get('ebayApi::global_id');
			$siteId = constant("DTS\\eBaySDK\\Constants\\SiteIds::$countryCode");

			return new TradingService(new HttpClient(), compact('apiVersion', 'siteId'));
		};

		ApiService::setObjectResolver($objectMap);

		$this->app->bind('ebay.service.find', 'Gufran\EBay\API\eBayFind');
		$this->app->bind('ebay.service.shop', 'Gufran\EBay\API\eBayShop');
		$this->app->bind('ebay.service.trade', 'Gufran\EBay\API\eBayTrade');
	}
} 