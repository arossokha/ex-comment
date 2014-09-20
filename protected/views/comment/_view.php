<div class="comment">
    <div class="title">
        <span><?php echo $data->name; ?> <b>(<?php echo $data->email; ?>)</b>, <?php echo Yii::app()->getDateFormatter()->format("dd-MM-yyyy", $model->created_timestamp);?></span>
    </div>
    <div class="body">
        <span>
            <?php echo $data->getTextWithLinks(); ?>
        </span>
    </div>
</div>
