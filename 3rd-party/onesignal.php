<?php
// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

function pwaforwp_onesignal_compatiblity() {
		
	if ( class_exists( 'OneSignal' ) ) {
				
		if ( ! is_multisite() ) {
								                        
                        pwaforwp_add_sw_to_onesignal_sw();
			                        
		}
								
	}
}


function pwaforwp_onesignal_insert_gcm_sender_id( $manifest ) {
    
        if ( ! is_multisite() ) {
            
            if ( class_exists( 'OneSignal' ) ) {
            
            $manifest['gcm_sender_id'] = '482941778795';
            
           }
        
        }
        
			
	return $manifest;
}

add_filter( 'pwaforwp_manifest_file_name', 'pwaforwp_onesignal_insert_gcm_sender_id' );

function pwaforwp_onesignal_change_sw_name($name){
    
    if ( ! is_multisite() ) {
            
            if ( class_exists( 'OneSignal' ) ) {
            
            $name = 'OneSignalSDKWorker.js';
            
            }
        
        }
           
    return $name;
    
}
add_filter( 'pwaforwp_sw_name_modify', 'pwaforwp_onesignal_change_sw_name' );

function pwaforwp_add_sw_to_onesignal_sw(){
    
        $abs_path              = str_replace("//","/",str_replace("\\","/",realpath(ABSPATH))."/");
        $onesignal_sdk         = $abs_path.'OneSignalSDKWorker.js';
        $onesignal_sdk_updator = $abs_path.'OneSignalSDKUpdaterWorker.js';
        $url                   = trailingslashit(get_home_url());
                                                 
        $content  = "";
        $content .= "importScripts('".esc_attr($url.'pwa-sw.js')."')".PHP_EOL;
        $content .= "importScripts('https://cdn.onesignal.com/sdks/OneSignalSDKWorker.js')".PHP_EOL;
                                
        $status = pwaforwp_write_a_file($onesignal_sdk, $content);
        $status = pwaforwp_write_a_file($onesignal_sdk_updator, $content);
       
        return $status;
    
}