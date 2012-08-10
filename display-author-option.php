<?php
/*
Plugin Name: Display Author Option
Plugin URI: 
Description: This plugin allows you to select how your author is being displayed. You can find the settings to change that under Settings > Reading
Version: 1
Author: CTLT Dev
Author URI: http://ctlt.ubc.ca
License: GPLv2 or later.
*/


add_action( 'init',       array( 'Display_Author_Option', 'init' ) );
add_action( 'pulse_press_ajax', array( 'Display_Author_Option', 'init' )  );
add_action( 'admin_init',       array( 'Display_Author_Option', 'admin_init' ) );

// load the translation files
load_plugin_textdomain('display-author-options', false, basename( dirname( __FILE__ ) ) . '/languages' );

class Display_Author_Option {
	static $settings = array();
	static $users = array();
	public static function init() {
	
		self::$settings = get_option( 'display_author_options' );
		
		if( !is_admin() || ( is_admin() && DOING_AJAX ) ):
			add_filter( 'the_author',  array( 'Display_Author_Option', 'the_author' ) );
			
		endif;
	}
	
	public static function admin_init() {
		add_filter( 'plugin_action_links', array( 'Display_Author_Option','plugin_action_links'), 10, 2 );
		//
		register_setting(
			'reading', // settings page
			'display_author_options', // option name
			array( 'Display_Author_Option', 'validate') // validation callback
		);
			
		add_settings_field(
			'display_author_options', // id
			__('Display author options','display-author-options'), // setting title
			array( 'Display_Author_Option', 'display_settings'), // display callback
			'reading', // settings page
			'default' // settings section
		);
	
	}
	// todo: validate that it is accualy one of the optionss
	public static function validate( $option ) {
	
		
		if( in_array( $option, array("default","%fn %ln","%ln %fn","%nn","%un","%fn","%ln") ) )
			return $option;
		else
			return "default";
	}
	
	public static function display_settings() {
		
		?><div id="display_author_options-wrap">
			<select name="display_author_options">
				<option value="default" <?php selected( self::$settings, 'default' ); ?>><?php _e('Default - What the user selected to display publicly','display-author-options'); ?></option>
				<option value="%fn %ln" <?php selected( self::$settings, '%fn %ln' ); ?>><?php _e('First Name Last Name','display-author-options'); ?></option>
				<option value="%ln %fn" <?php selected( self::$settings, '%ln %fn' ); ?>><?php _e('Last Name First Name','display-author-options'); ?></option>
				<option value="%nn" <?php selected( self::$settings, '%nn' ); ?>><?php _e('Nickname','display-author-options'); ?></option>
				<option value="%un" <?php selected( self::$settings, '%un' ); ?>><?php _e('Username','display-author-options'); ?></option>
				<option value="%fn" <?php selected( self::$settings, '%fn' ); ?>><?php _e('First Name','display-author-options'); ?></option>
				<option value="%ln" <?php selected( self::$settings, '%ln' ); ?>><?php _e('Last Name','display-author-options'); ?></option>
			</select>
			<p class="description"><?php _e('Overwrite how the <em>Author</em> is displayed on the site','display-author-options'); ?></p>
		</div>
		<?php
	
	}
	
	public static function plugin_action_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/display-author-option.php' ) ) {
		$links[] = '<a href="'.admin_url('options-reading.php#display_author_options-wrap').'">'.__('Settings').'</a>';
	}

	return $links;
	}

	
	public static function the_author( $the_author ) {
		global $authordata;
		
		if( !self::$settings || self::$settings = 'default')
			return $the_author;
		switch( self::$settings ) {
			case '%fn %ln':
				$data = get_user_meta( $authordata->data->ID );
				return $data['first_name'][0]." ".$data['last_name'][0];
			break;
			
			case '%ln %fn':
				$data = get_user_meta( $authordata->data->ID );
				return $data['last_name'][0]." ".$data['first_name'][0];
			break;
			
			case '%nn':
				if( isset($authordata->data->user_nicename))
					return $authordata->data->user_nicename;
				else
					return '';
			break;
			
			case '%un':
				if( isset($authordata->data->user_login))
					return $authordata->data->user_login;
				else
					return '';
			break;
			
			case '%fn':
				$data = get_user_meta( $authordata->data->ID );
				return $data['first_name'][0];
			break;
			
			case '%ln':
				$data = get_user_meta( $authordata->data->ID );
				return $data['last_name'][0];
			break;
			
		}
		return $the_author;
	}
	
}