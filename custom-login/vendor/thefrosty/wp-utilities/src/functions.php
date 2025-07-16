<?php

declare(strict_types=1);

namespace TheFrosty\WpUtilities;

use Symfony\Component\HttpFoundation\Request;
use function filter_var;
use function get_bloginfo;
use function is_array;
use function sanitize_text_field;
use function version_compare;
use function wp_enqueue_script;
use function wp_register_script;
use const FILTER_FLAG_IPV4;
use const FILTER_FLAG_IPV6;
use const FILTER_VALIDATE_IP;

/**
 * Get the clients IP.
 * @ref https://dev.to/rogeriotaques/an-easy-way-to-get-the-real-client-ip-in-php-4pii
 * @param Request|null $request
 * @return string|null
 */
function getIpAddress(?Request $request = null): ?string
{
    $request ??= Request::createFromGlobals();

    $ip = $request->server->get(
        'HTTP_CLIENT_IP',
        $request->server->get(
            'HTTP_CF_CONNECTING_IP',
            $request->server->get(
                'HTTP_X_FORWARDED',
                $request->server->get(
                    'HTTP_X_FORWARDED_FOR',
                    $request->server->get(
                        'HTTP_FORWARDED',
                        $request->server->get(
                            'HTTP_FORWARDED_FOR',
                            $request->server->get('REMOTE_ADDR')
                        )
                    )
                )
            )
        )
    );

    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {
        return null;
    }

    return sanitize_text_field($ip);
}

/**
 * 6.3.0 Stub for PHP 8.0+.
 * Registers a new script.
 * Registers a script to be enqueued later using the wp_enqueue_script() function.
 * @param string $handle Name of the script. Should be unique.
 * @param string|false $src Full URL of the script, or path of the script relative to the WordPress root directory.
 *                                    If source is set to false, script is an alias of other scripts it depends on.
 * @param string[] $deps Optional. An array of registered script handles this script depends on. Default empty array.
 * @param mixed $ver Optional. String specifying script version number, if it has one, which is added to
 *     the URL as a query string for cache busting purposes. If version is set to false, a version number is
 *     automatically added equal to current installed WordPress version. If set to null, no version is added.
 * @param array|bool $args {
 *      Optional. An array of additional script loading strategies. Default empty array.
 *      Otherwise, it may be a boolean in which case it determines whether the script is printed in the footer. Default
 *     false.
 * @type string $strategy Optional. If provided, may be either 'defer' or 'async'.
 * @type bool $in_footer Optional. Whether to print the script in the footer. Default 'false'.
 * }
 * @return bool Whether the script has been registered. True on success, false on failure.
 * @see WP_Dependencies::add()
 * @see WP_Dependencies::add_data()
 * @since 2.1.0
 * @since 4.3.0 A return value was added.
 * @since 6.3.0 The $in_footer parameter of type boolean was overloaded to be an $args parameter of type array.
 * @see WP_Dependencies::add()
 * @see WP_Dependencies::add_data()
 * @since 2.1.0
 * @since 4.3.0 A return value was added.
 * @since 6.3.0 The $in_footer parameter of type boolean was overloaded to be an $args parameter of type array.
 */
function wpRegisterScript(
    string $handle,
    $src,
    array $deps = [],
    $ver = false,
    $args = []
): bool {
    if (!is_array($args)) {
        $args = [
            'in_footer' => $args,
        ];
    }

    if (version_compare(get_bloginfo('version'), '6.3') >= 0) {
        return wp_register_script($handle, $src, $deps, $ver, $args);
    }

    return wp_register_script($handle, $src, $deps, $ver, $args['in_footer']);
}

/**
 * 6.3.0 Stub for PHP 8.0+.
 * Enqueues a script.
 * Registers the script if $src provided (does NOT overwrite), and enqueues it.
 * @param string $handle Name of the script. Should be unique.
 * @param string|false $src Full URL of the script, or path of the script relative to the WordPress root directory.
 *                                    Default empty.
 * @param string[] $deps Optional. An array of registered script handles this script depends on. Default empty array.
 * @param mixed $ver Optional. String specifying script version number, if it has one, which is added to
 *     the URL as a query string for cache busting purposes. If version is set to false, a version number is
 *     automatically added equal to current installed WordPress version. If set to null, no version is added.
 * @param array|bool $args {
 *      Optional. An array of additional script loading strategies. Default empty array.
 *      Otherwise, it may be a boolean in which case it determines whether the script is printed in the footer. Default
 *     false.
 * @see WP_Dependencies::add()
 * @see WP_Dependencies::add_data()
 * @see WP_Dependencies::enqueue()
 * @since 2.1.0
 * @since 6.3.0 The $in_footer parameter of type boolean was overloaded to be an $args parameter of type array.
 */
function wpEnqueueScript(
    string $handle,
    $src = '',
    array $deps = [],
    $ver = false,
    $args = []
): void {
    if (!is_array($args)) {
        $args = [
            'in_footer' => $args,
        ];
    }

    if (version_compare(get_bloginfo('version'), '6.3') >= 0) {
        wp_enqueue_script($handle, $src, $deps, $ver, $args);

        return;
    }

    wp_enqueue_script($handle, $src, $deps, $ver, $args['in_footer']);
}
