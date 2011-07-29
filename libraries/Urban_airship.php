<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Urban_airship {

	private $key;
	private $secret;
	private $mastersecret;

	public function __construct()
	{	
	$this->_ci =& get_instance();	
	$this -> key = $this->_ci->config->item('UA_application_key');
	$this -> secret = $this->_ci->config->item('UA_application_secret');
	$this -> mastersecret = $this->_ci->config->item('UA_application_master_secret');	
	}

    public function push($tokens, $aps)
    {
	$url = "https://go.urbanairship.com/api/push/";
	$aps['badge'] = isset($aps['badge']) ? $aps['badge'] : '';
	$aps['alert'] = isset($aps['alert']) ? $aps['alert'] : '';
	//if there's no sound set, it shouldn't be kept out.
	$push = array("device_tokens" => $tokens, "aps" => $aps); 
	$json = json_encode($push);
	return $this->_send($url, $json);
    }

	private function _send($url, $json){
	$session = curl_init($url); 
	curl_setopt($session, CURLOPT_USERPWD, $this -> key . ':' . $this -> mastersecret); 
	curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
	curl_setopt($session, CURLOPT_POST, True); 
	curl_setopt($session, CURLOPT_POSTFIELDS, $json); 
	curl_setopt($session, CURLOPT_HEADER, False); 
	curl_setopt($session, CURLOPT_RETURNTRANSFER, True); 
	curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); 
	curl_exec($session); 	
	$response = curl_getinfo($session);
	curl_close($session);
	return $response['http_code'];
	}

}

/* End of file Urban_airship.php */
?>