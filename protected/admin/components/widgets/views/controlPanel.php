<?php
/**
 * Control panel view
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
?>

<div id="lb">
	<h3>
		<span class="panel">Панель управления</span>
	</h3>

	<div class="nav">
		<ul>
			<?php
			foreach ($this->categories as $item) {
				if ( isset($item['visible']) && !$item['visible'] ) {
					continue;
				}
				?>
				<li><a href="<?php echo '/admin/' . $item['path']; ?>"><?php echo $item['name'];?></a>
					<?php
					/**
					 * @todo : not use this
					 */
					if ( $item['children'] ) $this->render('panelChild', array('categories' => $item['children']), true);
					?>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
</div>