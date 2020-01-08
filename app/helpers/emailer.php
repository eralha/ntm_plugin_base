<?php

namespace ER\app\helpers;

use ER\app\helpers\pluginConfig;

	class emailer {


		function __construct(){
            $this->config = new pluginConfig();
		}

		function sendEmails($message, $lang, $tipo){
			/* EMAIL CORTESIA */
				if($lang == 'pt_PT' || $lang == 'pt_BR'){
					$email = $this->getTemplate('email_cortesia_'.$tipo.'_pt.php', $message, $tipo);

					if($tipo == 'contacto'){ $subject = 'Recebemos o seu contacto'; }

					$headers = array('Content-Type: text/html; charset=UTF-8;', 'From: '.$this->fromName.' <'.$this->fromEmail.'>');
					wp_mail($message->vchEmail, $subject, $email, $headers);
				}
				if($lang == 'en_GB'){
					$email = $this->getTemplate('email_cortesia_'.$tipo.'_en.php', $message, $tipo);

					if($tipo == 'contacto'){ $subject = 'We received your contact'; }

					$headers = array('Content-Type: text/html; charset=UTF-8;', 'From: '.$this->fromName.' <'.$this->fromEmail.'>');
					wp_mail($message->vchEmail, $subject, $email, $headers);
				}
			/* END EMAIL CORTESIA */

			/* EMAIL GESTÃO */
				$email = $this->getTemplate('email_dados_'.$tipo.'.php', $message, $tipo);

				if($tipo == 'contacto'){ 
					$subject = 'Contacto Cliente';
					$headers = array('Content-Type: text/html; charset=UTF-8;', 'From: '.$this->fromName.' <'.$this->fromEmail.'>');
					wp_mail($this->emailGestao, $subject, $email, $headers);
				}
			/* END EMAIL GESTÃO */
        }
        
        function getTemplate($path, $data, $tipo){
			ob_start();

			include $this->pluginDirPath . '\emails\email_meta.php';
			include $this->pluginDirPath . '\emails\email_topo_'.$tipo.'.php';
			include $this->pluginDirPath . '\emails\\' . $path;
			include $this->pluginDirPath . '\emails\email_bottom.php';

			$html = ob_get_clean();

			$cssin = new FM\CSSIN();
			$html_with_inlined_css = $cssin->inlineCSS('mail.html', $html);

			return $html_with_inlined_css;
		}

	}


?>