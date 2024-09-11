<?php
$o_array=$_REQUEST['o_array'];

if($_POST['bail_order'] == 'Y'){
    $add_class_hide = "d-none";
}
else{
    $add_class_hide = "";
}
//echo count($o_array);
//exit();
$o_array = !empty($o_array)?$o_array:[];
if(count($o_array)>0)
{
?>
<div class="card col-md-12 mt-2 <?=$add_class_hide?> ">
<div class="card-header bg-info text-white font-weight-bolder">Calculated Fees</sub>
</div>
<div class="card-body">
<table class="table table-bordered  table-striped">
 <thead>
    <tr>
    <th>S.No.</th>
    <th>Document Details</th>
    <th>Order/File Date</th>
     <th>No. of Pages</th>
     <th>No. of Copies</th>
       <th>Amount</th>
</tr>
 </thead>
    <tbody>
<?php
$t_pages=0;$t_copies=0;$t_amt=0;   $service_charges = 0; $fee_in_stamp = 0; $total_red_wrappers = 0;
for($i=0;$i<count($o_array);$i++)
{
$sporderdate=($o_array[$i][0] != '01-01-1970') ? $o_array[$i][0] : '';
$sptotalpages=($o_array[$i][1])?$o_array[$i][1]:0;
$spjudgementorder=($o_array[$i][2])?$o_array[$i][2]:'';
$ischargable=$o_array[$i][3];

        $spjudgementordercode =$o_array[$i][4];
        $sp_certi_number_of_docs=$o_array[$i][5];
        $sp_certi_number_of_pages=$o_array[$i][6];
        $sp_uncerti_number_of_docs=$o_array[$i][7];
        $sp_uncerti_number_of_pages=$o_array[$i][8];


//if($_REQUEST['tb_added_doc']==0)
//  $s_no=1;
//else
$s_no=$i+1;
?>
<tr>
    <td><?php echo $s_no; ?></td>
<td>
    <span class="cp_tspjudgementorder" id="tspjudgementorder_<?php echo $i; ?>"><?php echo $spjudgementorder; ?></span>
</td>
<td>
    <span class="cp_tsporderdate" id="tsporderdate_<?php echo $i; ?>"><?=$sporderdate?></span>
</td>
<td>
    <span id="tsptotalpages_<?php echo $i; ?>"><?php $t_pages=$t_pages+$sptotalpages; echo $sptotalpages; ?></span>
</td>
<td><?php $t_copies=$t_copies+$_REQUEST['num_copy']; echo ($_REQUEST['num_copy'])?$_REQUEST['num_copy']:0; ?></td>
<td>
  <?php
$query = "Select id,urgent_fee,per_certification_fee,per_page from copy_category where id=:id and to_date='0000-00-00'";
$rs = $dbo2->prepare($query);
$rs->bindParam(':id', $_REQUEST['app_type']);
$rs->execute();
$r_sql = $rs->fetch(PDO::FETCH_ASSOC);
$urgent_fee = $r_sql['urgent_fee'];
//$sql="Select id,urgent_fee,per_certification_fee,per_page from copy_category where id='$_REQUEST[app_type]' and to_date='0000-00-00'";
//$sql=  mysqli_query($conn_icmis, $sql) or die("Error: ".__LINE__.  mysqli_error($conn_icmis));
//$r_sql=  mysqli_fetch_array($sql);
//$total=(($r_sql['per_page']*$sptotalpages))*$_REQUEST['num_copy'];
if($_SESSION["session_filed"] == 4){
    $third_party_charges=5;
}
else{
    $third_party_charges=0;
}
  $total = 0;
  
if($ischargable == 'Free' && $_REQUEST['app_type'] == 5) {

}
else{

    if($sp_certi_number_of_docs > 0){
        //for unavailable docs request fee calculation
        $total = (($r_sql['per_page'] * $sptotalpages) + ($r_sql['per_certification_fee'] * $sp_certi_number_of_docs)) * $_REQUEST['num_copy'];
        $service_charges += ($r_sql['per_page'] * $sptotalpages) * $_REQUEST['num_copy'];
        $fee_in_stamp += $r_sql['per_certification_fee'] * $_REQUEST['num_copy'] * $sp_certi_number_of_docs;

        if ($r_sql['per_certification_fee'] > 0) {
            $total_red_wrappers += $sp_certi_number_of_docs * $_REQUEST['num_copy'];
        }
    }
    else{
        $total = (($r_sql['per_page'] * $sptotalpages) + $r_sql['per_certification_fee']) * $_REQUEST['num_copy'];
        $service_charges += ($r_sql['per_page'] * $sptotalpages) * $_REQUEST['num_copy'];
        $fee_in_stamp += $r_sql['per_certification_fee'] * $_REQUEST['num_copy'];

        if ($r_sql['per_certification_fee'] > 0) {
            $total_red_wrappers += $_REQUEST['num_copy'];
        }
    }



}
?>
    <span id="ttotal_<?php echo $i; ?>"><?php $t_amt+=$total; echo $total; ?></span>
</td>
</tr>
<?php }

$urgent_plus_third_party_charges = ($third_party_charges + $urgent_fee) * $_REQUEST['num_copy'];

$service_charges += $urgent_plus_third_party_charges;

$t_amt+=$urgent_plus_third_party_charges;


//if($_REQUEST[cop_mode] == 1 && strlen($_REQUEST[pincode]) == 6) {
if($_REQUEST['cop_mode'] == 1 && strlen($_REQUEST['pincode']) == 6) {

    include('../postage/function.php');

    $total_pages = $t_pages * $_REQUEST['num_copy']; //1 A4 page = 80 gsm = 5 grams
    $weight = copying_weight_calculator($total_pages, $total_red_wrappers);

    if ($weight > 0) {

     $desitnation_pincode = $_REQUEST['pincode']; //destination pincode

    //$postage_response = speed_post_tariff_calc_offline($total_pages,$desitnation_pincode);
    $postage_response = speed_post_tariff_calc_online($weight, $desitnation_pincode);

    $postage_data = json_decode($postage_response);
    //  echo $postage_data['Validation Status'];
    //var_dump($postage_data); <?= $postage_data->{'Base Tariff'}; + Tax Rs. <?= $postage_data->{'Service Tax'}; 
    if ($postage_data->{'Validation Status'} == "Valid Input") {
        $postage_charges = ceil($postage_data->{'Base Tariff'} + $postage_data->{'Service Tax'});
        ?>
        <tr>
            <td colspan="5" data-speed_post_charges_mode="online">Speed Post Charges</td>
            <td><?= $postage_charges; ?></td>
        </tr>
        <?php
    }
    else {
        ?>
        <tr>
            <td colspan="6"><?= $postage_data->{'Validation Status'}; ?></td>
        </tr>
        <?php
        exit();
    }
}
else{
    ?>
    <tr>
        <td colspan="6"><?= "Unable to Calculate Weight of pages"; ?></td>
    </tr>
    <?php
    exit();
}

}
else{
    $postage_charges = 0;
}
if($urgent_plus_third_party_charges > 0){
?>
<tr>
    <td colspan="5">Urgency fees</td>
    <td><?= $urgent_plus_third_party_charges; ?></td>
</tr>
<?php } ?>
<tr>
    <td colspan="3">Total</td>
    <td><?php echo $t_pages; ?></td>
    <td><?php echo $t_copies; ?></td>
    <td class="amount_to_pay" data-postage ="<?= $postage_charges; ?>" data-service_charges="<?= $service_charges; ?>" data-fee_in_stamp="<?= $fee_in_stamp; ?>" data-amount-to-pay="<?= $t_amt + $postage_charges; ?>">
    <?php 
    if($postage_charges > 0){
        echo $t_amt + $postage_charges;
        $_SESSION['session_total_amount_to_pay'] = $t_amt + $postage_charges;
    }
    else{
        echo $t_amt;
        $_SESSION['session_total_amount_to_pay'] = $t_amt;
    } ?></td>
</tr>
    </tbody>
</table>
</div>
</div>
<?php
} ?>
