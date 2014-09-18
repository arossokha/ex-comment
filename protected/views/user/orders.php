<?php
Yii::app()->clientScript->registerScript('search', "
$('form#orders-form select').live('change',function(){
	$.get('/user/orders',$(this).parents('form').serialize(),function(data){
		$('.favoriteContent').html($(data).find('.favoriteContent').html());
	})
return false;
});
");
?>
<h1>Фильтр<sup><a href="#">?</a></sup></h1>
<div id="filter">
	<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'orders-form',
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>
    <div>
        <table>
            <tr>
                <td>Выводить</td>
                <td class="">
					<?php
					echo CHtml::dropDownList('modelName',0,
						array(
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
                    <p>
						В данном разделе отображаются размещённые Вами заявки, которые являются актуальными.
	                </p>
	                <p>
	                    Вы в любой момент, можете отредактировать или удалить созданную Вами заявку.
                    </p>
                </td>
            </tr>
        </table>
    </div>
	<?php $this->endWidget(); ?>
</div>
<div class="favoriteContent">
	<?php
	if ( empty($_REQUEST['modelName']) || $_REQUEST['modelName'] == 'Cargo' ) {
		?>
        <h1>Грузы (мои заявки)
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
				'id' => 'cargo-view',
				'itemView' => 'application.views.cargo._view',
				'template' => '{items} {pager}'
			));
		} else {
			echo "Нет данных";
		}
		echo "<br/><br/>";
	}
	?>

	<?php
	if ( empty($_REQUEST['modelName']) || $_REQUEST['modelName'] == 'Transport' ) {
		?>
        <h1>Транспорт (мои заявки)
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
				'id' => 'transport-view',
				'itemView' => 'application.views.transport._view',
				'template' => '{items} {pager}'
			));
		} else {
			echo "Нет данных";
		}
		echo "<br/><br/>";
	}
	?>
	<?php
	if ( empty($_REQUEST['modelName']) || $_REQUEST['modelName'] == 'Tender' ) {
		?>
        <h1>Тендеры (мои заявки)
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
				'id' => 'tender-view',
				'itemView' => 'application.views.tender._view',
				'template' => '{items} {pager}'
			));
		} else {
			echo "Нет данных";
		}
		echo "<br/><br/>";
	}
	?>
</div>