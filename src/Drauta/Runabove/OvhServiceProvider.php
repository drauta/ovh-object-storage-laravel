<?php namespace Drauta\OvhObjectStorage;

use Storage;
use Illuminate\Support\ServiceProvider;

//use Drauta\RunaboveClient;

class OvhServiceProvider extends ServiceProvider {


	public function boot()
  {
        Storage::extend('ovh', function($app, $config)
        {
            $client = new RunaboveClient($config);   
            return $client;
        });
    }




	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
