<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
?>

<div id="table" class="info four2 type3">
	<table>
		<tr>
			<td class="name">
				<h4><?php echo CHtml::encode($data->getName());?></h4>
			</td>
			<td>
					<span><?php
					echo CHtml::encode(Country::getNameById($data->city->countryId));
					?></span>
				<strong style="font-size: 15px;"><?php echo CHtml::encode($data->city->name);?></strong>
				<span><?php
					echo CHtml::encode(Region::getNameById($data->city->regionId));
					?> </span>
			</td>
			<td>
				<h6><?php echo CHtml::encode($data->scopeOfActivity->name)?></h6>
				<span>Регистрация на сайте с <span style="color:#A34747;"><?php echo date('d.m.Y', strtotime($data->created_timestamp));?> г.</span></span>
			</td>
			<td class="left">
				<span><?php echo (strlen($data->info) <= 140 ? $data->info : mb_substr($data->info, 0, 140)) . '...';?></span>
			</td>
		</tr>
	</table>
	<p class="nav">
		<a class="showContactInfo" href="javascript:void(0);">Посмотреть контактную информацию</a>
		<input type="hidden" value="<?php echo $data->primaryKey;?>">
			<?php
	if (strpos($this->route, 'favorite') !== false) {
	$f = Favorite::getFavoriteByModelNameAndId(get_class($data) , $data->primaryKey);
	
			if ($f) {
				echo '<a href="javascript:void(0);" class="del removeFavorite">Удалить из избранного</a>
					<input type="hidden" value="' . $f->primaryKey . '">';
			}
		} else {
			echo Favorite::getHtmlCode($data);
		}
	?>
	</p>

	<div class="more cont" style="display: none;">
		<div>
			<p><a href="/user/<?php echo $data->userId;?>"><?php echo CHtml::encode($data->getName());?></a>
				— <?php echo CHtml::encode($data->scopeOfActivity->name) . ' , ' . $data->city->name;?></p>

			<p>
				<?php
				if ( $data->email ) echo '<a href="mailto:' . $data->email . '"><img src="/images/mail.gif" alt="' . CHtml::encode($data->email) . '"></a>';
				if ( $data->skype ) echo '<a href="skype:' . $data->skype . '"><img src="/images/skype.gif" alt="' . CHtml::encode($data->skype) . '"></a>';
				if ($data->icq) echo '<a href="http://www.icq.com/whitepages/cmd.php?uin='.CHtml::encode($data->icq).'&action=message"><img src="/images/icq.gif" alt="' . CHtml::encode($data->icq) . '"></a>';
				if ( $data->phone ) echo '<span><strong>Сотовый тел.:</strong> ' . $data->getFormatedPhone() . '</span>';
				if ( $data->workPhone ) echo '<span><strong>Рабочий тел.:</strong> ' . $data->getFormatedWorkPhone() . '</span>';
				if ( $data->fax ) echo '<span><strong>Факс:</strong> ' . $data->getFormatedFax() . ',</span><span> ' .
					CHtml::encode($data->lastName) . ' ' . CHtml::encode($data->name) . ' ' . CHtml::encode($data->patronymic)
					. '</span>';
				?>
			</p>
		</div>
	</div>
</div>