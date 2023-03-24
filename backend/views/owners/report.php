<?php
use yii\helpers\Html;
use backend\models\Assets;
use backend\models\User;

?>

<div style="text-align:center;">
<img src="assets_ui/images/uongozi_logo.png" alt="" style="width:100px;height:100px;margin-top:0;margin-bottom:0">
<h4 style="font-family: calibri;"><?=  Html::encode($barcode) ?> REPORT</h4>
</div>

<table style="font-family: calibri;border-collapse: collapse;width: 100%;">
<thead>
    <tr>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">S/N</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Asset code</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Current Owner</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Issued By</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Issued Date</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Returned Status</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Returned Date</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Received By</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Comment</th>
    </tr>
</thead>
<tbody>
<?php
$i = 1;
foreach ($assets as $asset) {
    ?>
    <tr>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($i++) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($barcode) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($asset->name) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode(User::getUsername($asset->issued_by)) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode(User::getTime($asset->issued_date)) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  ($asset->returned_status == 1) ? 'Returned' : 'Not returned' ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode(User::getTime($asset->returned_date)) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode(User::getUsername($asset->received_by)) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($asset->comment) ?></td>

    </tr>  
<?php
}
?>
</tbody>
</table>