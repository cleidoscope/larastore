<?php

namespace App\Http;

use App\Store;

class CurrentStore
{
	public static function store()
	{
      	$domain = parse_url(url(''), PHP_URL_HOST);
      	$subdomain = Helpers::getSubdomain(url(''));
      	$store = Store::whereIn('subdomain', compact('domain', 'subdomain'))->firstOrFail();

		return $store;
	}
}