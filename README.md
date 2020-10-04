Installation
------------

Install using composer:

```bash
composer require mpuig9406/ovh-object-storage-laravel "dev-master"
```

add to config/app.php

```bash
Drauta\OvhObjectStorage\OvhServiceProvider::class,
```

Add the following to the config/filesystem.php
```bash
        'ovh' => [
            'driver' => 'ovh',
            'authUrl' => env('OS_AUTH_URL', 'https://auth.cloud.ovh.net/v3/'),
            'projectId' => env('OS_PROJECT_ID'),
            'region' => env('OS_REGION_NAME'),
            'userDomain' => env('OS_USER_DOMAIN_NAME', 'Default'),
            'username' => env('OS_USERNAME'),
            'password' => env('OS_PASSWORD'),
            'containerName' => env('OS_CONTAINER_NAME'),
        
            // Since v1.2
            // Optional variable and only if you are using temporary signed urls.
            // You can also set a new key using the command 'php artisan ovh:set-temp-url-key'.
            //'tempUrlKey' => env('OS_TEMP_URL_KEY'),
        
            // Since v2.1
            // Optional variable and only if you have setup a custom endpoint.
            //'endpoint' => env('OS_CUSTOM_ENDPOINT'),
        
            // Optional variables for handling large objects.
            // Defaults below are 300MB threshold & 100MB segments.
            'swiftLargeObjectThreshold' => env('OS_LARGE_OBJECT_THRESHOLD', 300 * 1024 * 1024),
            'swiftSegmentSize' => env('OS_SEGMENT_SIZE', 100 * 1024 * 1024),
            'swiftSegmentContainer' => env('OS_SEGMENT_CONTAINER', null),
        
            // Optional variable and only if you would like to DELETE all uploaded object by DEFAULT.
            // This allows you to set an 'expiration' time for every new uploaded object to
            // your container. This will not affect objects already in your container.
            //
            // If you're not willing to DELETE uploaded objects by DEFAULT, leave it empty.
            // Really, if you don't know what you're doing, you should leave this empty as well.
            'deleteAfter' => env('OS_DEFAULT_DELETE_AFTER', null),
        
            // Optional variable to cache your storage objects in memory
            // You must require league/flysystem-cached-adapter to enable caching
            'cache' => true, // Defaults to false
            'container_url' => 'https://storage.gra.cloud.ovh.net/v1/AUTH_#############'
        ],
```
Laravel
-------
This package provides an integration with OVH object container. 

Usage:

Saves the form file: 
$filename not mandatory

```bash
Storage::disk('ovh')->filePut($request->file('file'), $filename = null);
```
Get the file url from config container public URL (for speed optimization, no call is made to OS api):

```bash
Storage::disk('ovh')->fileGetUrl($filename);
```

Get the file url from container (call to OS api, slower than fileGetUrl() ):

```bash
Storage::disk('ovh')->fileGet($filename);
```

Return if a file exists (true or false)
```bash
Storage::disk('ovh')->fileExists($filename);
```
