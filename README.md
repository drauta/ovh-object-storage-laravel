Installation
------------

Install using composer:

```bash
composer require drauta/runabove "dev-master"
```

add to config/app.php

```bash
'Drauta\Runabove\RunaboveServiceProvider',
```

Add the following to the config/filesystem.php
```bash
'runabove' => [
	'driver'   => 'runabove',
	'username' => 'yourUsername',
	'password' => 'yourPassword',	  
	'tenantId' => 'yourTeenantId',		
	'container'=> 'yourContainer',
],
```
Laravel
-------
This package provides an integration with RunAbove object container. 

Usage:

Saves the form file: 

```bash
Storage::disk('runabove')->filePut($request->file('file'));
```
Get the file url from container:

```bash
Storage::disk('runabove')->fileGet($filename);
```

Return if a file exists (true or false)
```bash
Storage::disk('runabove')->fileExists($filename);
```
