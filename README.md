# WP-Nonce made with OOP

Replacing WordPress functional wp_nonce_* implementations with classes / objects.

## Setup / Usage / How to

Install this library where you want to use it:

    composer require "sourcerer-mike/wp-nonce"

### WP Nonce in OOP

The `wp_create_nonce` is represented by the `SourcererMike\WP_Nonce\Nonce`:

	$context = new Nonce( 'some-action' );
	
	// get the current nonce
	echo (string) $context;

The `wp_nonce_url` is represented by the `SourcererMike\WP_Nonce\Url`:

	$url = new \SourcererMike\WP_Nonce\Url( 'http://the.url', 'an-action', '_nonce_id' );
	$url->get_nonce_url(); // Now you receive an URL like "http://the.url?action=an-action&_nonce_id=feb1337b1a"

## Customize / Additional


## FAQ / Contact / Troubleshoot

Tweet me and ask any question you like: [https://twitter.com/ScreamingDev](@ScreamingDev)