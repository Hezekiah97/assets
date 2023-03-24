<?php
use yii\helpers\Html;
use backend\models\Assets;
?>

<div style="text-align:center;">
                <img src="assets_ui/images/uongozi_logo.png" alt="" style="width:100px;height:100px;margin-top:0;margin-bottom:0">
                <h4 style="font-family: calibri;">ASSETS REPORT BY CONDITION</h4>
</div>

<table style="font-family: calibri;border-collapse: collapse;width: 100%;">
<thead>
    <tr>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">S/N</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Asset code</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Current Owner</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Category</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Asset Desc</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Condition</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Status</th>
        <!-- <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Reg Date</th> -->
    </tr>
</thead>
<tbody>
<?php
$i = 1;
foreach ($assets as $asset) {
    ?>
    <tr>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($i++) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($asset->asset_code) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($asset->currentOwner($asset->id)) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($asset->category0->category_name) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($asset->asset_particulars) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($asset->condition) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  ($asset->status == 1) ? 'Availabe' : 'Not available' ?></td>
        <!-- <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px">< ?=  Html::encode(Assets::getTime($asset->reg_date)) ?></td> -->

    </tr>  
<?php
}
?>
</tbody>
</table>