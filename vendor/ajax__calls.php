<?php

// No direct access to this file
defined('ABSPATH') or die('Restricted access');

	include "comp_email.php";
	include "candidaturas.php";
	include "contactos.php";


	class ajax__component extends er_base_plugin {

		var $ajaxHoocks = array(

				"getContacts" => "priv",
				"getArquivoContacts" => "priv",
				"deleteContact" => "priv",
				"arquivarContact" => "priv",
				"restaurarContact" => "priv",
				"saveContact" => "priv",
				"saveContact" => "nopriv",

				"getOfertasEmprego" => "priv",
				"getCandidaturas" => "priv",
				"getArquivoCandidaturas" => "priv",
				"deleteCandidatura" => "priv",
				"arquivarCandidatura" => "priv",
				"restaurarCandidatura" => "priv",
				"saveCandidatura" => "priv",
				"saveCandidatura" => "nopriv"

			);

		function ajax__component(){
			//colocamos as tabelas em memoria
			$this->getTables();
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

		/* Chamadas para candidaturas */
		function getOfertasEmprego(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->verifyNonce('getOfertasEmprego');
			
			$obj = new er_candidaturas();
			$obj->getOfertasEmprego();

			wp_die();
		}
		function getCandidaturas(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->verifyNonce('getCandidaturas');

			$obj = new er_candidaturas();
			$obj->_getCandidaturas(1);
			wp_die();
		}

		function getArquivoCandidaturas(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->verifyNonce('getArquivoCandidaturas');

			$obj = new er_candidaturas();
			
			$obj->_getCandidaturas(2);
			wp_die();
		}

		function deleteCandidatura(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->verifyNonce('deleteCandidatura');

			$obj = new er_candidaturas();

			$obj->deleteCandidatura();
			wp_die();
		}

		function arquivarCandidatura(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->verifyNonce('arquivarCandidatura');

			$obj = new er_candidaturas();

			$obj->setJobState(2);
			wp_die();
		}

		function restaurarCandidatura(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->verifyNonce('restaurarCandidatura');

			$obj = new er_candidaturas();

			$obj->setJobState(1);
			wp_die();
		}

		function saveCandidatura(){
			if($this->validateGCaptcha() == 0){
				wp_die(0);
			}
			$this->verifyNonce('saveCandidatura');

			$obj = new er_candidaturas();

			$obj->saveCandidatura();
			wp_die(0);
		}
		/* end ---- Chamadas para candidaturas */




		


		/* Chamadas para contactos */
		function getContacts(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->verifyNonce('getContacts');

			$obj = new er_contactos();
			$obj->_getContacts(1);
			wp_die();
		}

		function getArquivoContacts(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->verifyNonce('getArquivoContacts');
			
			$obj = new er_contactos();
			$obj->_getContacts(2);
			wp_die();
		}

		function deleteContact(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->verifyNonce('deleteContact');

			$obj = new er_contactos();
			$obj->setContState(0);
			wp_die();
		}

		function arquivarContact(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->verifyNonce('arquivarContact');

			$obj = new er_contactos();
			$obj->setContState(2);
			wp_die();
		}

		function restaurarContact(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->verifyNonce('restaurarContact');

			$obj = new er_contactos();
			$obj->setContState(1);
			wp_die();
		}

		function saveContact(){
			if($this->validateGCaptcha() == 0){
				wp_die(0);
			}

			$this->verifyNonce('saveContact');

			$obj = new er_contactos();
			$obj->saveContact();
			wp_die(0);
		}
		/* end ---- Chamadas para contactos */


	}


?>