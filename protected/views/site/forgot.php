<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
?>
<h1>Восстановление пароля</h1>
<div id="filter">
	<div>
		<?php

			$form = $this->beginWidget('CActiveForm', array(
														   'id' => 'forgot-form',
														   'enableAjaxValidation' => false,
													  ));
			?>

				<p style="font-weight: bold;font-size: 14px;">
					пожалуйста, введите Ваш e-mail.
				</p>
				<p class="resend">
					<p style="font-size: 14px; display: inline;">
						E-mail <strong style="color: red">* </strong>
					</p>
					<?php echo $form->textField($model, 'email',array(
					'style' => "width: 240px;font-size: 12px;padding: 5px 5px 4px;font-family: 'PT Sans';
					border: 1px solid #D9D9D9;background-color: white; margin-right: 10px;"
					)); ?>
					<input type="submit" value="Отправить письмо"
							style="
							width: 150px;
							color: white;
							font-size: 14px;
							font-weight: bold;
							cursor: pointer;
							padding: 6px 0;
							margin: 0;
							margin-right: 10px;
							background: url('/images/enter_go.gif') repeat-x bottom;
							border: 0;
							-moz-box-shadow: 0 1px 1px #d9d9d9;
							-webkit-box-shadow: 0 1px 1px #D9D9D9;
							box-shadow: 0 1px 1px #D9D9D9;
							-webkit-border-radius: 5px;
							-moz-border-radius: 5px;
							border-radius: 5px;
							position: relative;
							behavior: url('/css/pie.htc');
							">
				<?php
		if (!is_null($sended)) {
			echo "<p style='display: inline;'><span style='font-weight: bold; color: #A34747;'><i>";
			if(!$sended) {
				$m = $model->getErrors('email');
				echo $m[0];
			} else {
				echo "Письмо c инструкциями отправлено!";
			}
			echo "</i></span></p>";
		}
			$this->endWidget();

		?>
        </p>

	</div>
</div>