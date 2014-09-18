<h3>
    <span class="info"> Управление "<?php echo $this->name;?>" </span>
</h3>
<br>
<?php
if (!Yii::app()->request->isPostRequest) {
	?>
<script type="text/javascript">
    $(document).ready(function () {

        $('.saveBanner').live('click', function () {
            var f = this;
            $('form').ajaxSubmit({
                success:function (data) {

                    $('.bannerData form').html($(data).find('form').html());

                    $(f).parents('form').resetForm();
                    jQuery('#Banner_dateFrom').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['ru'], {'showAnim':'fold', 'changeMonth':true, 'changeYear':true, 'yearRange':'1980:2012', 'dateFormat':'yy-mm-dd'}));
                    jQuery('#banner-grid').yiiGridView('update')
                }
            })
        });

        $('.bannerFile input').live('change', function () {
            var f = this;
            $(f).parents('form').ajaxSubmit({
                dataType:'json',
                success:function (data) {
                    if (data.status == 'ok') {
                        $('.bannerImage img').attr('src', data.name);
                        $('.bannerImage .size .value').text(data.size);
                        $('.bannerUrl').val(data.name);
                        $('.bannerPath').val(data.path);
                    } else {
                        alert(data.msg);
                    }
                    $(f).parents('form').resetForm();
                }
            })
        });
    });

</script>
<?php
}
?>
<div style="width: 750px; min-height: 70px;">
    <div class="bannerData">
		<?php
		$form = $this->beginWidget('CActiveForm', array(
			'id' => 'banner-form',
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
			'enableAjaxValidation' => false,
		));

		Yii::app()->clientScript->registerScriptFile('/js/jquery.form.js', CClientScript::POS_BEGIN);

		echo $form->errorSummary($model);
		?>

        <div class="bannerFile">
			<?php echo CHtml::fileField('file'); ?>
			<?php echo $form->hiddenField($model, 'url', array('class' => 'bannerUrl')) ?>
			<?php echo $form->hiddenField($model, 'path', array('class' => 'bannerPath')) ?>
        </div>
        <div class="bannerDates">

			<?php
			Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
				'value' => $model->dateFrom ? $model->dateFrom : '',
				'name' => get_class($model) . '[dateFrom]',
				'language' => 'ru',
				'htmlOptions' => array('class' => 'hasDatepicker1', 'size' => 10, 'maxlength' => 15, 'style' => 'height:20px;'),
				'options' => CMap::mergeArray(array(
					'showAnim' => 'fold',
					'changeMonth' => true,
					'changeYear' => true,
					'yearRange' => date('Y').':2030',
					'dateFormat' => 'yy-mm-dd'
				), array()),
			));
			echo $form->error($model, 'dateFrom');
			echo "<br>";
			echo $form->textField($model,'urlCompany',array());
			echo $form->error($model, 'urlCompany');

			echo "<br >";

			echo CHtml::dropDownList('Banner[period]', '', array(
				'1 week' => '1 неделя',
				'2 week' => '2 недели',
				'3 week' => '3 недели',
				'4 week' => '4 недели',
			), array( //			'empty' => 'Выбирите период'
			));
			echo "<br >";
			?>
        </div>

		<?php

		$this->endWidget();
		echo "<button class='saveBanner' >Сохранить</button>";

		if ($model->path) {
			$s = getimagesize(addslashes($model->path));
		}
		?>

    </div>
    <div class="bannerImage">
    <span class="size">Размер банера: <span
            class="value"><?php echo is_array($s) ? "{$s[0]}x{$s[1]}" : "Неизвестно"; ?></span></span>

        <div class="clear"></div>
        <img src="<?php echo $model->url; ?>" alt="" style="width: 400px;">

        <div class="clear"></div>
    </div>
    <div class="clear"></div>

</div>
<div class="clear"></div>
<div style="width: 750px;">
	<?php

	$columns[] = $buttonColumn;

	$model->unsetAttributes();
	$this->widget('zii.widgets.grid.CGridView', array(
		'id' => strtolower(get_class($model)) . '-grid',
		'dataProvider' => $model->search(),
		// 'filter'=>$model,
		'template' => '{items} {pager}',
		'columns' => $columns,
	));


	?>
</div>
