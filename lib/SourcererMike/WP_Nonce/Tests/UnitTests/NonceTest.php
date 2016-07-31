<?php

namespace SourcererMike\WP_Nonce {

	use SourcererMike\WP_Nonce\Tests\UnitTests\NonceTest;

	function wp_nonce_tick() {
		NonceTest::$functions->wp_nonce_tick();

		return 1337;
	}

	function wp_get_session_token() {
		NonceTest::$functions->wp_get_session_token();

		return 'wp_get_session_token';
	}

	function wp_hash( $data, $scheme ) {
		NonceTest::$functions->wp_hash( $data, $scheme );

		return md5( 'wp_hash' );
	}

	function wp_get_current_user() {
		NonceTest::$functions->wp_get_current_user();

		return NonceTest::$user;
	}

	function apply_filters() {
		return NonceTest::$functions->apply_filters();
	}
}

namespace SourcererMike\WP_Nonce\Tests\UnitTests {

	use SourcererMike\WP_Nonce\Nonce;

	class NonceTest extends TestCase {
		public static $user;

		public function testItDeterminesTheCurrentUser() {
			static::$user     = new \stdClass();
			static::$user->ID = 42;

			$method = new \ReflectionMethod( Nonce::class, 'get_uid' );
			$method->setAccessible( true );

			$nonce = new Nonce( 'action' );

			static::$functions->shouldReceive( 'wp_get_current_user' );
			$this->assertEquals( 42, $method->invoke( $nonce ) );
		}

		public function testItRecognizesGuests() {
			static::$user     = new \stdClass();
			static::$user->ID = 0;

			$nonce = new Nonce( 'action' );

			static::$functions->shouldReceive( 'wp_get_current_user' );
			static::$functions->shouldReceive( 'apply_filters' )->once()->andReturn(1337);

			$method = new \ReflectionMethod( Nonce::class, 'get_uid' );
			$method->setAccessible( true );

			$this->assertEquals( 1337, $method->invoke( $nonce ) );
		}

		public function testItGeneratesANonce() {
			$nonce = new Nonce( 'some-action' );

			$mock = $this->getMockBuilder( Nonce::class )
			             ->setConstructorArgs( [ 'some-action' ] )
			             ->setMethods( [ 'get_uid' ] )
			             ->getMock();

			$mock->expects( $this->once() )->method( 'get_uid' )->willReturn( 1 );

			static::$functions->shouldReceive( 'wp_nonce_tick' )->once();
			static::$functions->shouldReceive( 'wp_get_session_token' )->once();

			static::$functions->shouldReceive( 'wp_hash' )->once();

			$mock->__toString();
		}
	}
}