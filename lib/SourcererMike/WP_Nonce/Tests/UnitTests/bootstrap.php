<?php

namespace SourcererMike\WP_Nonce\Tests\PHPUnit;

require_once __DIR__ . '/../../../../../vendor/autoload.php';

function hashTestArgs( $args ) {
	return md5( serialize( (array) $args ) );
}