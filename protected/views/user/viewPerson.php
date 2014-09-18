<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
?>

<div id="tip">
	<div>
		<div>
			<p>Простой и удобный сервис для грузоперевозчиков и грузовладельцев Позволяет добавлять и искать свободный
				транспорт или груз <span>Без утомительных регистраций и абсолютно бесплатно!</span></p>
		</div>
	</div>
</div>
<h1>Карточка физического лица <?php if ( $edit ) echo "<sup>(" . CHtml::link('Изменить', '/user/edit') . ")</sup>"; ?></h1>
<div id="info">
	<table>
		<tr>
			<th colspan="2">Информация о физическом лице</th>
		</tr>
		<tr>
			<td><strong>Ф.И.О</strong></td>
			<td><?php echo CHtml::encode($model->lastName . ' ' . $model->name . ' ' . $model->patronymic);?><span>Зарегистрирован на сайте <?php echo date('d.m.y', strtotime($model->created_timestamp));?></span>
			</td>
		</tr>
		<tr>
			<td><strong>Сфера деятельности</strong></td>
			<td><?php echo CHtml::encode($model->scopeOfActivity->name);?></td>
		</tr>
		<tr>
			<td><strong>Страна</strong></td>
			<td><?php echo CHtml::encode($model->city->country->name);?></td>
		</tr>
		<tr>
			<td><strong>Область</strong></td>
			<td><?php echo CHtml::encode($model->city->region->name);?></td>
		</tr>
		<tr>
			<td><strong>Город</strong></td>
			<td><?php echo CHtml::encode($model->city->name);?></td>
		</tr>
		<tr>
			<td><strong>Сотовый телефон</strong></td>
			<td><?php echo CHtml::encode($model->getFormatedPhone());?></td>
		</tr>
		<tr>
			<td class="icq"><strong>ICQ</strong></td>
			<td>
			<a href="http://www.icq.com/whitepages/cmd.php?uin=<?php echo CHtml::encode($model->icq);?>&action=message"><?php echo CHtml::encode($model->icq);?></a>
			</td>
		</tr>
		<tr>
			<td class="skype"><strong>Skype</strong></td>
			<td><a href="skype:<?php echo $model->skype;?>?call"><?php echo CHtml::encode($model->skype);?></a></td>
		</tr>
		<tr>
			<td class="email"><a href="mailto:<?php echo $model->email; ?>">Отправить письмо </a>
			</td>
			<td><?php echo Favorite::getHtmlCode($model); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="more">
				<?php echo CHtml::encode($model->info);?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="more">
				<p><strong>Автомобили компании</strong></p>
				<?php
				if ( $model->transport ) {
					foreach ($model->transport as $n => $transport) {
						echo '<p><strong>' . CHtml::encode("ТС " . ($n + 1) . " - {$transport->model} /. ТС - Кузов: {$transport->bodyType->name} /. Г.п. - " . Yii::app()->numberFormatter->formatDecimal($transport->tonnage) . " т  /. Объем: " .
							Yii::app()->numberFormatter->formatDecimal($transport->volume) . " м3  /. Год выпуска: {$transport->year}") . '</strong></p>';
					}
				} else {
					echo CHtml::encode("Транспорт отсутствует");
				}
				?>
			</td>
		</tr>
	</table>
</div>