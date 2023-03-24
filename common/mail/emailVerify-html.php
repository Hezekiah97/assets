<?php

use yii\helpers\Html;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Hello <?= Html::encode(User::getUsername($user->id)) ?>,</p>

    <p>Follow the link below to verify your email:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
