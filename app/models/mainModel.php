<?php

namespace ER\app\models;

use ER\app\helpers\pluginConfig;

    class mainModel {
    
            //config vars são usadas em varias classes
            public $table_contactos;
            public $table_settings;
    
            function __construct(){
                $this->config = new pluginConfig();

                $this->getTables();
            }

            function getSavedSettings(){
                global $wpdb;
                
                $query = "SELECT * FROM ";
                $query .= "$this->table_settings ";
                $query .= "ORDER BY iData DESC LIMIT 1";
    
                $query = $wpdb->prepare($query, false);
    
                $results = $wpdb->get_results($query, OBJECT);
                
                return $results;
            }
    
            function getTables(){
                global $wpdb;
    
                $table_contactos = $wpdb->prefix.$this->config->optionsName."_contactos";
                $table_settings = $wpdb->prefix.$this->config->optionsName."_settings";
    
                $this->table_contactos = $table_contactos;
                $this->table_settings = $table_settings;
    
                return array(
                    "table_contactos" => $this->table_contactos,
                    "table_settings" => $this->table_settings,
                );
            }
    
            function createTables(){
                global $wpdb;
                $table_contactos = $this->table_contactos;
                $table_settings = $this->table_settings;
    
                $sqlTblContactos = "CREATE TABLE ".$table_contactos." 
                (
                    `iIDContacto` int(8) NOT NULL auto_increment, 
                    `iData` int(32) NOT NULL, 
                    `iEstado` int(32) NOT NULL, 
                    `vchNome` varchar(255) NOT NULL, 
                    `vchEmpresa` varchar(1000) NOT NULL, 
                    `vchTelefone` varchar(1000) NOT NULL, 
                    `vchWebsite` varchar(1000) NOT NULL, 
                    `vchComoConheceu` varchar(1000) NOT NULL, 
                    `vchEmail` varchar(1000), 
                    `vchMensagem` varchar(6000),
                    `iAutorizacao` int(32) NULL,
                    PRIMARY KEY  (`iIDContacto`)
                );";

                $sqlTblSettings = "CREATE TABLE ".$table_settings." 
                (
                    `iID` int(8) NOT NULL auto_increment,
                    `iData` int(32) NOT NULL,  
                    `vchCaptchaSecret` varchar(255) NOT NULL,
                    `vchCaptchaSiteKey` varchar(255) NOT NULL,
                    `vchEmailGestao` varchar(255) NOT NULL,
                    `vchFromName` varchar(255) NOT NULL,
                    `vchFromEmail` varchar(255) NOT NULL,
                    PRIMARY KEY  (`iID`)
                );";
    
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sqlTblContactos);
                dbDelta($sqlTblSettings);
    
    
                add_option($this->config->optionsName."_db_version", $this->config->dbVersion);
            }
            function removeTable(){
                global $wpdb;
    
                //$tabea_ficheiros = $wpdb->prefix.$this->optionsName."_contactos";
                //$wpdb->query("DROP TABLE IF EXISTS ". $tabea_ficheiros);
            }
    
        }


?>