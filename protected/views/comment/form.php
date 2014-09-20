<div class="comment-block">
    <h2>Comments</h2>
    <div class="list">
        <?php 
            $model = new Comment();
            $model->pageId = $page->pageId;

            $this->widget('zii.widgets.CListView', array(
                'id'=>'comment-list',
                'dataProvider'=>$model->search(),
                'itemView'=>'application.views.comment._view',
        )); ?>
    </div>

    <div class="form">
    <?php 
        
        $form=$this->beginWidget('CActiveForm', array(
        'id'=>'comment-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>
        
        <?php echo $form->hiddenField($model,'pageId'); ?>

        <div class="row">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name'); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email'); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'text'); ?>
            <?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->error($model,'text'); ?>
        </div>

        <?php if(CCaptcha::checkRequirements()): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'verifyCode'); ?>
            <div>
            <?php $this->widget('CCaptcha',array(
                'buttonOptions' => array('class' => 'captchaLink')
            )); ?>
            <?php echo $form->textField($model,'verifyCode'); ?>
            </div>
            <div class="hint">Please enter the letters as they are shown in the image above.
            <br/>Letters are not case-sensitive.</div>
            <?php echo $form->error($model,'verifyCode'); ?>
        </div>
        <?php endif; ?>

        <div class="row buttons">

            <?php echo CHtml::submitButton('Submit',array('style' => 'display:none')); ?>
            <?php echo CHtml::ajaxSubmitButton('Save',CHtml::normalizeUrl(array('page/comment')),
                     array(
                         'dataType'=>'json',
                         'type'=>'post',
                         'success'=>'commentAjaxHandler',
                         'beforeSend'=>'commentBeforeSendHandler',
                         ),array('id'=>'submit-button','class'=>'submit-button')); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div>
    <div class="loader" style="display:none;">
        <img src="/images/loading.gif" alt="Loading..." />
    </div>
</div>