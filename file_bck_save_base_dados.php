<?php

	/* Verifica se o user está logado e se tem permissões para ler o ficheiro*/
	require_once("../../../wp-load.php");
	if(!current_user_can( 'manage_options' )){
		wp_die('Acesso não autorizado.');
	}

	$mimeTypes = array();
	$mimeTypes['.pdf'] = 'application/pdf';
	$mimeTypes['.docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
	$mimeTypes['.doc'] = 'application/msword';
	$mimeTypes['.ppt'] = 'application/vnd.ms-powerpoint';
	$mimeTypes['.pptx'] = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
	$mimeTypes['.rtf'] = 'application/rtf';


	$er_base_plugin->getTables();

	if(isset($_GET['id'])){
		global $wpdb;
		
		$query = "SELECT vchFicheiroExtensao, binFicheiroCV, vchFicheiroCv FROM ";
		$query .= "$er_base_plugin->table_candidaturas WHERE iIDCandidatura = %d ";


		$query = $wpdb->prepare($query, [$_GET['id']]);
		
		if ($wpdb->query($query) === FALSE) {
			$msg = "Erro Candidatura ficheiro handler query: ". $wpdb->last_error."\n";
			error_log($msg, 3, $_SERVER["DOCUMENT_ROOT"].'/error.log');
			die($msg);
		}

		$results = $wpdb->get_results($query, OBJECT);

		//se encontrar um registo mostra o ficheiro
		if($results){
			/* GET MIME TYPE */
			$fileName = $results[0]->vchFicheiroExtensao;
			$mime = '';
			foreach($mimeTypes as $i => $value){
				if(strpos($i, $fileName)){
					$mime = $value;
				}
			}
			/* END GET MIME TYPE */


			/*write temp file*/
			/*
			$tempName = sha1(date("Y-m-d H:i:s")).".".$results[0]->vchFicheiroExtensao;
			file_put_contents($tempName, $results[0]->bFicheiroCV);
			*/

			/* GET FILE CONTENTS */
			// send the right headers
			header("Content-Type: ".$mime);
			header("Content-Length: " . strlen($results[0]->binFicheiroCV));
			header('Content-Disposition: inline; filename="'.$results[0]->vchFicheiroCv.'"');

			print($results[0]->binFicheiroCV);

			// dump the picture and stop the script
			//fpassthru($fp);
		}

	}

	exit;

?>