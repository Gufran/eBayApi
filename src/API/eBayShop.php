<?php namespace Gufran\EBay\API;


class eBayFind extends ApiService {

	/**
	 * Get the type of service
	 * Valid return values are shopping, trading and finding
	 *
	 * @return string
	 */
	protected function getServiceType() { return 'shopping'; }
}