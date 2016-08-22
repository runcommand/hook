<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

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
$hook_command = function( $args, $assoc_args ) {
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
			if ( is_array( $callback['function'] ) && is_object( $callback['function'][0] ) ) {
				$callback['function'] = get_class( $callback['function'][0] ) . '->' . $callback['function'][1];
			} elseif ( is_array( $callback['function'] ) && method_exists( $callback['function'][0], $callback['function'][1] ) ) {
				$callback['function'] = $callback['function'][0] . '::' . $callback['function'][1];
			}

			$callbacks_output[] = array(
				'function'        => $callback['function'],
				'priority'        => $priority,
				'accepted_args'   => $callback['accepted_args'],
				);
		}
	}
	$callbacks_output = array_reverse( $callbacks_output );
	WP_CLI\Utils\format_items( $assoc_args['format'], $callbacks_output, array( 'function', 'priority', 'accepted_args' ) );
};

WP_CLI::add_command( 'hook', $hook_command );
