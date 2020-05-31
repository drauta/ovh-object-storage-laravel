Installation
------------

Install using composer:

```bash
composer require php-opencloud/openstack
composer require drauta/ovh-object-storage-laravel "dev-master"
```

add to config/app.php

```bash
Drauta\OvhObjectStorage\OvhServiceProvider::class,
```

Add the following to the config/filesystem.php
```bash
'ovh' => [
	'driver'   => 'ovh',
	'username' => 'yourUsername',
	'password' => 'yourPassword',	  
	'tenantId' => 'yourTeenantId',
	'region'   => 'yourRegion',
	'container'=> 'yourContainer',
	'container_url' => 'containerPublicURL'
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
