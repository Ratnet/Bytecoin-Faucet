<?php 

class Recaptcha {


	public function __construct($keys = array()) {
		$this->site_key = $keys['site_key'];
		$this->secret_key = $keys['secret_key'];
	}
	
  	public function set() {
    	
      if(isset($_POST['g-recaptcha-response'])) {
			return True;
		}
		
		return False;
    	
  	}
	
	
	public function render() {
	
		//Create the html code
		$html = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
		$html .= '<div class="g-recaptcha" data-sitekey="'.$this->site_key.'"></div>';
		    
		//return the html    
		return $html;
	}
	
	public function verify($response) {
		
		//Get user ip
		$ip = $_SERVER['REMOTE_ADDR'];
		
		//Build up the url
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$full_url = $url.'?secret='.$this->secret_key.'&response='.$response.'&remoteip='.$ip;
	
		//Get the response back decode the json
		$data = json_decode(file_get_contents($full_url));
		
		//Return true or false, based on users input
		if(isset($data->success) && $data->success == true) {
			return True;
		}
		
		return False;
	}
	
	


}



 ?>