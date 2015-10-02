Installation
------------

Install using composer:

```bash
composer require drauta/ovh-object-storage-laravel "dev-master"
```

add to config/app.php

```bash
'Drauta\OvhObjectStorage\OvhServiceProvider',
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
Get the file url from container:

```bash
Storage::disk('ovh')->fileGet($filename);
```

Return if a file exists (true or false)
```bash
Storage::disk('ovh')->fileExists($filename);
```
