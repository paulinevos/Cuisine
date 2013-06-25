<?php

	/**
	*	RETURN THE HTML FOR THE CUISINE OPTION PAGE
	*
 	* @access public
	* @return html
	*/

	function cuisine_show_options_page(){
			
		global $cuisine;

		if( $cuisine->production_mode ){
			$prod_class = 'productionmode';
		}else{
			$prod_class = 'developmentmode';
		}

?>

<div class="wrap">
	<form action="<?php echo admin_url()?>admin.php?page=cuisine_options" method="POST">
	<?php
	
		global $cuisine;
		$cuisine->plugins->get_plugin_nonce();
		

	?>	
	<h2><?php _e('Cuisine Options', 'cuisine');?></h2>
			
		<?php if( current_user_can( 'toggle_production_mode' ) ):?>
		<a class="cuisine_form_section cuisine_production_section <?php echo $prod_class;?>" href="<?php echo admin_url();?>admin.php?page=cuisine_options&toggle_production_mode=true">
			<h3><?php _e( 'Website Status', 'cuisine' );?></h3>
			<?php 

			if( $cuisine->production_mode ){
				echo '<p>'.__('website is functioning normally in', 'cuisine').' <strong>'.__('PRODUCTION MODE', 'cuisine').'</strong></p>';
				echo '<p class="warning_txt">Click this bar to toggle it back to development mode.</p>';
			}else{
				echo '<p>'.__('website might be a bit unstable because it\'s in', 'cuisine').' <strong>'.__('DEVELOPMENT MODE').'</strong></p>';
				echo '<p class="warning_txt">Click this bar to toggle it to production mode.</p>';
			}
			?>
		</a>
		<?php endif;?>

</div>
<?php } ?>