runcommand/hook
===============

List callbacks registered to a given action or filter.

[![Build Status](https://travis-ci.org/runcommand/hook.svg?branch=master)](https://travis-ci.org/runcommand/hook)

Quick links: [Using](#using) | [Installing](#installing) | [Support](#support)

## Using

~~~
wp hook <hook> [--fields=<fields>] [--format=<format>]
~~~

```
wp hook wp_enqueue_scripts --fields=callback,location
+------------------------------------------------+---------------------------------------------+
| callback                                       | location                                    |
+------------------------------------------------+---------------------------------------------+
| wp_localize_jquery_ui_datepicker()             | wp-includes/script-loader.php:928           |
| rest_register_scripts()                        | runcommand-theme/lib/rest-api/extras.php:22 |
| runcommand\Assets->action_wp_enqueue_scripts() | runcommand-theme/inc/class-assets.php:21    |
+------------------------------------------------+---------------------------------------------+
```
**OPTIONS**

	<hook>
		The name of the action or filter.

	[--fields=<fields>]
		Limit the output to specific fields. Defaults to all fields.

	[--format=<format>]
		List callbacks as a table, JSON, CSV, or YAML.
		---
		default: table
		options:
		  - table
		  - json
		  - csv
		  - yaml
		---

**AVAILABLE FIELDS**

These fields are displayed by default for each callback:

* callback - a human-friendly name for the callback
* location - where the callback is defined in the codebase
* priority - order in which the callback will be executed
* accepted_args - number of arguments to be passed to the callback

## Installing

Installing this package requires WP-CLI v0.23.0 or greater. Update to the latest stable release with `wp cli update`.

Once you've done so, you can install this package with `wp package install runcommand/hook`.

## Support

This package is free for anyone to use. Support is available to paying [runcommand](https://runcommand.io/) customers.

Think you’ve found a bug? Before you create a new issue, you should [search existing issues](https://github.com/runcommand/sparks/issues?q=label%3Abug%20) to see if there’s an existing resolution to it, or if it’s already been fixed in a newer version. Once you’ve done a bit of searching and discovered there isn’t an open or fixed issue for your bug, please [create a new issue](https://github.com/runcommand/sparks/issues/new) with description of what you were doing, what you saw, and what you expected to see.

Want to contribute a new feature? Please first [open a new issue](https://github.com/runcommand/sparks/issues/new) to discuss whether the feature is a good fit for the project. Once you've decided to work on a pull request, please include [functional tests](https://wp-cli.org/docs/pull-requests/#functional-tests) and follow the [WordPress Coding Standards](http://make.wordpress.org/core/handbook/coding-standards/).

Github issues are meant for tracking bugs and enhancements. For general support, email [support@runcommand.io](mailto:support@runcommand.io).


