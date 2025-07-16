<?php

declare(strict_types=1);

namespace TheFrosty\WpUtilities\Api\Shortcode;

use TheFrosty\WpUtilities\Api\Shortcode\Handler\HandlerInterface;

/**
 * Interface ShortcodeInterface
 * @package TheFrosty\WpUtilities\Api\Shortcode
 */
interface ShortcodeInterface
{

    /**
     * ShortcodeInterface constructor.
     * @param string $tag
     * @param HandlerInterface $handler
     */
    public function __construct(string $tag, HandlerInterface $handler);

    /**
     * Returns the tag aka name for the shortcode.
     * @return string
     */
    public function getTag(): string;

    /**
     * Returns the HandlerInterface object that displays the html for a shortcode.
     * @return HandlerInterface
     */
    public function getHandler(): HandlerInterface;
}
