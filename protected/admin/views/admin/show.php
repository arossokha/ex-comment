<?php
/**
 * This w=view used for show widget for config in admin panel
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */


/**
 * @todo add settings for id="crb" || id = "cb" (with right widgets)
 */

$widget = $this->createWidget($widgetClass, array('name' => $data['name'], 'params' => $data));

?>

<div id="<?php echo $widget->getBlockId(); ?>">
	<?php
	$widget->run();
	?>
	<div id="clear"></div>
</div>
