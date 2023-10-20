<?php

namespace app\components;

use webvimark\modules\UserManagement\components\GhostAccessControl as ComponentsGhostAccessControl;
use webvimark\modules\UserManagement\models\rbacDB\Route;
use webvimark\modules\UserManagement\models\User;
use yii\base\Action;
use Yii;
use yii\web\ForbiddenHttpException;

class GhostAccessControl extends ComponentsGhostAccessControl
{
	/**
	 * Denies the access of the user.
	 * The default implementation will redirect the user to the login page if he is a guest;
	 * if the user is already logged, a 403 HTTP exception will be thrown.
	 *
	 * @throws ForbiddenHttpException if the user is already logged in.
	 */
	protected function denyAccess()
	{
		if (Yii::$app->user->getIsGuest()) {
			Yii::$app->getResponse()->redirect(["/auth/login"])->send();
		} else {
			Yii::$app->getResponse()->redirect(["/auth/forbidden"])->send();
		}

		Yii::$app->end();
	}
}
