<?php
/**
 * Cuisine Admin
 * 
 * Handles the setting and getting of variables
 *
 * @author 		Chef du Web
 * @category 	Admin
 * @package 	Cuisine
 */



	/*************************************************************************/
	/** GET & SET functions **************************************************/
	/*************************************************************************/


	/**
	* Get a cuisine setting:
	*
 	* @access public
	* @return array
	*/
	function get_cuisine_setting( $type ){

		// first check if this setting excists:
		$setting = get_option( 'cuisine-setting-'.$type );

		$setting = apply_filters( 'cuisine-setting-default', $setting, $type );

		return $setting;
	}


	/**
	*	Update a setting:
	*
 	* @access public
	* @return void
	*/

	function update_cuisine_setting( $type, $value ){

		update_option( 'cuisine-setting-'.$type, $value );

	}




	/*************************************************************************/
	/** OPTIONS pages ********************************************************/
	/*************************************************************************/



	/**
	*	Register the options page:
	*
 	* @access public
	* @return void
	*/
	cuisine_register_option_page();

	function cuisine_register_option_page(){

		global $cuisine;

		$cuisine->plugins->add_plugin_page(

			'main',
			array(

				'title'			=> 	'cuisine_options',
				'label'			=>	'Cuisine',
				'capability'	=>	'manage_cuisine',
				'id'			=>	'cuisine_options',
				'position'		=>	100,
				'func'			=>	'cuisine_option_page'
			)
		);
	}


	/**
	*	Show the options page:
	*
 	* @access public
	* @return void
	*/
	function cuisine_option_page(){

		global $cuisine;


		//include the options page:
		require_once('cuisine-admin-options.php');

		cuisine_show_options_page();

	}


?>
