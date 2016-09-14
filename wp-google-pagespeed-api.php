<?php
/**
 * WP Google PageSpeed API
 *
 * @package WP-Google-PageSpeed-API
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Check if class exists. */
if ( ! class_exists( 'GooglePageSpeedAPI' ) ) {

	/**
	 * CodeClimateAPI class.
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

			$request . = '?key=' . static::$api_key;

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
		 * @param mixed $url
		 * @param mixed $filter_third_party_resources
		 * @param mixed $locale
		 * @param mixed $rule
		 * @param mixed $screenshot
		 * @param mixed $strategy
		 * @return void
		 */
		public function run_pagespeed( $url, $filter_third_party_resources, $locale, $rule, $screenshot, $strategy ) {

			if ( empty( $url ) ) {
				return new WP_Error( 'required-fields', __( 'Required fields are empty.', 'text-domain' ) );
			}

			$request = $this->base_uri . '?url=' . $url;

			return $this->fetch( $request );

		}

	}
}
