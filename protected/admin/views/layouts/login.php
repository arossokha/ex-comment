<?php
/**
 * admin panel login layout
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */

$this->beginContent('//layouts/main');
?>
<style>
	#wrapper {
		background: #010101 !important;
	}
</style>
<div id="popup">
	<?php
	echo $content;
	?>
</div>
<?php $this->endContent(); ?>