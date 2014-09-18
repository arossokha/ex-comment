<?php $this->beginContent('//layouts/main'); ?>

<div id="account">
	<div class="inner">
		<p class="welcome">
			Welcome, <?php echo Yii::app()->user->getState('email'); ?> (<a
			href="/admin/logout"><?php echo Yii::t('app', 'Log out'); ?></a>)
		</p>

		<p class="your">
			<img src="/images/admin/user_icon.gif" alt="">
			<span><?php echo Yii::app()->user->getState('name'); ?> (<?php echo Yii::app()->user->getState('login'); ?>) Your Account</span>
		</p>
	</div>
</div>
<div id="menu">
	<div class="inner">
		<ul>
			<li><a href="#">Панель управления</a></li>
			<li><a href="/">На сайт</a></li>
		</ul>
	</div>
</div>
<div id="content">
	<?php

	if ( $this->showNavigationPanel ) {
		$categories = Yii::app()->params['layout']['panelSettings'] ? Yii::app()->params['layout']['panelSettings'] : array();
		$this->widget('ControlPanelWidget', array('categories' => $categories));
	}
	?>
	<?php echo $content; ?>

</div>
<div id="clear"></div>


<?php $this->endContent(); ?>

