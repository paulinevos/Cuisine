<?php
/**
 * Cuisine Core
 * 
 * Makes functions a little more readable.
 *
 * @author 		Chef du Web
 * @category 	Core
 * @package 	Cuisine
 */





	/**************************************************/
	/** Registered Conditionals ***********************/
	/**************************************************/



	/**
	*	Check if a plugin is registered with cuisine:
	*/
	function cuisine_has_plugin( $slug ){
		global $cuisine;
		return $cuisine->integrations->is_plugin_registered( $slug );

	}



	/**************************************************/
	/** Theme Helpers *********************************/
	/**************************************************/


	function cuisine_get_theme_style( $sanitize = false ){
		global $cuisine;
		return $cuisine->theme->get_theme_style( $sanitize );
	}

	function cuisine_has_theme_style( $sanitize = false ){
		global $cuisine;
		return $cuisine->theme->has_theme_style();
	}

	function cuisine_get_google_font_link(){
		global $cuisine;
		return $cuisine->theme->get_google_fonts();
	}

	function cuisine_site_url(){
		global $cuisine;
		return $cuisine->site_url;
	}

	function cuisine_template_url(){
		global $cuisine;
		return $cuisine->template_url;
	}

	function cuisine_plugin_url(){
		global $cuisine;
		return $cuisine->plugin_url;
	}


	function cuisine_register_scripts( $scripts ){
		global $cuisine;
		$cuisine->theme->register_scripts( $scripts );
	}



	//A quick function to compare 2 variables and output some text:
	function cuisine_current( $first, $second, $raw = true, $class = 'current' ){

		if( $first == $second ){

			if( $raw ) echo $class;

			return $class;

		}

	} 


	/**************************************************/
	/** Post / Post-meta  getters *********************/
	/**************************************************/


	/**
	*	Get a post id by the $_GET['post'] parameter or the global $post object
	*/	
	function cuisine_get_post_id(){
		global $post, $pagenow;

		if( isset( $_GET['post'] ) )
			return $_GET['post'];

		if( $pagenow == 'post-new.php' && isset( $post ) )
			return $post->ID;

		if( isset( $post ) )
			return $post->ID;

		return false;
	}

	/**
	*	Get post type:
	*/

	function cuisine_is_posttype( $t ){
		global $cuisine;
		return $cuisine->posttypes->admin_current( $t );
	}

	/**
	*	Get a nonce for a certain page:
	*/

	function cuisine_get_nonce(){

		//first, check if we're dealing with a valid cuisine session:
		if( !cuisine_is_valid_session() )
			return false;

		global $cuisine;
		$cuisine->plugins->get_plugin_nonce();
	}




?>
