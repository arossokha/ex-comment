<?php
Yii::app()->clientScript->registerScript('search', "
$('form#favorite-form select').live('change',function(){
	$.get('/favorite/index',$(this).parents('form').serialize(),function(data){
		$('.favoriteContent').html($(data).find('.favoriteContent').html());
	})
return false;
});
");
?>
<h1>Фильтр<sup><a href="#">?</a></sup></h1>
<div id="filter">
	<?php $form = $this->beginWidget('CActiveForm', array(
														 'id' => 'favorite-form',
														 'action' => Yii::app()->createUrl($this->route),
														 'method' => 'get',
													)); ?>
	<div>
		<table>
			<tr>
				<td>Выводить</td>
				<td class="">
					<?php
					echo $form->dropDownList($model, 'modelName',
						array(
							 'User' => 'Компании',
							 'Tender' => 'Тендеры',
							 'Cargo' => 'Грузы',
							 'Transport' => 'Транспорт'
						), array('class' => 'custom', 'empty' => 'Сделайте свой выбор'));
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<h5>Внимание!</h5>
					<p>В данном разлеле храняться заявки, которые Вы посчитали важными и добавили в избранное.<br>
						Вы можете в любой удалить любую заявку, которая потеряла свою актуальность. </p>
				</td>
			</tr>
		</table>
	</div>
	<?php $this->endWidget(); ?>
</div>
<div class="favoriteContent">
	<?php
	if ( empty($model->modelName) || $model->modelName == 'Cargo' ) {
		?>
		<h1>Грузы (избранное)
			<?php
			if ( $cargoes->getTotalItemCount() ) {
				echo '<sup><a href="#">+' . $cargoes->getTotalItemCount() . '</a></sup>';
			}
			?>

		</h1>
		<?php
		if ( $cargoes->getTotalItemCount() ) {
			$this->widget('zii.widgets.CListView', array(
														'dataProvider' => $cargoes,
														'itemView' => 'application.views.cargo._view',
														'template' => '{items}'
												   ));
		} else {
			echo "Нет данных";
		}
		echo "<br/><br/>";
	}
	?>

	<?php
	if ( empty($model->modelName) || $model->modelName == 'Transport' ) {
		?>
		<h1>Транспорт (избранное)
			<?php
			if ( $transports->getTotalItemCount() ) {
				echo '<sup><a href="#">+' . $transports->getTotalItemCount() . '</a></sup>';
			}
			?>
		</h1>
		<?php
		if ( $transports->getTotalItemCount() ) {
			$this->widget('zii.widgets.CListView', array(
														'dataProvider' => $transports,
														'itemView' => 'application.views.transport._view',
														'template' => '{items}'
												   ));
		} else {
			echo "Нет данных";
		}
		echo "<br/><br/>";
	}
	?>
	<?php
	if ( empty($model->modelName) || $model->modelName == 'Tender' ) {
		?>
		<h1>Тендеры (избранное)
			<?php
			if ( $tenders->getTotalItemCount() ) {
				echo '<sup><a href="#">+' . $tenders->getTotalItemCount() . '</a></sup>';
			}
			?>
		</h1>
		<?php
		if ( $tenders->getTotalItemCount() ) {
			$this->widget('zii.widgets.CListView', array(
														'dataProvider' => $tenders,
														'itemView' => 'application.views.tender._view',
														'template' => '{items}'
												   ));
		} else {
			echo "Нет данных";
		}
		echo "<br/><br/>";
	}
	?>
	<?php
	if ( empty($model->modelName) || $model->modelName == 'User' ) {
		?>
		<h1>Компании (избранное)
			<?php
			if ( $users->getTotalItemCount() ) {
				echo '<sup><a href="#">+' . $users->getTotalItemCount() . '</a></sup>';
			}
			?>
		</h1>

		<?php
		if ( $users->getTotalItemCount() ) {
			$this->widget('zii.widgets.CListView', array(
														'dataProvider' => $users,
														'itemView' => 'application.views.user.viewChooser',
														'template' => '{items}'
												   ));
		} else {
			echo "Нет данных";
		}
	}
	?>
</div>