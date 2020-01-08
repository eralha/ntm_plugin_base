<?php

namespace ER\app\controllers;

use ER\app\helpers\pluginConfig;
use ER\app\helpers\ajax;
use ER\app\helpers\emailer;
use ER\app\models\mainModel;

	class contactos {

        var $AJAX;
        var $config;

		function __construct(){
            $this->config = new pluginConfig();

            //init database
                $this->DB = new mainModel();
                $this->table_contactos = $this->DB->getTables()['table_contactos'];

			$this->AJAX = ajax::getInstance();;
			//chamamos esta função para linkar estas funções a pedidos ajax wordpress
            $this->AJAX->configAjaxHoocks($this, array('getContacts', 'getArquivoContacts', 'deleteContact', 'arquivarContact', 'restaurarContact', 'saveContact'));
        }
        
        function getContacts(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->AJAX->verifyNonce('getContacts');

			$this->_getContacts(1);
			wp_die();
		}

		function getArquivoContacts(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
            $this->AJAX->verifyNonce('getArquivoContacts');
			
			$this->_getContacts(2);
			wp_die();
		}

		function deleteContact(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->AJAX->verifyNonce('deleteContact');
			
			$this->_setContState(0);
			wp_die();
		}

		function arquivarContact(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->AJAX->verifyNonce('arquivarContact');
			
			$this->_setContState(2);
			wp_die();
		}

		function restaurarContact(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->AJAX->verifyNonce('restaurarContact');
			
			$this->_setContState(1);
			wp_die();
		}

		function saveContact(){
			if($this->validateGCaptcha() == 0){
				wp_die(0);
			}

			$this->AJAX->verifyNonce('saveContact');

			$this->_saveContact();
			wp_die(0);
		}


        function _getContacts($estado){
			global $wpdb;

			$query = "SELECT * FROM ";
			$query .= "$this->table_contactos WHERE iEstado = $estado ";
			$query .= "ORDER BY iData DESC";

			$query = $wpdb->prepare($query, false);

			$results = $wpdb->get_results($query, OBJECT);

			echo json_encode($results);

			wp_die();
		}

		function _setContState($estado){
			global $wpdb;
			
			$msg = $_POST["msgId"];
			$msg = addslashes($msg);


			$query = "UPDATE $this->table_contactos ";
			$query .= "SET iEstado = $estado ";
			$query .= "WHERE iIDContacto = %d";

			$query = $wpdb->prepare($query, $msg);

			$results = $wpdb->query($query);

			echo json_encode($results);

			wp_die();
		}

		function _saveContact(){
			$this->AJAX->verifyNonce('saveContact');

			//$data = $_POST["data"];

			//se existir um ficheiro tentamos mover para a pasta de ficheiros
			//$filePath = $this->moveUploadedFile('ficheiroCv');

			global $wpdb;

			//$message = json_decode(stripslashes($data));
			$message = $_POST;

			$msg = (object)[];
			$msg->vchNome = sanitize_text_field($message['txtNome']);
			$msg->vchEmail = sanitize_text_field($message['txtEmail']);
			$msg->vchEmpresa = sanitize_text_field($message['txtEmpresa']);
			$msg->vchMensagem = sanitize_text_field($message['txtMensagem']);
			$msg->iAutorizacao = sanitize_text_field($message['chkAutorizacao']);
			$msg->iEstado = 1;
			$msg->iData = time();

			$results = $wpdb->insert($this->table_contactos, get_object_vars($msg));

			//se inserio na base de dados envia os emails
			if($results != 0){
				$this->emailer = new er_comp_email();

				//esta var tem de ficar aqui porque dá erro ao tentar ser inserida na BD
				$msg->assuntoPedido = sanitize_text_field($message['assuntoPedido']);

				$this->emailer->sendEmails($msg, sanitize_text_field($message['lang']), 'contacto');
			}

			echo $wpdb->insert_id;

			wp_die();
		}


	}


?>