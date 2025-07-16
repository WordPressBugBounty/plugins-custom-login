<?php

declare(strict_types=1);

namespace TheFrosty\WpUtilities\Api\Shortcode;

use TheFrosty\WpUtilities\Api\Shortcode\Handler\HandlerInterface;

/**
 * AbstractShortcode class
 * @package TheFrosty\WpUtilities\Api\Shortcode
 */
abstract class AbstractShortcode implements ShortcodeInterface
{

    /**
     * @var string
     */
    protected string $tag;
    /**
     * @var HandlerInterface
     */
    protected HandlerInterface $handler;
    /**
     * AbstractShortcode constructor.
     * @param string $tag
     * @param HandlerInterface $handler
     */
    public function __construct(string $tag, HandlerInterface $handler)
    {
        $this->tag = $tag;
        $this->handler = $handler;
        $this->handler->setTag($tag);
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getHandler(): HandlerInterface
    {
        return $this->handler;
    }
}
