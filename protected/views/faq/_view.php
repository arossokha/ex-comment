<div class="faqItem">
<?php
echo CHtml::link(($index+1).". ".$data->question,'javascript:void(0);',array('class' => 'faqQuestion'));
echo "
<div class='faqAnswer' style='display: none'>
	{$data->answer}
</div>
";
?>
</div>
<div class='clear'></div>
