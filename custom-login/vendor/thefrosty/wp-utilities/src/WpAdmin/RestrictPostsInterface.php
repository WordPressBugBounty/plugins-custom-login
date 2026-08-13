<?php

declare(strict_types=1);

namespace TheFrosty\WpUtilities\WpAdmin;

use TheFrosty\WpUtilities\Plugin\Plugin;

/**
 * Interface RestrictPostsInterface
 * @package TheFrosty\WpUtilities\WpAdmin
 */
interface RestrictPostsInterface
{

    /**
     * @var string
     */
    public const ADMIN_FILTER_FIELD_NAME = '_filter_meta_key';
    /**
     * @var string
     */
    public const ADMIN_FILTER_FIELD_VALUE = '_filter_meta_value';
    /**
     * @var string
     */
    public const ADMIN_SEARCH_FIELD_VALUE = '_search_meta_value';
    /**
     * @var string
     */
    public const HANDLE = 'restrict-manage-posts';
    /**
     * @var string
     */
    public const HANDLE_UTILITY_FUNCTIONS = 'utility-functions';
    /**
     * @var string
     */
    public const TAG_FILTER_ADVANCED_SEARCH = Plugin::TAG . '/restrict_manage_posts/advanced_search';
    /**
     * @var string
     */
    public const TAG_FILTER_ENABLE_SCRIPTS = Plugin::TAG . '/restrict_manage_posts/enable_scripts';

    /**
     * @var string
     */
    public const TAG_FILTER_META_KEYS = Plugin::TAG . '/restrict_manage_posts/meta_keys';
    /**
     * @var string
     */
    public const TAG_FILTER_META_VALUES = Plugin::TAG . '/restrict_manage_posts/meta_values';
    /**
     * @var string
     */
    public const TAG_FILTER_SCRIPT_DEPENDENCIES = Plugin::TAG . '/restrict_manage_posts/script_dependencies';
}
