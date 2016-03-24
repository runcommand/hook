runcommand/hook
===============

List callbacks registered to a given action or filter.

[![Build Status](https://travis-ci.org/runcommand/hook.svg?branch=master)](https://travis-ci.org/runcommand/hook)

Quick links: [Using](#using) | [Installing](#installing) | [Contributing](#contributing)

## Using


~~~
wp hook <hook> [--format=<format>]
~~~

**OPTIONS**

	<hook>
		The key for the action or filter.

	[--format=<format>]
		List callbacks as a table, JSON, or CSV. Default: table.



## Installing

Installing this package requires WP-CLI v0.23.0 or greater. Update to the latest stable release with `wp cli update`.

Once you've done so, you can install this package with `wp package install runcommand/hook`

## Contributing

Code and ideas are more than welcome.

Please [open an issue](https://github.com/runcommand/hook/issues) with questions, feedback, and violent dissent. Pull requests are expected to include test coverage.
