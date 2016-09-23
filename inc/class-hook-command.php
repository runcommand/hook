<?php

namespace runcommand;

use WP_CLI;
use WP_CLI\Utils;

class Hook_Command {

	/**
	 * List callbacks registered to a given action or filter.
	 *
	 * ```
	 * wp hook wp_enqueue_scripts
	 * +---------------------------------------------+----------+---------------+
	 * | function                                    | priority | accepted_args |
	 * +---------------------------------------------+----------+---------------+
	 * | simpleDownloadManager->sdm_frontend_scripts | 10       | 1             |
	 * | biker_enqueue_styles                        | 10       | 1             |
	 * | jolene_scripts_styles                       | 10       | 1             |
	 * | rest_register_scripts                       | -100     | 1             |
	 * +---------------------------------------------+----------+---------------+
	 * ```
	 * ## OPTIONS
	 *
	 * <hook>
	 * : The name of the action or filter.
	 *
	 * [--format=<format>]
	 * : List callbacks as a table, JSON, CSV, or YAML.
	 * ---
	 * default: table
	 * options:
	 *   - table
	 *   - json
	 *   - csv
	 *   - yaml
	 * ---
	 */
	public function __invoke( $args, $assoc_args ) {
		global $wp_filter;

		$assoc_args = array_merge( array(
			'format'        => 'table',
			), $assoc_args );

		$hook = $args[0];
		if ( ! isset( $wp_filter[ $hook ] ) ) {
			WP_CLI::error( "No callbacks specified for {$hook}." );
		}

		$callbacks_output = array();
		foreach( $wp_filter[ $hook ] as $priority => $callbacks ) {
			foreach( $callbacks as $callback ) {
				list( $name, $location ) = self::get_name_location_from_callback( $callback['function'] );

				$callbacks_output[] = array(
					'callback'        => $name,
					'location'        => $location,
					'priority'        => $priority,
					'accepted_args'   => $callback['accepted_args'],
					);
			}
		}
		$callbacks_output = array_reverse( $callbacks_output );
		Utils\format_items( $assoc_args['format'], $callbacks_output, array( 'callback', 'location', 'priority', 'accepted_args' ) );
	}

	/**
	 * Get a human-readable name from a callback
	 */
	private static function get_name_location_from_callback( $callback ) {
		$name = $location = '';
		$reflection = false;
		if ( is_array( $callback ) && is_object( $callback[0] ) ) {
			$reflection = new \ReflectionMethod( $callback[0], $callback[1] );
			$name = get_class( $callback[0] ) . '->' . $callback[1] . '()';
		} elseif ( is_array( $callback ) && method_exists( $callback[0], $callback[1] ) ) {
			$reflection = new \ReflectionMethod( $callback[0], $callback[1] );
			$name = $callback[0] . '::' . $callback[1] . '()';
		} elseif ( is_object( $callback ) && is_a( $callback, 'Closure' ) ) {
			$reflection = new \ReflectionFunction( $callback );
			$name = 'function(){}';
		} else if ( is_string( $callback ) ) {
			$reflection = new \ReflectionFunction( $callback );
			$name = $callback . '()';
		}
		if ( $reflection ) {
			$location = $reflection->getFileName() . ':' . $reflection->getStartLine();
			if ( 0 === stripos( $location, WP_PLUGIN_DIR ) ) {
				$location = str_replace( trailingslashit( WP_PLUGIN_DIR ), '', $location );
			} else if ( 0 === stripos( $location, get_theme_root() ) ) {
				$location = str_replace( trailingslashit( get_theme_root() ), '', $location );
			} else if ( 0 === stripos( $location, ABSPATH . 'wp-admin/' ) ) {
				$location = str_replace( ABSPATH, '', $location );
			} else if ( 0 === stripos( $location, ABSPATH . 'wp-includes/' ) ) {
				$location = str_replace( ABSPATH, '', $location );
			}
		}
		return array( $name, $location );
	}

}
