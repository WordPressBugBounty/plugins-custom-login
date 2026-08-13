<?php

declare(strict_types=1);

namespace TheFrosty\WpUtilities\PostMeta;

use TheFrosty\WpUtilities\Plugin\AbstractHookProvider;
use TheFrosty\WpUtilities\Plugin\HttpFoundationRequestInterface;
use TheFrosty\WpUtilities\Plugin\HttpFoundationRequestTrait;
use WP_Post;

/**
 * Class AbstractManager
 * @package TheFrosty\WpUtilities\PostMeta
 */
abstract class AbstractManager extends AbstractHookProvider implements HttpFoundationRequestInterface
{

    /**
     * @var array|null
     */
    protected ?array $fields = null;
    /**
     * @var string
     */
    protected string $type = 'post';
    use HttpFoundationRequestTrait;

    protected WP_Post $post;

    /**
     * AbstractManager constructor.
     * @param array|null $fields
     * @param string $type
     */
    public function __construct(?array $fields = null, string $type = 'post')
    {
        $this->fields = $fields;
        $this->type = $type;
        $this->fields ??= FieldsRegistrar::all($type);
    }

    public function addHooks(): void
    {
        // Verify we have fields, and the current type is supported (@todo add additional type support).
        if (empty($this->fields) || $this->type !== 'post') {
            return;
        }
        $this->addAction("add_meta_boxes_$this->type", [$this, 'addMetaBox']);
        $this->addAction("save_post_$this->type", [$this, 'save'], 10, 2);
    }

    abstract protected function addMetaBox(WP_Post $post): void;

    abstract protected function save(int $post_id, WP_Post $post): void;
}
