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

	public function register($token, $payload = null){
	$url = 'api/device_tokens/' . $token . '/';
	return $this->_send(1, $url, $payload);	
	}

    public function push($tokens, $aps)
    {
	$url = "api/push/";
	$aps['badge'] = isset($aps['badge']) ? $aps['badge'] : '';
	$aps['alert'] = isset($aps['alert']) ? $aps['alert'] : '';
	$payload = array("device_tokens" => $tokens, "aps" => $aps); 
	return $this->_send(0, $url, $payload);
    }

	private function _send($method, $url, $payload = null){
	$session = curl_init('https://go.urbanairship.com/' . $url);
	if($payload !== null){
	$payload = json_encode($payload);		
	curl_setopt($session, CURLOPT_POSTFIELDS, $payload); 
	curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));		
	}
	switch ($method) {
		case 0:
		curl_setopt($session, CURLOPT_USERPWD, $this -> key . ':' . $this -> mastersecret); 
		curl_setopt($session, CURLOPT_POST, True); 
			break;
		
		case 1:
		curl_setopt($session, CURLOPT_USERPWD, $this -> key . ':' . $this -> secret); 
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'PUT');
			break;
	}
	curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
	curl_setopt($session, CURLOPT_HEADER, False); 
	curl_setopt($session, CURLOPT_RETURNTRANSFER, True); 
	curl_exec($session); 	
	$response = curl_getinfo($session);
	curl_close($session);
	return $response['http_code'];
	}

}

/* End of file Urban_airship.php */
?>