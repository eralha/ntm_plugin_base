<?php

// No direct access to this file
defined('ABSPATH') or die('Restricted access');


	class er_candidaturas extends er_base_plugin {

		function er_candidaturas(){
			//colocamos as tabelas em memoria esta função está na classe "er_base_plugin"
			$this->getTables();
		}

		function getOfertasEmprego(){
			global $wpdb;
			
			$results = new WP_Query( array (
				'post_type'      => 'carreiras',
				'posts_per_page' => 1000,
				'post_status'    => 'publish'
			));
			
			$returnResults = array();

			foreach($results->posts as $item){
				$arr = array();
				$arr["ID"] = $item->ID;
				$arr["post_title"] = $item->post_title;

				$query = "SELECT COUNT(*) FROM ";
				$query .= "$this->table_candidaturas WHERE iEstado = 1 AND iIDPost = ".$arr["ID"];
	
				$query = $wpdb->prepare($query, false);
				$results = $wpdb->get_var($query, OBJECT);

				$arr["candidaturas_num"] = $results;

				array_push($returnResults, $arr);
			}

			echo json_encode($returnResults);

			wp_die();
		}

		function _getCandidaturas($estado){
			global $wpdb;
			
			$query = "SELECT iIDCandidatura, iData,iEstado, iIDPost, vchNome ,vchTelefone ,vchEmail, vchMensagem, vchFicheiroCv, iAutorizacao FROM ";
			$query .= "$this->table_candidaturas WHERE iEstado = $estado ";
			$query .= "ORDER BY iData DESC";

			$query = $wpdb->prepare($query, false);

			$results = $wpdb->get_results($query, OBJECT);

			foreach($results as $item){
				if($item->iIDPost != 0){
					$post = get_post($item->iIDPost);
					$item->vchPostTitle = $post->post_title;
				}
			}

			echo json_encode($results);

			wp_die();
		}

		function deleteCandidatura(){
			global $wpdb;
			
			$msg = $_POST["msgId"];
			$msg = addslashes($msg);


			$query = "DELETE FROM $this->table_candidaturas ";
			$query .= "WHERE iIDCandidatura = %d";

			$query = $wpdb->prepare($query, array($msg));

			$results = $wpdb->query($query);

			echo json_encode($results);

			wp_die();
		}

		function setJobState($estado){
			global $wpdb;
			
			$msg = $_POST["msgId"];
			$msg = addslashes($msg);


			$query = "UPDATE $this->table_candidaturas ";
			$query .= "SET iEstado = $estado ";
			$query .= "WHERE iIDCandidatura = %d";

			$query = $wpdb->prepare($query, $msg);

			$results = $wpdb->query($query);

			echo json_encode($results);

			wp_die();
		}

		public function moveUploadedFile($fileName, $idRegisto) {
			if($_FILES[$fileName]['error'] == 0 && $_FILES[$fileName]['size'] < $this->fileSizeLimit){
				//valida a extensão do ficheiro
				$allowed =  array('pdf', 'docx', 'doc', 'rtf', 'ppt', 'pptx');
				$filename = $_FILES[$fileName]['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				//verifica se o ficheiro é válido
				if(!in_array($ext,$allowed) ) {
					$msg = "Erro ficheiro candidatura: ". $filename ."\n";
					error_log($msg, 3, $_SERVER["DOCUMENT_ROOT"].'/error.log');
					
					return 0;
				}

				//Define o nome para o ficheiro
				//$name = sprintf('%s_%s.%s', $idRegisto, sha1($_FILES[$fileName]['tmp_name'].$this->hashSalt), $ext);

				global $wpdb;

				$query = "UPDATE $this->table_candidaturas";
				$query .= " SET vchFicheiroExtensao = %s, ";
				$query .= " vchFicheiroCv = %s, ";
				$query .= " binFicheiroCV = ";
				$query .= " (SELECT * FROM OPENROWSET(BULK N'".$_FILES[$fileName]['tmp_name']."', SINGLE_BLOB) AS binFicheiroCV)";
				$query .= " WHERE iIDCandidatura = %d;";

				$query = $wpdb->prepare($query, array($ext, $filename, $idRegisto));

				$results = $wpdb->query($query, OBJECT);

				if ($results === FALSE) {
					$msg = "Erro Candidatura moveUploadedFile query: ". $wpdb->last_error."\n";
					error_log($msg, 3, $_SERVER["DOCUMENT_ROOT"].'/error.log');
				}

				$name = $results;

				//return $this->pluginDir . $name; //O ficheiro foi colocado na pasta corrdctamente
				return $name; //O ficheiro foi colocado na pasta corrdctamente
			}

			return 0;
		}

		function saveCandidatura(){
			$this->verifyNonce('saveCandidatura');

			$message = $_POST;

			//$data = $_POST["data"];

			global $wpdb;

			//$message = json_decode(stripslashes($data));

			$msg = (object)[];
			$msg->vchNome = sanitize_text_field($message['txtNome']);
			$msg->vchEmail = sanitize_text_field($message['txtEmail']);
			$msg->vchTelefone = sanitize_text_field($message['txtTelefone']);
			$msg->vchMensagem = sanitize_text_field($message['txtMensagem']);
			$msg->iIDPost = sanitize_text_field($message['postId']);
			$msg->iAutorizacao = sanitize_text_field($message['chkAutorizacao']);
			$msg->vchFicheiroCv = '';
			$msg->iEstado = 1;
			$msg->iData = time();

			$results = $wpdb->insert($this->table_candidaturas, get_object_vars($msg));

			$id = $wpdb->insert_id;

			//se inserio na base de dados envia os emails
			if($results != 0){
				//se existir um ficheiro tentamos mover para a pasta de ficheiros
				if($_FILES['ficheiroCv']){
					$filePath = $this->moveUploadedFile('ficheiroCv', $wpdb->insert_id);

					if($filePath === 'erro' || $filePath === 0){
						//wp_die($filePath);
					}

					//constroi o url para o script que serve o ficheiro em BO, este url vai para o corpo do mail
						//url directo para o ficheiro
						//$msg->vchFicheiroCv = $this->pluginRoot.'/file.php?id='.$wpdb->insert_id;

						//url directo para a "ficha" de candidatura
						$msg->vchFicheiroCv = get_site_url().'/wp-admin/admin.php?page=cl-candidaturas&idcandidatura='.$wpdb->insert_id;
				}else{
					//wp_die($id);
				}
				
				//para ser usado no email
				$msg->assuntoPedido = sanitize_text_field($message['assuntoPedido']);
                
                $mail = new er_comp_email();
				$mail->sendEmails($msg, sanitize_text_field($message['lang']), 'candidatura');
			}

			if ($results === FALSE) {
				$msg = "Erro saveCandidatura: ". $wpdb->last_error."\n";
				error_log($msg, 3, $_SERVER["DOCUMENT_ROOT"].'/error.log');
			}

			wp_die($id);
		}


	}


?>