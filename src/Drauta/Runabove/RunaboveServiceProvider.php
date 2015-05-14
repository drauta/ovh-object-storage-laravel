<?php namespace Drauta\Runabove;

use Storage;
use Illuminate\Support\ServiceProvider;
use Drauta\RunaboveClient;

class RunaboveServiceProvider extends ServiceProvider {


	public function boot()
  {
        Storage::extend('runabove', function($app, $config)
        {
            $client = new RunAboveClient($config);   
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
