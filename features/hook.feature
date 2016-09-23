Feature: List callbacks registered to a given action or filter.

  Scenario: Hook command loads
    Given a WP install

    When I try `wp hook`
    Then STDOUT should contain:
      """
      usage: wp hook <hook> [--format=<format>]
      """

    When I run `wp hook init`
    Then STDOUT should be a table containing rows:
      | callback                   | location                   | priority  | accepted_args |
      | check_theme_switched()     | wp-includes/theme.php:2030 | 99        | 1             |
