<?php

declare(strict_types=1);

namespace TheFrosty\WpUtilities\WpAdmin\Roles;

/**
 * Class RoleManager
 * @package TheFrosty\WpUtilities\WpAdmin\Roles
 */
class RoleManager
{

    /**
     * @var string
     */
    public const ROLE_SUPER_ADMIN = 'super_admin';
    /**
     * @var string
     */
    public const WP_ROLE_ADMINISTRATOR = 'administrator';
    /**
     * @var string
     */
    public const WP_ROLE_AUTHOR = 'author';
    /**
     * @var string
     */
    public const WP_ROLE_CONTRIBUTOR = 'contributor';
    /**
     * @var string
     */
    public const WP_ROLE_EDITOR = 'editor';
    /**
     * @var string
     */
    public const WP_ROLE_SUBSCRIBER = 'subscriber';

    /**
     * Build the "Mapped Meta Caps" for any post type.
     * @param string $singular Post Type POST_TYPE
     * @param string $plural Post Type SLUG
     * @return string[]
     */
    public static function getAllMappedCaps(string $singular, string $plural): array
    {
        return [
            // Meta capabilities.
            "edit_$singular",
            "read_$singular",
            "delete_$singular",
            // Primitive capabilities used outside of map_meta_cap().
            "edit_$plural",
            "edit_others_$plural",
            "publish_$plural",
            "read_private_$plural",
            // Primitive capabilities used within map_meta_cap().
            'read',
            "delete_$plural",
            "delete_private_$plural",
            "delete_published_$plural",
            "delete_others_$plural",
            "edit_private_$plural",
            "edit_published_$plural",
            "create_$plural",
        ];
    }
}
