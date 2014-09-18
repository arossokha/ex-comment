<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link href="/css/admin/style.css" title="compact" rel="stylesheet" type="text/css">
	<script type="text/javascript">
		$(document).ready(function () {
			$('.nav ul li ul').hide();
			$('.nav ul li').click(
				function () {
					$(this).find('ul').slideToggle();
				}
			);
		});
		$(document).ready(function () {
			$(".photo p .plus").live("click", function () {
				$('.photo').append('<p><input type=file><img src=/images/admin/minus.gif class=minus></p>');
				$('.photo p .minus').click(
					function () {
						$(this).parents('p').remove();
					}
				);
			});
		});
	</script>
</head>
<body>
<div id="wrapper">
	<div id="top">
		
		<p id="name">
			<a href="/admin">
				<!-- 
					<img src="<?php echo CHtml::encode($this->adminTitlePath); ?>" width="165" height="50">
				-->
			</a>
		</p>
	</div>
	<?php echo $content; ?>
</div>
<div id="footer">
	<div class="inner">
		<p id="copy">
			<?php
			echo Yii::app()->params['provides'];
			?>
		</p>

		<p class="logo">
			<a href="<?php echo CHtml::encode($this->footerLogoUrl); ?>"><img
				src="<?php echo CHtml::encode($this->footerLogoPath); ?>" alt=""></a>
		</p>
	</div>
</div>
</body>
</html>
