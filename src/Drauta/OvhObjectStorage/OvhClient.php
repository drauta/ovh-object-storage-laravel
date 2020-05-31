<?php namespace Drauta\OvhObjectStorage;

/*Dependencias*/
//use OpenCloud\OpenStack;
use OpenStack\OpenStack;
use Guzzle\Http\Exception\BadResponseException;
use OpenStack\ObjectStore\v1\Models\Container;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Stream;


class OvhClient{
	private $url = "https://auth.cloud.ovh.net/v3.0/";
	private $client;
	private $region;
	private $container;
	private $container_name;
	private $container_url;
	
	private function getContainer()
	{
	    if (!$this->container){
		   $this->container = $this->client->objectStoreV1()->getContainer('tsaplus');	
        }
        return $this->container;
	}

    public function __construct($client, $cache)
    {	
        $options = [
        	'authUrl' => $client['authUrl'],
        	'region' => $client['region'],
        	'user' => [
        		'name' => $client['username'],
        		'password' => $client['password'],
        		'domain' => [
        			'id' => 'default',
        		],
        	],
        	'scope' => [
        		'project' => [
        			'id' => $client['projectId'],
        		],
        	],
        	'publicUrl' => $client['container_url'],
        ];


		$this->client = new OpenStack($options);

		$identity = $this->client->identityV3(['region' => $client['region']]);


        if ($token = $cache->get('openstack-token')) {
			$options['cachedToken'] = $token;

        } else {
        	$token = $identity->generateToken(['user' => $options['user']]);

        	$cache->put(
        		'openstack-token',
        		$token->export(),
				//Carbon::now()->diffInSeconds(Carbon::createDateTimeImmutable($token->expires))
				Carbon::now()->diffInSeconds(new Carbon($token->expires->format('Y-m-d H:i:s.u'), $token->expires->getTimezone()))
        	);
        
        	$options['cachedToken'] = $token->export();
		}

        //$container = $this->client->objectStoreV1()->getContainer($client['containerName']);
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
	*  $file puede ser un file de un formulario o un path a un archivo existente
	*/
	public function filePut($file, $filename = null)
	{	
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
	  //$this->getContainer()->upload($filename, fopen($getPath, 'r'));	

	  // You can use any instance of \Psr\Http\Message\StreamInterface
      $stream = new Stream(fopen($getPath, 'r'));
	  $options = [
		'name'    => $filename,
		'stream' => $stream,
	  ];
	  $this->getContainer()->createObject($options);			
	}
	
	public function fileExists($filename)
	{	
	  foreach($this->getContainer()->objectList() as $obj){
	    if($obj->getName() == $filename){
	    return true;
	    }
	  }
	  return false; 
	}
	
	public function fileList()
	{
	  return $this->getContainer()->objectList();
	}
	
	public function fileDelete($filename){
	  $object = $this->getContainer()->getObject($filename);
	  return $object->delete();
	}
	/*Todo crear containers*/
}
