<?php namespace Drauta\Runabove;

/*Dependencias*/
use OpenCloud\OpenStack;
use Guzzle\Http\Exception\BadResponseException;


class RunaboveClient{
	private $url = "https://auth.runabove.io/v2.0/";
	private $client;
	private $service;
	private $container;
	public function __construct($client){		
		$this->client = new OpenStack($this->url, array(
		  'username' => $client['username'],
		  'password' => $client['password'],	  
		  'tenantId' => $client['tenantId'],
		));
		/*Esto no se toca de momento*/
		$this->service = $this->client->objectStoreService('swift', 'SBG-1', 'publicURL');		
		$this->container = $this->service->getContainer($client['container']);
	}

	public function fileGet($filename)
	{		
		$object = $this->container->getObject($filename);
		return $object->getUrl();
	}

	public function filePut($file){		
			$quees = $this->container->uploadObject($file->getClientOriginalName(), fopen($file->getRealPath(), 'r'));				
	}
	
	/*
	*	Return Bool (true if there is a file with the same filename)
	*/
	public function fileExists($filename){
		//TODO: todo
		return false;
	}
	/*Todo crear containers*/
}
