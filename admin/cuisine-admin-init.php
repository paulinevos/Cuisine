<?php
/**
 * Cuisine Admin
 * 
 * Main admin file which loads all settings panels and sets up admin menus.
 * Next to that it init's the alternative admin area
 *
 * @author 		Chef du Web
 * @category 	Admin
 * @package 	Cuisine
 */


	add_action( 'init', 'cuisine_admin_includes', 1);
	add_action( 'admin_init', 'cuisine_admin_init' );
	add_action( 'admin_menu', 'cuisine_admin_scripts' );
	add_action( 'wp_after_admin_bar_render', 'cuisine_admin_errors' );
	
	/**
	* Include required admin core files
	*
 	* @access public
	* @return void
	**/

	function cuisine_admin_includes(){
	
		if( is_admin() ){
			include( 'cuisine-admin-conditionals.php' );				//simple admin conditionals
			include( 'cuisine-admin-settings.php' );
			include( 'cuisine-admin-media.php' );	
		}
	}


	/**
	* Checks to see if Cuisine's simple view exists and toggles views.
	*
 	* @access public
	* @return void
	**/

	function cuisine_admin_init(){
	
		//Check if we are toggeling production mode:
		cuisine_toggle_production_mode();

	}
	



	
	/**
	* Add Cuisine's admin scripts.
	*
 	* @access public
	* @return void
	**/
	function cuisine_admin_scripts(){

		global $pagenow, $post, $cuisine;

		if( isset($_GET['post'] ) ){
			wp_localize_script( 'jquery', 'JSvars', array( 'post_id' => $_GET['post'], 'post_type' => get_post_type( $_GET['post'] ), 'adminurl' => admin_url(), 'pluginurl' => $cuisine->plugin_url, 'asseturl' => $cuisine->asset_url ));		
		
		}else if( isset( $_GET['post_type'] ) ){
			wp_localize_script( 'jquery', 'JSvars', array( 'post_type' => $_GET['post_type'], 'adminurl' => admin_url(), 'pluginurl' => $cuisine->plugin_url, 'asseturl' => $cuisine->asset_url ));		

		}else{
			wp_localize_script( 'jquery', 'JSvars', array( 'adminurl' => admin_url(), 'pluginurl' => $cuisine->plugin_url, 'asseturl' => $cuisine->asset_url ));

		}
	
		
		// Load the media scripts and styles on the widgets page:
			
		if( $pagenow == 'widgets.php' ){
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_media();

		}else if( $pagenow == 'post.php' || $pagenow == 'post-new.php' || $pagenow == 'page.php' || $pagenow == 'page-new.php' ){
			//if this post doesn't support featured images, include the media:
			$pid = cuisine_get_post_id();

			if( $pid && !post_type_supports( get_post_type( $pid ), 'thumbnail' ) ){
				wp_enqueue_media();
			}


			//add the scripts for the general admin area:
			wp_enqueue_script( 'cuisine_main_class', $cuisine->asset_url.'/js/cuisine.js', array('jquery', 'jquery-ui-sortable', 'thickbox' ), false, true  );


		}

		//add the general admin styles & scripts
		wp_enqueue_style( 'cuisine_admin', $cuisine->asset_url.'/css/admin.css' );
		wp_enqueue_script( 'cuisine_admin', $cuisine->asset_url.'/js/admin.js', array('jquery', 'jquery-ui-sortable', 'thickbox' ), false, true  );

	}


	/**
	*	Display erros in cuisine's error-object
	*
 	* @access public
	* @return html
	*/
	function cuisine_admin_errors(){

		global $cuisine;
		$errors = $cuisine->get_errors();


		if( !empty( $errors ) ){

			echo '<div class="cuisine_message cuisine_error">';

				foreach( $errors as $error ){

					echo '<p>'.$error.'</p>';

				}

			echo '</div>';
			
			$cuisine->clear_errors();
		}

	}


	/**
	*	Toggle production-mode on / off and redirect back to the option-page
	*
 	* @access public
	* @return void
	*/
	function cuisine_toggle_production_mode(){
	
		if( isset( $_GET['page'] ) && $_GET['page'] == 'cuisine_options' && isset( $_GET[ 'toggle_production_mode' ] ) && $_GET['toggle_production_mode'] == 'true' ){
	
			//check if the current user can make this switch:
			if( !current_user_can( 'toggle_production_mode' ) )
				return false;
	
	
			global $cuisine;
		
			if( $cuisine->production_mode ){
		
				//Get everything back to development:
				update_option( 'cuisine_production_mode', false );
				$cuisine->production_mode = false;
		
				do_action( 'cuisine_in_development_mode' );
	
			}else{
		
				//Get everything to production:
				update_option( 'cuisine_production_mode', true );
				$cuisine->production_mode = true;
	
				do_action( 'cuisine_in_production_mode' );
			
			}
	
			do_action( 'cuisine_production_mode_toggled', $cuisine->production_mode );
	
			wp_redirect( admin_url().'admin.php?page=cuisine_options' );
			exit();
	
		}
	}



	/**
	*	ADD TOGGLE ACTIONS:
	*/
	add_action( 'cuisine_in_production_mode', 'cuisine_minify_js' );


	/**
	*	When toggling to production mode, minify the js
	*/
	function cuisine_minify_js(){

		global $cuisine;

		//Minify the JS files:
		//Scripts need to be initted for this. 
		$responds = $cuisine->theme->generateMinifiedJS();

		if( $responds == 'fail-minify' ){

			$cuisine->add_error( __('Minifying javascript failed. The js folder in your theme isn\'t writable', 'cuisine' ) );

		}
	
	}

?>