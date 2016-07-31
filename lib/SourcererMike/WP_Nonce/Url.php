<?php


namespace SourcererMike\WP_Nonce;


class Url {
	protected $action;
	protected $action_url;
	protected $name;

	/**
	 * Url constructor.
	 *
	 * @param string $action_url URL to add nonce action.
	 * @param int    $action     Optional. Nonce action name. Default -1.
	 * @param string $name       Optional. Nonce name. Default '_wpnonce'.
	 */
	public function __construct( $action_url, $action = - 1, $name = '_wpnonce' ) {
		$this->action_url = $action_url;
		$this->action     = $action;
		$this->name       = $name;
	}

	/**
	 * Turn object into a string by returning the URL with nonce.
	 *
	 * @return string Escaped URL with nonce action added.
	 */
	public function __toString() {
		return $this->get_nonce_url();
	}

	/**
	 * Add nonce to URL.
	 *
	 * @return string
	 */
	public function get_nonce_url() {
		return (string) esc_html(
			add_query_arg( $this->get_name(), wp_create_nonce( $this->get_action() ), $this->get_action_url() )
		);
	}

	/**
	 * Get name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * URL to add nonce action.
	 *
	 * @return mixed
	 */
	public function get_action() {
		return $this->action;
	}

	/**
	 * Get sanitized URL.
	 *
	 * The given URL will be sanitized by turning all "&amp;" into "&".
	 *
	 * @return string
	 */
	public function get_action_url() {
		return str_replace( '&amp;', '&', $this->get_raw_action_url() );
	}

	public function get_raw_action_url() {
		return $this->action_url;
	}
}
