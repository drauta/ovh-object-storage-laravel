<?php namespace Drauta\OvhObjectStorage;

/*Dependencias*/
use OpenCloud\OpenStack;
use Guzzle\Http\Exception\BadResponseException;


class OvhClient{
	private $url = "https://auth.cloud.ovh.net/v2.0/";
	private $client;
	private $region;
	private $container;
	private $container_name;
	private $container_url;
	
	private function getContainer(){
  	if (!$this->container){
        $this->container = $this->client->objectStoreService('swift', $this->region, 'publicURL')->getContainer($this->container_name);		
    }
    
    return $this->container;
	}
	
	public function __construct($client){		
		$this->client = new OpenStack($this->url, array(
		  'username' => $client['username'],
		  'password' => $client['password'],	  
		  'tenantId' => $client['tenantId'],
		));
		$this->region = $client['region'];
		$this->container_name = $client['container'];
		$this->container_url = $client['container_url'];
	}

	public function fileGet($filename, $break_cache = false)
	{
    $url = $this->getContainer()->getObject($filename)->getUrl();
  	if ($break_cache) $url .= '?'.time();
		return $url;
	}
	
	public function fileGetUrl($filename, $break_cache = false)
	{	
  	$url = $this->container_url.'/'.$filename;
  	if ($break_cache) $url .= '?'.time();
		return $url;
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
		
		$this->getContainer()->uploadObject($filename, fopen($getPath, 'r'));				
	}
	
	public function fileExists($filename){	
		foreach($this->getContainer()->objectList() as $obj){
			if($obj->getName() == $filename){
				return true;
			}
		}
		return false; 
	}
	
	public function fileList(){
		return $this->getContainer()->objectList();
	}
	
	public function fileDelete($filename){
		$object = $this->getContainer()->getObject($filename);
		return $object->delete();
	}
	/*Todo crear containers*/
}
