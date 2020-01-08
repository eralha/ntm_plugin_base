<?php

namespace ER\app\models;

use ER\app\helpers\pluginConfig;

    class mainModel {
    
            //config vars são usadas em varias classes
            public $table_contactos;
            public $table_candidaturas;
    
            function __construct(){
                $this->config = new pluginConfig();

                $this->getTables();
            }
    
            function getTables(){
                global $wpdb;
    
                $table_contactos = $wpdb->prefix.$this->config->optionsName."_contactos";
    
                $this->table_contactos = $table_contactos;
    
                return array(
                    "table_contactos" => $this->table_contactos,
                );
            }
    
            function createTables(){
                global $wpdb;
                $table_contactos = $this->table_contactos;
    
                $sqlTblContactos = "CREATE TABLE ".$table_contactos." 
                (
                    `iIDContacto` int(8) NOT NULL auto_increment, 
                    `iData` int(32) NOT NULL, 
                    `iEstado` int(32) NOT NULL, 
                    `vchNome` varchar(255) NOT NULL, 
                    `vchEmpresa` varchar(255) NOT NULL, 
                    `vchEmail` varchar(255), 
                    `vchMensagem` varchar(MAX),
                    `iAutorizacao` int(32) NULL,
                    PRIMARY KEY  (`iIDContacto`)
                );";
    
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sqlTblContactos);
    
    
                add_option($this->config->optionsName."_db_version", $this->config->dbVersion);
            }
            function removeTable(){
                global $wpdb;
    
                //$tabea_ficheiros = $wpdb->prefix.$this->optionsName."_contactos";
                //$wpdb->query("DROP TABLE IF EXISTS ". $tabea_ficheiros);
            }
    
        }


?>