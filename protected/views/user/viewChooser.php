<?php
if ( $data->role == User::ROLE_JURIDICAL_FACE ) {
	$this->renderPartial('application.views.user._viewCompany', array('data' => $data));
} else {
	$this->renderPartial('application.views.user._view', array('data' => $data));
}