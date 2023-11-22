<?php

class ewm_global_parameter{

	public static function init(){

		add_action( 'muplugins_loaded' , ['ewm_global_parameter','loop_get_posts_and_process'] );

		// add_action( 'wp_footer', [ 'ewm_global_parameter' , 'show_get_details' ] );

	}

	public static function loop_get_posts_and_process(){

		foreach( $_GET as $key => $value){

			$needle = 'http';

			if( str_starts_with(  $value , $needle ) ){

				$_GET[$key] = urlencode( $value );

			}

		}

	}

	public static function show_get_details(){

		//var_dump( $_GET );

	}

	public static function manage_links(){

		if ( count($_GET) > 0 ) {
			// Go though all link get values
			foreach( $_GET as $key => $value ){
				// if values begin with http? remove the code and replace with other values

				if ( str_starts_with( $value , 'http' ) ) {

					$_GET[$key]  = ewm_global_parameter::replace_http_with_encord( $value );
					
				}

			}

		}

	}

	public static function process_image( $args = [] ){

		$slug_url = '';

		if (array_key_exists($args['slug'], $_GET)) {

			$slug_url = urldecode( $_GET[ $args['slug'] ] );

		}

		$img_string = '';

		if( array_key_exists( $args['slug'] , $_GET ) ){

            if (strlen($args['slug']) > 0) {

				if( !str_starts_with( $slug_url , 'http' ) ){

					$slug_url = 'http://' .$slug_url ;

				}

                $img_string = '<img src="'.$slug_url  .'">';

            }
			else{

				$img_string = ewm_global_parameter::default_img_val( $args );

			}

		}
		else{

			$img_string = ewm_global_parameter::default_img_val( $args );

		}

		return $img_string;

	}

	public static function process_text( $args = [] ){

		$text_string = '';

		if( array_key_exists( $args['slug'] , $_GET ) ){

            if ( strlen( $args['slug'] ) > 0 ) {

                $text_string =  $_GET[ $args['slug'] ];

            }
			else{

				$text_string = ewm_global_parameter::default_text_val( $args );

			}

		}
		else{

			$text_string = ewm_global_parameter::default_text_val( $args );

		}
		//var$text_string

		return $text_string;

	}

	public static function default_text_val( $args = [] ){

		$text_string = '';

		if( array_key_exists( 'default', $args ) ){

			$text_string = $args['default'];

		}

		return $text_string;

	}

	public static function default_img_val( $args = [] ){

		$img_string = '';

		if( array_key_exists( 'default', $args ) ){

			$img_string = '<img src="'. $args['default'] .'">';

		}

		return $img_string;

	}

}

ewm_global_parameter::init();

?>
