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
		
		/*
			$query = "UPDATE wp_actuasyser_fc__candidaturas";
			$query .= " SET bFicheiroCV = ";
			$query .= " (SELECT * FROM OPENROWSET(BULK N'C:\\xampp\htdocs\actuasys_nami\wp-content\plugins\wp_contact_form\uploads\\1030_ebfb042eecca958e9b59d86f21b68219b901c220.pdf', SINGLE_BLOB) AS bFicheiroCV)";
			$query .= " WHERE iIDCandidatura = ".$_GET['id'].";";
			$results = $wpdb->query($query, OBJECT);
			print_r($results);
			exit;
		*/
		
		$query = "SELECT vchFicheiroCv FROM ";
		$query .= "$er_base_plugin->table_candidaturas WHERE iIDCandidatura = %d ";

		$query = $wpdb->prepare($query, [$_GET['id']]);
		$results = $wpdb->get_results($query, OBJECT);

		//se encontrar um registo mostra o ficheiro
		if($results){
			/* GET MIME TYPE */
			$fileName = $results[0]->vchFicheiroCv;
			$mime = '';
			foreach($mimeTypes as $i => $value){
				if(strpos($fileName, $i)){
					$mime = $value;
				}
			}
			/* END GET MIME TYPE */



			/* GET FILE CONTENTS */
			// open the file in a binary mode
			$fileName = './uploads/'.$fileName;
			$fp = fopen($fileName, 'rb');

			// send the right headers
			header("Content-Type: ".$mime);
			header("Content-Length: " . filesize($fileName));
			header('Content-Disposition: inline; filename="'.$fileName.'"');

			// dump the picture and stop the script
			fpassthru($fp);
		}
	}

	exit;

?>