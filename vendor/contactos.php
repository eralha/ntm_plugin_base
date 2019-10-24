<?php

// No direct access to this file
defined('ABSPATH') or die('Restricted access');

	class er_contactos extends er_base_plugin {


		function er_contactos(){
			//colocamos as tabelas em memoria
			$this->getTables();
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

		function setContState($estado){
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

		function saveContact(){
			$this->verifyNonce('saveContact');

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
				$mail = new er_comp_email();

				//esta var tem de ficar aqui porque dá erro ao tentar ser inserida na BD
				$msg->assuntoPedido = sanitize_text_field($message['assuntoPedido']);

				$mail->sendEmails($msg, sanitize_text_field($message['lang']), 'contacto');
			}

			echo $wpdb->insert_id;

			wp_die();
		}


	}


?>