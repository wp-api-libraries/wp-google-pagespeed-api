<?php
/**
 * WP Google PageSpeed API
 *
 * @package WP-Google-PageSpeed-API
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
	 * GooglePageSpeedAPI class.
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

			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'text-domain' ), $code ) );
			}

			$body = wp_remote_retrieve_body( $response );

			return json_decode( $body );

		}
		
		/**
		 * Perform PageSpeed.
		 *
		 * @access public
		 * @param mixed $url URL.
		 * @param mixed $filter_third_party_resources Filter Third Party Resources.
		 * @param mixed $locale Locale.
		 * @param mixed $rule Rule.
		 * @param mixed $screenshot Screenshot.
		 * @param mixed $strategy Strategy. 
		 * @return mixed PageSpeed Results.
		 */
		public function run_pagespeed(  $url, $filter_third_party_resources = '', $locale = '', $rule = '', $screenshot = '', $strategy = '' ) {

			if ( empty( $url ) ) {
				return new WP_Error( 'required-fields', __( 'Required fields are empty.', 'text-domain' ) );
			}

			$request = $this->base_uri . '?url=' . $url . '&key=' . static::$api_key;

			return $this->fetch( $request );

		}

	}
}
