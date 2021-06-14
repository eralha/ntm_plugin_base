<?php

namespace ER\app\helpers;

	class pluginConfig {

		//config vars são usadas em varias classes
		public $optionsName = "ntm_fc_";
		public $dbVersion = "0.3";
		public $nonceSalt = "ntm-plugin-nonce-form-contactos";
		public $hashSalt = 'bbacbbc7154c39abc3407c7738dbe3189bdbfa3c6c5922d490c66d3bb6ab239e';
		public $captachKey = '';
		public $uploadDirPath;
		public $pluginDirPath;
		public $pluginRoot;

		function __construct(){
			//init plugin folder paths
			$this->uploadDirPath = dirname(__FILE__).'\uploads\\';
			//precisamos de remover o path da pasta app, porque esta folder fica na root do plugin
			$this->uploadDirPath = str_replace('\app\helpers', '', $this->uploadDirPath);

			$this->pluginDirPath = dirname(__FILE__);
			//precisamos de remover o path da pasta app, porque esta folder fica na root do plugin
			$this->pluginDirPath = str_replace('app\helpers', '', $this->pluginDirPath);

			$this->pluginRoot = plugins_url('/ntm_contact_form/', '');
			$this->pluginUploads = $this->pluginRoot.'uploads/';
		}

	}


?>