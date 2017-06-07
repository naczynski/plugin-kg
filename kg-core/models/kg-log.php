<?php


  defined( 'ABSPATH' ) || exit;

  function kg_log( $log )  {
	        
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }

  }

  if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {

		 ini_set( 'error_log', ABSPATH . '../logs/debug.txt' );

  }
