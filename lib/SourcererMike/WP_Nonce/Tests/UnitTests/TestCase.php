<?php

namespace SourcererMike\WP_Nonce\Tests\UnitTests;


use Mockery;

class TestCase extends \PHPUnit\Framework\TestCase {
	/**
	 * @var \Mockery\MockInterface
	 */
	public static $functions;

	protected function setUp() {
		parent::setUp();

		static::$functions = Mockery::mock();
	}

	protected function tearDown() {
		Mockery::close();

		parent::tearDown();
	}


}