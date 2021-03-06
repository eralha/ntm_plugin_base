<?php
	/*
		Plugin Name: Ntm Contact form
		Plugin URI: 
		Description: Formulário de contactos com angular.js
		Version: 0.0.3
		Author: Netmais
		Author URI: 
	*/

// No direct access to this file
defined('ABSPATH') or die('Restricted access');

require_once('app/autoloader.php');

$er_base_plugin = new ER\app\main();


//Actions and Filters
if (isset($er_base_plugin)) {
	//Actions
		register_activation_hook(__FILE__, array($er_base_plugin, 'activationHandler'));
		register_deactivation_hook(__FILE__, array($er_base_plugin, 'deactivationHandler'));
		add_action('init', array($er_base_plugin, 'init'));

		add_action('admin_menu', 'er_base_plugin_init');

	//Filters
		add_action('wp_head', array($er_base_plugin, 'addHeaderContent' ));

	//scripts
}

//Initialize the admin panel
if (!function_exists("er_base_plugin_init")) {
	function er_base_plugin_init() {
		global $er_base_plugin;
		if (!isset($er_base_plugin)) {
			return;
		}
		if ( function_exists('add_submenu_page') ){
			//ADDS A LINK TO TO A SPECIFIC ADMIN PAGE
			add_menu_page('Contactos', 'Contactos', 'publish_posts', 'cl-contactos', array($er_base_plugin, 'printListContactos'), 'dashicons-nametag', 50);
				add_submenu_page( 'cl-contactos', 'Contactos - Settings', 'Settings', 'publish_posts', 'cl-contactos-settings', array($er_base_plugin, 'printListSettings'));
		}
	}
}
?>