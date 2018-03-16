<?php
if (is_active_sidebar('home_center_widgets')) {
    dynamic_sidebar('home_center_widgets');
}

$sidebar_contents = ob_get_clean();
$widgetidspart1 = explode('_widget-', $sidebar_contents); //my widgets ids start with nd_home_
?>
