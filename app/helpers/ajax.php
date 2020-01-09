<?php

namespace ER\app\helpers;

use ER\app\helpers\pluginConfig;
use ER\app\models\mainModel;

	class ajax {

		/*
			this class is a singleton implementation
			use the getInstance method to implement the object
			this way we can store the nonces registered in $noncesArray
			for latter generate the nonces in the frontend.
		*/

		var $nonceSalt;
		var $hashSalt;
		var $noncesArray = array();
		private static $instance = null;

		function __construct(){
			//colocamos as tabelas em memoria
			$this->config = new pluginConfig();
			$this->nonceSalt = $this->config->nonceSalt;
			$this->captachKey = $this->config->captachKey;
			$this->hashSalt = $this->config->hashSalt;
		}

		public static function getInstance(){
		  if(!self::$instance){
			self::$instance = new ajax();
		  }
		 
		  return self::$instance;
		}

		function configAjaxHoocks($class, $hoocks){
			//se não existir a variavel global para guardar as nonces criamos
			if(!$this->noncesArray[$this->nonceSalt]){ $this->noncesArray[$this->nonceSalt] = array(); }

			foreach ($hoocks as $key => $value){
				//metemos esta funcção num array para depois gerar as nonces
				array_push($this->noncesArray[$this->nonceSalt], $value);
				add_action('wp_ajax_'.$value, array($class, $value) );
				add_action('wp_ajax_nopriv_'.$value, array($class, $value) );
			}
		}

		function generateNonces(){
			$salt = $this->nonceSalt;
			$hoocks = $this->noncesArray[$this->nonceSalt];
			$nonces = array();

			if(is_user_logged_in()){
				global $current_user;

				$current_userID = $current_user->data->ID;
				$salt .= $current_userID;
			}

			foreach ($hoocks as $key => $value){
				$nonces[$value] = wp_create_nonce(date('ymdH').$salt.$value);;
			}

			return json_encode($nonces);
		}

		function verifyNonce($action){
			$salt = $this->nonceSalt;

			if(is_user_logged_in()){
				global $current_user;

				$current_userID = $current_user->data->ID;
				$salt .= $current_userID;
			}

			$error = array(
				"error" => "NOT_ALLOWED",
				"action" => $action
			);

			if (!wp_verify_nonce($_POST["nonce"], date('ymdH').$salt.$action)){ die(json_encode($error)); }
		}

		public function validateGCaptcha() {
			//init db here
			$this->DB = new mainModel();
			$settings = $this->DB->getSavedSettings();

			$vchCaptchaSecret = $settings[0]->vchCaptchaSecret;

			$post_data = http_build_query(
				array(
					'secret' => $vchCaptchaSecret,
					'response' => $_POST['greCaptcha'],
					'remoteip' => $_SERVER['REMOTE_ADDR']
				)
			);
			$opts = array('http' =>
				array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $post_data
				)
			);
			$context  = stream_context_create($opts);
			$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
			$result = json_decode($response);

			//print_r($result);

			if ($result->success != 1) {
				return 0;
			}

			return 1;
		}

	}


?>