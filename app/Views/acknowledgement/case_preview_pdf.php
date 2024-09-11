<style>
    .collon{
        width:10px;
    }

</style>
<?php

if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] != E_FILING_TYPE_CDE) {
    $lbl_efiling_num = 'e-Filing No.';

    if ($current_status == I_B_Defects_Cured_Stage || $current_status == Initial_Defects_Cured_Stage) {
        $lbl_efiling_dt = 'Re e-Filed Date/Time';
    } else {
        $lbl_efiling_dt = 'e-Filed Date/Time';
    }
} else {
    $lbl_efiling_num = 'CDE No.';
    if ($current_status == I_B_Defects_Cured_Stage || $current_status == Initial_Defects_Cured_Stage) {
        $lbl_efiling_dt = 'Re CDE Date/Time';
    } else {
        $lbl_efiling_dt = 'CDE Date/Time';
    }
}
//var_dump($view_data);
pr($view_data);
?>
<div style="border:1px solid #000;">
    <h3  style="text-align: center"> Supreme Court Of India<br>
        Acknowledgement
    </h3>
    <hr>
    <table width="90%" cellspacing="5" cellpadding="0" border="0" align="left">
        <tr>
            <!--<td rowspan="8" width="20%" valign="center"><img src="./assets/images/ecourts-logo.png" ></td>-->
            <td rowspan="8" width="20%" valign="center"><img src="<?=base_url('assets/images/scilogo.png');?>" ></td>
            <td><?php echo $lbl_efiling_num; ?></td>
            <td class="collon">:</td>
            <td style="width:150px;"><?php echo htmlentities($view_data['efiling_no'], ENT_QUOTES) ?></td>
            <td style="width:100px;"><?php echo $lbl_efiling_dt; ?></td>
            <td class="collon">:</td>
            <td style="width:120px;"><?php echo htmlentities(date('d-m-Y h:i:s A', strtotime($submitted_on)), ENT_QUOTES) ?></td>
        </tr>
<tr>
    <td> Efiled</td> <td class="collon">:</td>
    <td ><?php echo htmlentities($view_data['efiling_type'], ENT_QUOTES); ?></td>
    <?php if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) { ?>
    <td>Case Type</td>
    <td class="collon">:</td>
    <td ><?php echo htmlentities($view_data['casename'], ENT_QUOTES); ?></td>
    <?php }
    else { ?>
    <td>Filed In</td>
    <td class="collon">:</td>
    <td ><?php echo htmlentities($view_data['sc_case'], ENT_QUOTES); ?></td>
    <?php }?>
</tr>
        <tr>
            <td>Petitioner</td>
            <td class="collon">:</td>
            <td ><?php echo htmlentities($view_data['pet_name'], ENT_QUOTES); ?></td>
        </tr>

        <tr>
            <td>Respondent</td>
            <td class="collon">:</td>
            <td colspan="4"><?php echo htmlentities($view_data['res_name'], ENT_QUOTES) ?></td>
        </tr>

      <!--  <?php
/*        if ($view_data['ref_file_no'] != 'NA') {
            $ref_file_title = ($_SESSION['cnr_details']['efiling_case_reg_id']) ? 'efiling Ref No.' : 'CNR No.';
            */?>
            <tr>
                <td><?php /*echo $ref_file_title */?></td>
                <td class="collon">:</td>
                <td colspan="4"><?php /*echo htmlentities($view_data['ref_file_no'], ENT_QUOTES); */?></td>
            </tr>
        <?php /*} */?>
        <?php
/*        if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] != E_FILING_TYPE_CDE) {
            if ($view_data['total_ia'] != 'NA') {
                */?>
                <tr>
                    <td>IA(s)</td>
                    <td class="collon">:</td>
                    <td colspan="4"><?php /*echo htmlentities($view_data['total_ia'], ENT_QUOTES); */?></td>
                </tr>
            --><?php /*}
        }
        */?>

        <tr>
<?php if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE) { ?>
                <td>Advocate</td>
                <td class="collon">:</td>
                <td><?php echo htmlentities($_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name'], ENT_QUOTES); ?>
                    (<?php echo htmlentities($_SESSION['login']['aor_code'], ENT_QUOTES); ?>) </td>
    <?php if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) { ?>
                    <td>Matter Nature</td>
                    <td class="collon">:</td>
                    <td><?php echo ($view_data['urgent'] == 'Y') ? htmlentities('Urgent', ENT_QUOTES) : htmlentities('Ordinary', ENT_QUOTES); ?></td>
                    <?php
                }
            }
            ?>
<?php if ($_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON) { ?>
                <td>Party In Person</td>
                <td class="collon">:</td>
                <td><?php echo htmlentities($_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name'], ENT_QUOTES); ?></td>
    <?php if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) { ?>
                    <td>Matter Nature</td>
                    <td class="collon">:</td>
                    <td><?php echo ($view_data['urgent'] == 'Y') ? htmlentities('Urgent', ENT_QUOTES) : htmlentities('Ordinary', ENT_QUOTES); ?></td>
                    <?php
                }
            }
            ?>
        </tr>

<?php /*if ($allocated_to != ' ' && !empty($allocated_to)) { */?><!--
            <tr>
                <td>Efiling Admin</td>
                <td class="collon">:</td>
                <td><?php /*echo htmlentities($allocated_to, ENT_QUOTES) */?> </td>
    <?php /*if ($_SESSION['efiling_details']['efiling_for_type_id'] == E_FILING_FOR_HIGHCOURT) { */?>
                    <td>To Be Listed Before</td>
                    <td class="collon">:</td>
                    <td> <?php /*echo (!empty($view_data['bench_name'])) ? htmlentities($view_data['bench_name'] . ' Bench', ENT_QUOTES) : htmlentities('NA', ENT_QUOTES); */?></td>
            <?php /*} */?>
            </tr>
            --><?php
/*        }*/
        if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] != E_FILING_TYPE_CDE) {
            ?>

            <tr>
                <td>Payment Details</td>
                <td class="collon">:</td>
                <td colspan="4"><?php echo $view_data['payment_details']; ?></td>
            </tr>
    <?php if ($view_data['count_number_of_fee_pay'] > 1) { ?>
                <tr>
                    <td>Total Fee Paid</td>
                    <td class="collon">:</td>
                    <td colspan="4"><strong><?php echo htmlentities('Rs. ' . $view_data['total_amount'], ENT_QUOTES); ?></strong></td>
                </tr>
            <?php }
        }
        ?>

    </table>  
    <br>
    <div style="text-align: right;"><strong>Generated Date: <?php echo htmlentities(date('d-m-Y h:i:s A'), ENT_QUOTES) ?>  </strong></div>

</div>
