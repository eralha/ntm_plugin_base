<?php

namespace ER\app\models;

require_once('/../helpers/pluginConfig.php');

    class main {
    
            //config vars são usadas em varias classes
            public $table_contactos;
            public $table_candidaturas;
    
            function __construct(){
                $this->config = new \ER\app\helpers\pluginConfig();

                $this->getTables();
            }
    
            function getTables(){
                global $wpdb;
    
                $table_contactos = $wpdb->prefix.$this->config->optionsName."_contactos";
                $table_candidaturas = $wpdb->prefix.$this->config->optionsName."_candidaturas";
    
                $this->table_contactos = $table_contactos;
                $this->table_candidaturas = $table_candidaturas;
    
                return array(
                    "table_contactos" => $this->table_contactos,
                    "table_candidaturas" => $this->table_candidaturas,
                );
            }
    
            function createTables(){
                global $wpdb;
                $table_contactos = $this->table_contactos;
                $table_candidaturas = $this->table_candidaturas;
    
                $sqlTblFicheiros = "CREATE TABLE ".$table_contactos." 
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
    
                $sqlTblCandidaturas = "CREATE TABLE ".$table_candidaturas." 
                (
                    `iIDCandidatura` int(8) NOT NULL auto_increment, 
                    `iData` int(32) NOT NULL, 
                    `iEstado` int(32) NOT NULL, 
                    `iIDPost` int(32) NOT NULL, 
                    `vchNome` varchar(32) NOT NULL, 
                    `vchTelefone` varchar(32) NOT NULL, 
                    `vchEmail` varchar(255), 
                    `vchMensagem` varchar(MAX),
                    `vchFicheiroCv` varchar(300),
                    `iAutorizacao` int(32) NULL,
                    `binFicheiroCV` varbinary(MAX) NULL,
                    `vchFicheiroExtensao` varchar(50) NULL,
                    PRIMARY KEY  (`iIDCandidatura`)
                );";
    
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sqlTblFicheiros);
                dbDelta($sqlTblCandidaturas);
    
    
                add_option($this->config->optionsName."_db_version", $this->config->dbVersion);
            }
            function removeTable(){
                global $wpdb;
    
                //$tabea_ficheiros = $wpdb->prefix.$this->optionsName."_contactos";
                //$wpdb->query("DROP TABLE IF EXISTS ". $tabea_ficheiros);
            }
    
        }


?>