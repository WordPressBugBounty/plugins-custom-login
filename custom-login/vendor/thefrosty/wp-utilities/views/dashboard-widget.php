<?php

declare(strict_types=1);

use TheFrosty\WpUtilities\Utils\View;
use TheFrosty\WpUtilities\WpAdmin\Dashboard\Widget;
use TheFrosty\WpUtilities\WpAdmin\DashboardWidget;

if (!($this instanceof View)) {
    wp_die(sprintf('Please don\'t load this file outside of <code>%s.</code>', esc_attr(View::class)));
}

$instance ??= $this->getViewData()['instance'] ?? null;

if (!$instance instanceof DashboardWidget) {
    return;
}

$div_open = '<div class="rss-widget"><ul>';
$div_close = '</ul></div>';
echo $div_open;
switch ($instance->getWidget()->getType()) {
    case Widget::TYPE_RSS:
        $template = __DIR__ . 'dashboard-widget/rss.php';
        break;
    default:
        $template = __DIR__ . '/dashboard-widget/rest.php';
        break;
}
include $template;
echo $div_close;

/**
 * Render additional content.
 * @param string $div_open The opening div tag.
 * @param string $div_close The closing div tag.
 * @param string $template The template file to use.
 * @param Widget $widget The widget object.
 */
do_action(DashboardWidget::HOOK_NAME_RENDER, $div_open, $div_close, $template, $instance->getWidget());
