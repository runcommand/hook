Feature: List callbacks registered to a given action or filter.

  Scenario: Invalid hook
    Given a WP install

    When I try `wp hook foobarinvalid`
    Then STDERR should be:
      """
      Error: No callbacks specified for 'foobarinvalid'.
      """

  Scenario: Hook command loads
    Given a WP install

    When I try `wp hook`
    Then STDOUT should contain:
      """
      usage: wp hook <hook> [--fields=<fields>] [--format=<format>]
      """

    When I run `wp hook init`
    Then STDOUT should be a table containing rows:
      | callback                   | location                   | priority  | accepted_args |
      | check_theme_switched()     | wp-includes/theme.php:2030 | 99        | 1             |

  Scenario: Filter output to specific fields
    Given a WP install

    When I run `wp hook init --fields=callback,priority`
    Then STDOUT should be a table containing rows:
      | callback                   | priority  |
      | check_theme_switched()     | 99        |

  Scenario: Truncate paths to mu-plugins
    Given a WP install
    And a wp-content/mu-plugins/custom-action.php file:
      """
      <?php
      function runcommand_custom_action_hook() {
        wp_cache_get( 'foo' );
      }
      add_action( 'runcommand_custom_action', 'runcommand_custom_action_hook' );
      """

    When I run `wp hook runcommand_custom_action --fields=callback,location`
    Then STDOUT should be a table containing rows:
      | callback                        | location                       |
      | runcommand_custom_action_hook() | mu-plugins/custom-action.php:2 |
