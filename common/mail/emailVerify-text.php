<?php

use yii\helpers\Html;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
Hello <?= Html::encode(User::getUsername($user->id)) ?>,

Follow the link below to verify your email:

<?= $verifyLink ?>
