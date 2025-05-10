<?php
/**
 * Enable Standard PayPal for WooCommerce
 *
 * @since             1.0.0
 * @package           Enable_Standard_PayPal_for_WooCommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Enable Standard PayPal for WooCommerce
 * Plugin URI:        http://vikcheema.com/enable-standard-paypal-for-woocommerce
 * Description:       Enables the classic PayPal Standard payment method for WooCommerce, which has been disabled by default since WooCommerce version 5.5.0.
 * Version:           1.0.2
 * Author:            Vik Cheema
 * Author URI:        http://vikcheema.com
 * Text Domain:       enable-standard-paypal-for-woocommerce
 * WC requires at least: 5.5.0
 * WC tested up to:   9.8.3
 */

 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 }

 /**
  * Let all the plugins load first
  **/
 add_action ('plugins_loaded', 'espw_check_plugins_loaded');

 function espw_check_plugins_loaded () {

     /**
      * Check if WooCommerce is active
      **/
     if ( class_exists( 'WooCommerce' ) ) {

    	/*
    	* Check WooCommerce version, 5.5.0 required at least
    	*/
    	if ( version_compare( WC_VERSION, '5.5.0', '>=' ) ) {

				/*
				* declare Compatibility with HPOS
				*/
				add_action( 'before_woocommerce_init', function() {
					if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
							\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
									'custom_order_tables',
									__FILE__,
									true 
							);
					}
				} );

				// It enable PayPal Standard for WooCommerce.
				$paypal = class_exists( 'WC_Gateway_Paypal' ) ? new WC_Gateway_Paypal() : null;
				if( $paypal ) {
					$paypal->update_option( '_should_load', 'yes' );
				}
    		/**
    		* Add the filter to enable the hidden standard paypal for WooCommerce
    		*/
    		add_filter( 'woocommerce_should_load_paypal_standard', 'espw_load_paypal_stadard', 99999, 2 );

    	}
     }
 }

 /**
 * return true to enable the gateway
 */
 function espw_load_paypal_stadard( $should_load, $instance ) {
    $should_load = true;
    return $should_load;
 }
