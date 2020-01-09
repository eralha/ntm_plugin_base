<?php

namespace ER\app\controllers;

use ER\app\helpers\pluginConfig;
use ER\app\helpers\ajax;
use ER\app\models\mainModel;

	class settings {

        var $AJAX;
        var $config;

		function __construct(){
            $this->config = new pluginConfig();

            //init database
                $this->DB = new mainModel();
                $this->table_settings = $this->DB->getTables()['table_settings'];

			$this->AJAX = ajax::getInstance();;
			//chamamos esta função para linkar estas funções a pedidos ajax wordpress
            $this->AJAX->configAjaxHoocks($this, array('saveSettings', 'getSettings'));
        }
        
        function saveSettings(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
			$this->AJAX->verifyNonce('saveSettings');

			$this->_saveSettings(1);
			wp_die();
		}

		function getSettings(){
			if(!current_user_can( 'manage_options' )){
				wp_die();
			}
            $this->AJAX->verifyNonce('getSettings');
			
			$this->_getSettings();
			wp_die();
		}



        function _getSettings(){
			global $wpdb;

			$query = "SELECT * FROM ";
            $query .= "$this->table_settings ";
            $query .= "ORDER BY iData DESC LIMIT 1";

			$query = $wpdb->prepare($query, false);

            $results = $wpdb->get_results($query, OBJECT);

			echo json_encode($results[0]);

			wp_die();
		}

		function _saveSettings(){
			global $wpdb;
            
            $data = (object)[];
			$data->vchCaptchaSecret = sanitize_text_field($_POST['vchCaptchaSecret']);
			$data->vchCaptchaSiteKey = sanitize_text_field($_POST['vchCaptchaSiteKey']);
			$data->vchFromName = sanitize_text_field($_POST['vchFromName']);
			$data->vchFromEmail = sanitize_text_field($_POST['vchFromEmail']);
			$data->vchEmailGestao = sanitize_text_field($_POST['vchEmailGestao']);
			$data->iData = time();

			$results = $wpdb->insert($this->table_settings, get_object_vars($data));

			echo json_encode($results);

			wp_die();
		}


	}


?>