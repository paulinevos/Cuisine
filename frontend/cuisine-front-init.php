<?php

/**
 * Cuisine Front actions
 * 
 * Handles the includes for the frontend functions.
 *
 * @author 		Chef du Web
 * @category 	Front
 * @package 	Cuisine
 */


	add_action( 'init', 'cuisine_front_init', 1 );


	function cuisine_front_init(){

		global $cuisine, $post; 

		// init image functions
		require_once( 'cuisine-front-images.php' );

		// init video functions
		require_once( 'cuisine-front-videos.php' );

		// init color functions:
		require_once( 'cuisine-front-color.php' );

		// init excerpt functions
		require_once( 'cuisine-front-excerpt.php' );
	
		// init comments functions
		require_once( 'cuisine-front-comments.php' );	
		

		// Register Cuisine frontend javascripts
		$args = array(
			'id'			=>	'cuisine_script',
			'url'			=> 	$cuisine->asset_url.'/js/cuisine-front.js',
			'root_url'		=>	$cuisine->plugins->root_url('cuisine', true ).'assets/js/cuisine-front.js',
			'on_page'		=>	'all'
		);

		$cuisine->theme->register_scripts( $args );

		$args = array(
		      'id'			=> 'cuisine_images',
		      'url'			=> 	$cuisine->asset_url.'/js/cuisine-images.js',
		      'root_url'	=> $cuisine->plugins->root_url('cuisine', true).'assets/js/cuisine-images.js',
		      'on_page'		=> 'all'
		);

		$cuisine->theme->register_scripts( $args );

		$args = array(
		      'id'			=> 'cuisine_validate',
		      'url'			=> 	$cuisine->asset_url.'/js/cuisine-validate.js',
		      'root_url'	=> $cuisine->plugins->root_url('cuisine', true).'assets/js/cuisine-validate.js',
		      'on_page'		=> 'all'
		);

		$cuisine->theme->register_scripts( $args );



		if( isset( $post ) )
			wp_localize_script( 'chef-front-script', 'post', array( 'ID' => $post->ID, 'post_title' => $post->post_title, 'slug' => $post->post_name, 'post_parent' => $post->post_parent, 'guid' => $post->guid ) );
	}


?>