<?php

use yii\helpers\Html;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Hello <?= Html::encode(User::getUsername($user->id)) ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
