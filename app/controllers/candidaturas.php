<?php

namespace ER\app\controllers;

use ER\app\helpers\pluginConfig;
use ER\app\helpers\ajax;
use ER\app\helpers\emailer;

	class candidaturas {

        var $AJAX;
        var $config;

		function __construct(){
            $this->config = new pluginConfig();

			$this->AJAX = ajax::getInstance();;
			//chamamos esta função para linkar estas funções a pedidos ajax wordpress
            $this->AJAX->configAjaxHoocks($this, array('_getCandidaturas', 'getContacts', 'getCandidaturas'));
        }
        
        public function getContacts(){
            echo '[]';
            wp_die();
        }

        public function getCandidaturas(){
            echo '[]';
            wp_die();
        }

		public function _getCandidaturas($estado){
			global $wpdb;
			
			$query = "SELECT iIDCandidatura, iData,iEstado, iIDPost, vchNome ,vchTelefone ,vchEmail, vchMensagem, vchFicheiroCv, iAutorizacao FROM ";
			$query .= "$this->table_candidaturas WHERE iEstado = $estado ";
			$query .= "ORDER BY iData DESC";

			//$query = $wpdb->prepare($query, false);
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


	}


?>