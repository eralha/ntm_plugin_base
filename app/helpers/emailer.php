<?php

namespace ER\app\helpers;

use ER\app\helpers\pluginConfig;
use ER\app\models\mainModel;

	class emailer {

		var $config;

		function __construct(){
			$this->config = new pluginConfig();
		}

		function sendEmails($message, $lang, $tipo){
			//init db here
			$this->DB = new mainModel();
			$settings = $this->DB->getSavedSettings();

			$emailFromName = $settings[0]->vchFromName;
			$emailFromEmail = $settings[0]->vchFromEmail;
			$emailGestao = $settings[0]->vchEmailGestao;

			/* EMAIL CORTESIA */
				if($lang == 'pt_PT' || $lang == 'pt_BR'){
					$email = $this->getTemplate('email_cortesia_'.$tipo.'_pt.html', $message, $tipo);

					if($tipo == 'contacto'){ $subject = 'Recebemos o seu contacto'; }

					$headers = array('Content-Type: text/html; charset=UTF-8;', 'From: '.$emailFromName.' <'.$emailFromEmail.'>');
					wp_mail($message->vchEmail, $subject, $email, $headers);
				}
				if($lang == 'en_GB'){
					$email = $this->getTemplate('email_cortesia_'.$tipo.'_en.html', $message, $tipo);

					if($tipo == 'contacto'){ $subject = 'We received your contact'; }

					$headers = array('Content-Type: text/html; charset=UTF-8;', 'From: '.$emailFromName.' <'.$emailFromEmail.'>');
					wp_mail($message->vchEmail, $subject, $email, $headers);
				}
			/* END EMAIL CORTESIA */

			/* EMAIL GESTÃO */
				$email = $this->getTemplate('email_dados_'.$tipo.'.html', $message, $tipo);

				if($tipo == 'contacto'){ 
					$subject = 'Contacto Cliente';
					$headers = array('Content-Type: text/html; charset=UTF-8;', 'From: '.$emailFromName.' <'.$emailFromEmail.'>');
					wp_mail($emailGestao, $subject, $email, $headers);
				}
			/* END EMAIL GESTÃO */
        }
        
        function getTemplate($path, $data, $tipo){
			ob_start();

			include $this->config->pluginDirPath . '\emails\\dist\\' . $path;

			$html = ob_get_clean();

			return $html;
		}

	}


?>