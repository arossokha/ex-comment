<!--<div id="table" class="info five2 type4">-->
<!--	<table>-->
<!--		<tr>-->
<?php
echo "<span>" . CHtml::encode($data->message) . "</span>";
if ( $data->userId ) {
	echo "<br >" . date('d.m.y', strtotime($data->created_timestamp)) . " " . $data->user->getName();
} else {
	echo "<br >" . date('d.m.y', strtotime($data->created_timestamp)) . " " . $data->name . " ";
	echo $data->email;
}
?>
<!--		</tr>-->
<!--	</table>-->
<!--</div>-->