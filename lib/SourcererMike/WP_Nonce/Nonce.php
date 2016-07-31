<?php


namespace SourcererMike\WP_Nonce;


class Nonce {
	private $action;

	public function __construct( $action ) {
		$this->action = $action;
	}

	public function __toString() {
		$hash = wp_hash(
			wp_nonce_tick() . '|' . $this->get_action() . '|' . $this->get_uid() . '|' . wp_get_session_token(),
			'nonce'
		);

		return (string) substr( $hash, - 12, 10 );
	}

	/**
	 * Get the action.
	 *
	 * @return string
	 */
	public function get_action() {
		return (string) $this->action;
	}

	/**
	 * Get the ID of the current user.
	 *
	 * @return int
	 */
	protected function get_uid() {
		$user = wp_get_current_user();

		$uid = 0;
		if ( $user ) {
			$uid = (int) $user->ID;
		}

		if ( ! $uid ) {
			/** This filter is documented in wp-includes/pluggable.php */
			return apply_filters( 'nonce_user_logged_out', $uid, $this->get_action() );
		}

		return $uid;
	}
}
