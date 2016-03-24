Feature: List callbacks registered to a given action or filter.

  Scenario: Hook command loads
    Given a WP install

    When I try `wp hook`
    Then STDOUT should contain:
      """
      usage: wp hook <hook> [--format=<format>]
      """

    When I run `wp hook init`
    Then STDOUT should not be empty
