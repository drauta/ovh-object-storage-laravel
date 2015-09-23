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
		$this->service = $this->client->objectStoreService('swift', $client['region'], 'publicURL');		
		$this->container = $this->service->getContainer($client['container']);
	}

	public function fileGet($filename)
	{		
		$object = $this->container->getObject($filename);
		return $object->getUrl();
	}
	/*
		File puede ser un file de un formulario o un path a un archivo existente
	*/
	public function filePut($file, $filename = null){	
		
		$getPath = null;
		$isString = is_string($file);
		
		if($isString){
				$getPath = $file;
				
		}else{
				$getPath = $file->getRealPath();		
		}		
		
		if($filename == null){
			if($isString){
				$explodePath = explode("/", $file);
				$filename = $explodePath[count($explodePath)-1];
			}else{
				$filename = $file->getClientOriginalName();
			}
		}	
		
		$this->container->uploadObject($filename, fopen($getPath, 'r'));				
	}
	
	public function fileExists($filename){	
		foreach($this->container->objectList() as $obj){
			if($obj->getName() == $filename){
				return true;
			}
		}
		return false; 
	}
	
	public function fileList(){
		return $this->container->objectList();
	}
	
	public function fileDelete($filename){
		$object = $this->container->getObject($filename);
		return $object->delete();
	}
	/*Todo crear containers*/
}
