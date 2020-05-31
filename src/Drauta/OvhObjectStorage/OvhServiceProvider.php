<?php namespace Drauta\OvhObjectStorage;

use Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

//use Drauta\OvhClient;

class OvhServiceProvider extends ServiceProvider {


  public function boot(CacheRepository $cache)
  {
    Storage::extend('ovh', function($app, $config) use ($cache)
    {
      $client = new OvhClient($config, $cache);   
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
