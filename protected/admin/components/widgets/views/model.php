<?php
/**
 * model manager widget view
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
?>

<h3>
	<span class="info"><?php echo $this->name;?></span>
</h3>
<div class="container">
	<div class="add">
		<?php
		$opResult = Yii::app()->user->getFlash("OPERATION_RESULT");
		if ( !empty($opResult) ) {
			echo "<div class='stat_com'>" .
				$opResult .
				"</div><br>";
		}
		$form = $this->beginWidget('CActiveForm', array(
													   'id' => strtolower(get_class($model)) . '-form',
													   'enableClientValidation' => true,
													   'clientOptions' => array(
														   'validateOnSubmit' => true,
													   ),
                                                       'htmlOptions' => array('enctype'=>'multipart/form-data')
												  ));

		echo $form->errorSummary($model);

		//		var_dump($attributes);
		//			exit();

		foreach ($attributes as $item) {
			echo "<p>{$item['name']}</p>";

			// @TODO create field type
			FieldProcessor::getActiveField($model, $item, $form);

			echo "<div class='stat_com'>" .
				$form->error($model, $item['attribute']) .
				"</div>";
		}

		echo "<p class='$buttonType'>" .
			CHtml::submitButton("") .
			"</p>";

		//		var_dump($model->getErrors());

		$this->endWidget();
		?>

	</div>
</div>
