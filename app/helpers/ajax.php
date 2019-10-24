<?php

namespace ER\app\helpers;

	class ajax {

		var $nonceSalt;
		var $hashSalt;

		function __construct(){
			//colocamos as tabelas em memoria

			$this->config = new \ER\app\helpers\pluginConfig();
			$this->nonceSalt = $this->config->nonceSalt;
			$this->hashSalt = $this->config->hashSalt;
		}

		function configAjaxHoocks($class, $hoocks){
			//se não existir a variavel global para guardar as nonces criamos
			if(!$GLOBALS[$this->nonceSalt]){ $GLOBALS[$this->nonceSalt] = array(); }

			foreach ($hoocks as $key => $value){
				//metemos esta funcção num array para depois gerar as nonces
				array_push($GLOBALS[$this->nonceSalt], $value);
				add_action('wp_ajax_'.$value, array($class, $value) );
				add_action('wp_ajax_nopriv_'.$value, array($class, $value) );
			}
		}

		function generateNonces(){
			$salt = $this->nonceSalt;
			$hoocks = $GLOBALS[$this->nonceSalt];
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
			$post_data = http_build_query(
				array(
					'secret' => '6Leom4YUAAAAAHKnvHZy49lNqlwLS5QE8__xgViO',
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