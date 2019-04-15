<?php

/**
 * PO Merger
 * 
 * PO Merger is a WP-CLI command that merges two PO files together to
 * make translation of two similar languages faste (e.g. fr vs fr-ca)
 *
 * @version 1.0.0
 * @author SatelliteWP <info@satellitewp.com>
 */
namespace satellitewp\po;

if ( !defined( 'WP_CLI' ) ) return;

/**
 * WP-CLI PO command for satellitewp/po
 */
class Po_Command extends \WP_CLI_Command {

     /**
     * Merge of two PO files of similar languages.
     * 
     * Basic parameters: <base-locale>, <copy-locale>, <URL> or <core>
     * 
     * <base-locale> 
     * Main locale used for the merge.
     * 
     * <copy-locale>
     * Locale used to get translations that are not present in the base locale.
     * 
     * <URL>
     * URL of the plugin/theme.
     * 
     * <version>
     * Core version.
     * 
     * Full example: 
     * wp po merge fr-ca fr https://wordpress.org/plugins/wordpress-seo/
     * Or
     * wp po merge fr-ca fr 5.0
     * 
     */
    function merge( $args = array(), $assoc_args = array(), $verbose = true ) 
    {
        $merger = new Merger( $args, $assoc_args );
        
        if ( $merger->has_valid_parameters() )
        {   
            $merger->start();
        }
        else 
        { 
            \WP_CLI::error( $merger->get_error_message() );
        }
    }
}

\WP_CLI::add_command( 'po',  __NAMESPACE__ . '\\Po_Command' );