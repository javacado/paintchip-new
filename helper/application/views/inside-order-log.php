 <div id='prodstatuslist' data-logid="<?=$row->log_id?>">
<table class='table text-center ptable ' style='width:100%;' >
    <tr class='hdr' ><td style='text-align:left;padding-left:0'>Product</td><td class='text-center' style='width:40px'>Got</td><td class='text-center' style='width:40px;color:#c00;' >Order</td>
    <?foreach ($row->products as $p) {
	$is = 0;
	if (isset($row->prod_data[$p->product_id])) {
		$is = $row->prod_data[$p->product_id]['in_store'];
	}
	?>
<tr rel='<?=$p->product_id?>' class='prods'><td style='text-align:left;padding-left:0'>
    <span style="<?if ($is != 1) {echo "color:#c00;";}?>"><?=$p->order_item_name?></span></td>
    <td class='text-center' >
            <input type='radio' class='prod-radio' style=''  rel='<?=$p->product_id?>' onclick="" name='in_stock_<?=$p->product_id?>' <?if ($is) {echo "checked";}?> value='1' name="in_store" />
        </td>
    <td class='text-center' >
            <input type='radio' class='prod-radio'  style='' rel='<?=$p->product_id?>' onclick="" <?if (!$is) {echo "checked";}?> name='in_stock_<?=$p->product_id?>' value='0' name="need_to_order" />

    </td>
</tr>

        <?}?>
</table>
<div class='srow'>
    <strong>Employee</strong>

        <input class='form-control' rel='employee' type='text' value="<?=$row->employee?>">

</div>
<div class='srow'>
    <strong> Picked Up</strong>

        <div class='form-group'>
              <input type='checkbox' rel='fdc' style='float:left; margin:5px 10px 0 0;' <?if ($row->picked_up != "") {
	echo 'checked';
}
?>  onclick='std(this)' />
 <input class='form-control' rel='picked_up' style='width:75%;' readonly type='date' value="<?=$row->picked_up?>" />
 </div>
</div>

<div class='srow'>
    <strong> Notes</strong>

<textarea rel='notes' class='form-control'><?=$row->notes?></textarea>


</div>
</div>

<div>
<a class='small' href='/helper/order_log/index/0' target='_order_log'>
Open the Paintchip Order Log in a new window
</a>
    </div>







<style>

    .small{
        font-size:.8em;
    }
.srow{
    margin-bottom:10px;
    padding-top:10px;
    margin-top:10px;
    border-top:1px dashed #ccc;

}

.srow strong{
    display:block;
    margin-bottom:5px;
}
    .text-center{
        text-align: center;
    }

    #prodstatuslist .form-control{
width:100%;
    }
.ptable td{
padding:5px;
}
.ptable .hdr td{
    font-weight:bold;

}
</style>