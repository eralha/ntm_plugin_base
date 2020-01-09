<?php

namespace ER\app;

use ER\app\helpers\pluginConfig;
use ER\app\helpers\ajax;
use ER\app\models\mainModel;
use ER\app\controllers\contactos;
use ER\app\controllers\settings;

    class main {
    
            var $AJAX;
            var $config;
            public $DB;

            function __construct(){
                //do nothing
                $this->init();
            }

            function init(){
                //init path helper
                $this->config = new pluginConfig();

                //init ajax helper
                $this->AJAX = ajax::getInstance();

                //init database
                $this->DB = new mainModel();

                //ini all controllers
                $contactos = new contactos();
                $settings = new settings();
            }
    
            function activationHandler(){
                $this->DB->createTables();
            }
            function deactivationHandler(){
                $this->DB->removeTable();
            }
    
            public function printPageDirective($directiveName){
                global $wpdb;
                global $current_user;
    
                $pluginDir = str_replace("", "", plugin_dir_url(__FILE__));
                set_include_path($pluginDir);
    
                $successMSG = "";
                $errorMSG = "";
    
                $responseHTML = "";
    
                if(is_user_logged_in()){
                    //Se for admin o ecran por defeito é outro
                    if($current_user->caps["administrator"] == 1) {
                        echo "<script>window.isAdmin = true;</script>";
                    }
    
                    //este é o menu de navegação que será sempre incluido
                    //$responseHTML = file_get_contents($pluginDir."templates/backend/main.php", false);
    
                    $responseHTML .= "<div class='".$directiveName."'></div>";
    
                    $responseHTML .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
    
                    $responseHTML .= "<link rel='stylesheet' href='".$this->config->pluginRoot."/css/style.css' type='text/css' />";
    
                    $responseHTML .= "<script>window.pluginsDir = '".$this->config->pluginRoot."';</script>";
                    $responseHTML .= "<script>window.currentUserId = '".$current_user->data->ID."';</script>";
                    $responseHTML .= "<script>window.nonces = ".$this->AJAX->generateNonces().";</script>";
    
                    $responseHTML .= "<script src='".$this->config->pluginRoot."/js/libs/angular.min.js'></script>";
                    $responseHTML .= "<script src='".$this->config->pluginRoot."/js/dist/backend.js?v=1'></script>";
                }
    
                echo $responseHTML;
            }
    
            function printListContactos(){
                $this->printPageDirective('dir-Lista-Contactos');
            }

            function printListSettings(){
                $this->printPageDirective('dir-Lista-Settings');
            }
    
            function addHeaderContent($atts){
                global $wpdb;
                global $current_user;
    
                $current_userID = $current_user->data->ID;
                $pluginDir = str_replace("", "", plugin_dir_url(__FILE__));
                set_include_path($pluginDir);
    
                $responseHTML = "";
    
                    if(is_user_logged_in()){
                        $responseHTML .= "<script>window.currentUserId = '".$current_user->data->ID."';</script>";
                    }
    
                    $responseHTML .= "<script>var ajaxurl = '".admin_url('admin-ajax.php')."';</script>";
                    $responseHTML .= "<script>window.nonces = ".$this->AJAX->generateNonces().";</script>";
    
                echo $responseHTML;
            }//end add content
    
        }


?>