<?php
use yii\helpers\Html;
use backend\models\Assets;
?>

<div style="text-align:center;">
<img src="assets_ui/images/uongozi_logo.png" alt="" style="width:100px;height:100px;margin-top:0;margin-bottom:0">
<h4 style="font-family: calibri;">UONGOZI INSTITUTE</h4>
<h4 style="font-family: calibri;">BOOKS AND AUDIO <?= date('Y') ?></h4>
</div>

<table style="font-family: calibri;border-collapse: collapse;width: 100%;">

    <tr>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">S/N</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Item Type</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Isbn #</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Barcode</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Author</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Title</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Yop</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Qty</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Price</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 6px;padding-bottom: 6px;text-align: left;background-color: #04AA6D;color: white;">Condtion</th>
    </tr>

<tbody>
<?php
$i = 1;
foreach ($books as $book) {
    ?>
    chun
    <tr>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($i++) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($book->item_type) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($book->isbn) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($book->barcode) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($book->author) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($book->title) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($book->yop) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($book->qty) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode(number_format($book->price)) ?></td>
        <td style="font-family: calibri;border: 1px solid #ddd;padding: 8px"><?=  Html::encode($book->condition) ?></td>

    </tr>  
<?php
}
?>
</tbody>
</table>
<div>
    <h4>TOTAL VALUE (B00KS +CD):   <?= number_format($totalPrice) ?></h4><br>
    <table style="width:100%;border:0px;border-collapse: collapse">
    <tr>
    <th style="padding: 20px;text-align:left">Counted By:</th>
    <td style="padding: 20px;text-align:left"></td>
    <th style="padding: 20px;text-align:left">Sign:</th>
    <td style="padding: 20px;text-align:left"></td>
    <th style="padding: 20px;text-align:left">Date:</th>
    <td style="padding: 20px;text-align:left"></td>
  </tr>
  <tr>
    <th style="padding: 20px;text-align:left">Verified By:</th>
    <td style="padding: 20px;text-align:left"></td>
    <th style="padding: 20px;text-align:left">Sign:</th>
    <td style="padding: 20px;text-align:left"></td>
    <th style="padding: 20px;text-align:left">Date:</th>
    <td style="padding: 20px;text-align:left"></td>
  </tr>
    <tr>
    <th style="padding: 20px;text-align:left">Approved By:</th>
    <td style="padding: 20px;text-align:left"></td>
    <th style="padding: 20px;text-align:left">Sign:</th>
    <td style="padding: 20px;text-align:left"></td>
    <th style="padding: 20px;text-align:left">Date:</th>
    <td style="padding: 20px;text-align:left"></td>
  </tr>
    <tr>
    <th style="padding: 20px;text-align:left">External Auditor:</th>
    <td style="padding: 20px;text-align:left"></td>
    <th style="padding: 20px;text-align:left">Sign:</th>
    <td style="padding: 20px;text-align:left"></td>
    <th style="padding: 20px;text-align:left">Date:</th>
    <td style="padding: 20px;text-align:left"></td>
  </tr>
</table>
</div>