<?php
/**
 * WP Google PageSpeed API
 *
 * @package WP-API-Libraries\WP-Google-PageSpeed-API
 */

/*
* Plugin Name: WP Google PageSpeed API
* Plugin URI: https://github.com/wp-api-libraries/wp-google-pagespeed-api
* Description: Perform API requests to Google Page Speed in WordPress.
* Author: WP API Libraries
* Version: 1.0.0
* Author URI: https://wp-api-libraries.com/
* GitHub Plugin URI: https://github.com/wp-api-libraries/wp-google-pagespeed-api
* GitHub Branch: master
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Check if class exists. */
if ( ! class_exists( 'GooglePageSpeedAPI' ) ) {

	/**
	 * A WordPress API library for using the Google PageSpeed API.
	 *
	 * @link https://developers.google.com/speed/docs/insights/v2/reference/ Documentation
	 * @see https://wp-api-libraries.com/ WP API Libraries
	 * @package WP-API-Libraries\WP-Google-PageSpeed-API
	 * @author imFORZA <https://github.com/imforza>
	 */
	class GooglePageSpeedAPI {

		 /**
		  * API Key.
		  *
		  * @var string
		  */
		static private $api_key;

		 /**
		  * URL to the API.
		  *
		  * @var string
		  */
		private $base_uri = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed';

		/**
		 * __construct function.
		 *
		 * @access public
		 * @param mixed $api_key API Key.
		 * @return void
		 */
		public function __construct( $api_key ) {
			static::$api_key = $api_key;
		}

		 /**
		  * Fetch the request from the API.
		  *
		  * @access private
		  * @param mixed $request Request URL.
		  * @return $body Body.
		  */
		private function fetch( $request ) {

			$response = wp_remote_get( $request );
			$code = wp_remote_retrieve_response_code( $response );
			$body = json_decode( wp_remote_retrieve_body( $response ) );

			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Status: %d', 'text-domain' ), $code ), $body );
			}

			return $body;

		}

		/**
		 * Runs PageSpeed analysis on the page at the specified URL, and returns PageSpeed scores, a list of suggestions to
		 * make that page faster, and other information.
		 *
		 * @api GET
		 * @see https://developers.google.com/speed/docs/insights/v2/reference/pagespeedapi/runpagespeed Documentation
		 * @access public
		 * @param string  $url                The URL to fetch and analyze.
		 * @param boolean $filter_third_party Indicates if third party resources should be filtered out before PageSpeed
		 *                                    analysis. (Default: false).
		 * @param string  $locale 	          The locale used to localize formatted results.
		 * @param string  $rule               A PageSpeed rule to run; if none are given, all rules are run.
		 * @param boolean $screenshot 	      Indicates if binary data containing a screenshot should be included (Default: false).
		 * @param string  $strategy           The analysis strategy to use. Accepted values: desktop, mobile.
		 * @return array                      PageSpeed Results.
		 */
		public function run_pagespeed( $url, $filter_third_party = '', $locale = '', $rule = '', $screenshot = '', $strategy = '' ) {

			if ( empty( $url ) ) {
				return new WP_Error( 'required-fields', __( 'Required fields are empty.', 'text-domain' ) );
			}

			$args['key']  = static::$api_key;
			$args['url']  = $url;
			if ( '' !== $filter_third_party ) {
				$args['filter_third_party_resources']  = $filter_third_party;
			}
			if ( '' !== $locale ) {
				$args['locale']  = $locale;
			}
			if ( '' !== $rule ) {
				$args['rule']  = $rule;
			}
			if ( '' !== $screenshot ) {
				$args['screenshot']  = $screenshot;
			}
			if ( '' !== $strategy ) {
				$args['strategy']  = $strategy;
			}

			$request = add_query_arg( $args, $this->base_uri );

			return $this->fetch( $request );

		}

	}
}
