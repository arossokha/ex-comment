<?php


	switch($data['modelName']){
		case "Transport" : {
			Transport::disableDefaultScope();
			$model = Transport::model('Transport')->findByPk($data['key']);

			echo $this->renderPartial('application.views.transport._view',array(
					'data' => $model
				));
		}
		break;
		case "Cargo" : {
			Cargo::disableDefaultScope();
			$model = Cargo::model()->findByPk($data['key']);

			echo $this->renderPartial('application.views.cargo._view',array(
					'data' => $model
				));
		}
		break;
		case "Tender" : {

			$model = Tender::model()->findByPk($data['key']);

			echo $this->renderPartial('application.views.tender._view',array(
					'data' => $model
				));
		}
		break;
		case "User" : {
			
			$model = User::model()->findByPk($data['key']);

			echo $this->renderPartial('application.views.user._view',array(
					'data' => $model
				));
		}
		break;

		default : {
			echo "Не правильные данные обратитесь к администратору.";
		}
	};
