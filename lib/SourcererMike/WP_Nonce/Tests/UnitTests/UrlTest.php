<?php

namespace SourcererMike\WP_Nonce {

	use SourcererMike\WP_Nonce\Tests\UnitTests\UrlTest;

	function esc_html( $string ) {
		UrlTest::$functions->esc_html( $string );

		return \SourcererMike\WP_Nonce\Tests\PHPUnit\hashTestArgs( func_get_args() );
	}

	/**
	 * @param string|array $key   Either a query variable key, or an associative array of query variables.
	 * @param string       $value Optional. Either a query variable value, or a URL to act upon.
	 * @param string       $url   Optional. A URL to act upon.
	 *
	 * @return mixed
	 */
	function add_query_arg( $key, $value = null, $url = null ) {
		UrlTest::$functions->add_query_arg( $key, $value, $url );

		return \SourcererMike\WP_Nonce\Tests\PHPUnit\hashTestArgs( func_get_args() );
	}

	function wp_create_nonce( $string ) {
		// notify
		UrlTest::$functions->wp_create_nonce( $string );

		return \SourcererMike\WP_Nonce\Tests\PHPUnit\hashTestArgs( func_get_args() );
	}

}

namespace SourcererMike\WP_Nonce\Tests\UnitTests {

	use SourcererMike\WP_Nonce\Url;

	class UrlTest extends TestCase {
		public function get_create_nonce_data() {
			return [
				[ 'action_url', - 1, '_wpnonce' ],
				[ 'action_url', - 1, '_wpnomnom' ],
				[ '/wp-login.php?logout=1', 'log-out', '_wpnonce' ],
			];
		}

		public function testItCanBeConvertedToString() {
			$url = new Url( 'something something', 'aaaand action', '_wpnomnomnom' );

			static::$functions->shouldReceive( 'action_url' );
			static::$functions->shouldReceive( 'add_query_arg' );
			static::$functions->shouldReceive( 'esc_html' );
			static::$functions->shouldReceive( 'wp_create_nonce' );

			$this->assertEquals( $url->get_nonce_url(), (string) $url );
		}

		/**
		 *
		 * @param string $action_url
		 * @param string $action
		 * @param string $name
		 *
		 * @dataProvider get_create_nonce_data
		 */
		public function testItGeneratesAnUrlWithNonce( $action_url, $action, $name ) {
			$url = new Url( $action_url, $action, $name );

			// Asserting wp_create_nonce( action ) makes the nonce for us
			static::$functions->shouldReceive( 'wp_create_nonce' )->with( $action )->once();

			// Asserting that add_query_arg is used.
			static::$functions->shouldReceive( 'add_query_arg' )
			                  ->with(
				                  $name,
				                  \SourcererMike\WP_Nonce\Tests\PHPUnit\hashTestArgs( $action ),
				                  $action_url
			                  )
			                  ->once();

			// Asserting esc_html is used
			static::$functions->shouldReceive( 'esc_html' )->once();

			$url->__toString();
		}

		/**
		 * ItHasSetterForAllArguments.
		 *
		 * @dataProvider get_create_nonce_data
		 */
		public function testItHasSetterForAllArguments( $action_url, $action, $name ) {
			$url = new Url( $action_url, $action, $name );

			$this->assertEquals( $action_url, $url->get_raw_action_url() );
			$this->assertEquals( $action, $url->get_action() );
			$this->assertEquals( $name, $url->get_name() );
		}
	}

}
