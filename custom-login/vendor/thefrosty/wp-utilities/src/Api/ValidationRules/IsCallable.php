<?php

declare(strict_types=1);

namespace TheFrosty\WpUtilities\Api\ValidationRules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use function is_callable;
use function sprintf;

/**
 * Class CallableRule
 * @package TheFrosty\WpUtilities\Api\Rules
 */
class IsCallable implements Rule
{

    protected array $parameters = [];
    protected string $field;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @param mixed $value
     */
    public function passes(string $field, $value, array $data): bool
    {
        $this->field = $field;

        return is_callable($value);
    }

    public function message(): string
    {
        return sprintf('The %s field must be callable.', $this->field);
    }
}
