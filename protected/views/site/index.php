<?php

    $this->widget('application.components.widgets.ListView', array(
        'id' => strtolower(get_class($model)) . '-list',
        'dataProvider' => $model->search(),
        'itemView' => 'pageView'
    )); 
