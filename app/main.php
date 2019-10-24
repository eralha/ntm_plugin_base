<?php

namespace ER\app;

require_once('helpers/ajax.php');
require_once('helpers/pluginPaths.php');
require_once('models/main.php');
require_once('controllers/candidaturas.php');

    class main {
    
            var $optionsName = "er_fc_";
            var $dbVersion = "0.3";
            var $AJAX;
            var $paths;
            public $DB;

            function __construct(){
                //do nothing
            }

            function init(){
                //init path helper
                $this->paths = new \ER\app\helpers\pluginPaths();

                print_r($paths);

                //init ajax helper
                $this->AJAX = new \ER\app\helpers\ajax();

                //init database
                $this->DB = new \ER\app\models\main();

                //ini all controllers
                $candidaturas = new \ER\app\controllers\candidaturas();
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
    
                    $responseHTML .= "<link rel='stylesheet' href='".$this->paths->pluginRoot."/css/style.css' type='text/css' />";
                    $responseHTML .= "<link rel='stylesheet/less' href='".$this->paths->pluginRoot."/css/less/style.less' type='text/css'>";
                    $responseHTML .= "<script src='".$this->paths->pluginRoot."/js/libs/less-1.3.3.min.js'></script>";
    
                    $responseHTML .= "<script>window.pluginsDir = '".$this->paths->pluginRoot."';</script>";
                    $responseHTML .= "<script>window.currentUserId = '".$current_user->data->ID."';</script>";
                    $responseHTML .= "<script>window.nonces = ".$this->AJAX->generateNonces().";</script>";
    
                    $responseHTML .= "<script src='".$this->paths->pluginRoot."/js/libs/angular.min.js'></script>";
                    $responseHTML .= "<script src='".$this->paths->pluginRoot."/js/dist/backend.js?v=1'></script>";
                }
    
                echo $responseHTML;
            }
    
            function printListContactos(){
                $this->printPageDirective('dir-Lista-Contactos');
            }
            function printListCandidaturas(){
                $this->printPageDirective('dir-Lista-Candidaturas');
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