<?php

declare(strict_types=1);

namespace TheFrosty\WpUtilities\WpAdmin;

use TheFrosty\WpUtilities\Plugin\HooksTrait;
use TheFrosty\WpUtilities\Plugin\Plugin;
use TheFrosty\WpUtilities\Plugin\WpHooksInterface;
use TheFrosty\WpUtilities\Utils\View;
use TheFrosty\WpUtilities\WpAdmin\Dashboard\Widget;
use function apply_filters;
use function sanitize_key;
use function sprintf;
use function wp_add_dashboard_widget;

/**
 * Class DashboardWidget
 * @package TheFrosty\WpUtilities\WpAdmin
 */
class DashboardWidget implements WpHooksInterface
{

    use HooksTrait;

    /**
     * @var string
     */
    public const HOOK_NAME_ALLOWED_S = Plugin::TAG . '/%s/dashboard_allowed';
    /**
     * @var string
     */
    public const HOOK_NAME_RENDER = Plugin::TAG . '/render/dashboard_widget';


    /** @var Widget $widget */
    private Widget $widget;

    /**
     * DashboardWidget constructor.
     * @param array $args
     */
    public function __construct(array $args)
    {
        $this->setWidget($args);
    }

    /**
     * Add class hooks.
     */
    public function addHooks(): void
    {
        $this->addAction('load-index.php', [$this, 'loadIndexPhp']);
    }

    /**
     * Load additional hooks for this class.
     */
    protected function loadIndexPhp(): void
    {
        $this->addAction('wp_dashboard_setup', [$this, 'addDashboardWidget']);
    }

    /**
     * Add Dashboard widget
     */
    protected function addDashboardWidget(): void
    {
        if (!$this->isDashboardAllowed()) {
            return;
        }

        wp_add_dashboard_widget(
            $this->getWidget()->getWidgetId(),
            $this->getWidget()->getWidgetName(),
            function (): void {
                (new View())->render(
                    'dashboard-widget.php',
                    [
                        'instance' => $this,
                        'widgetId' => $this->getWidget()->getWidgetId(),
                    ]
                );
            }
        );
    }

    /**
     * Return the current Widget object.
     * @return Widget
     */
    public function getWidget(): Widget
    {
        return $this->widget;
    }

    /**
     * Creates in new instance of the Widget object.
     * @param array $args
     */
    private function setWidget(array $args): void
    {
        $this->widget = new Widget($args);
    }

    /**
     * Check if the dashboard widget is allowed.
     * @return bool
     */
    private function isDashboardAllowed(): bool
    {
        $allowed = apply_filters(
            sprintf(
                self::HOOK_NAME_ALLOWED_S,
                sanitize_key($this->getWidget()->getWidgetId())
            ),
            true
        );

        return $allowed === true;
    }
}
