<style>
    body {
        background-color: #ffffff !important;
    }
#declineButton {
    background-attachment: scroll;
    background-clip: border-box;
    background-color: rgb(26, 26, 26);
    background-image: none;
    background-origin: padding-box;
    background-position: 0% 0%;
    background-position-x: 0%;
    background-position-y: 0%;
    background-repeat: repeat;
    background-size: auto auto;
    border-bottom-color: rgb(255, 255, 255);
    border-bottom-left-radius: 3px;
    border-bottom-right-radius: 3px;
    border-bottom-style: none;
    border-bottom-width: 0px;
    border-image-outset: 0;
    border-image-repeat: stretch stretch;
    border-image-slice: 100%;
    border-image-source: none;
    border-image-width: 1;
    border-left-color: rgb(255, 255, 255);
    border-left-style: none;
    border-left-width: 0px;
    border-right-color: rgb(255, 255, 255);
    border-right-style: none;
    border-right-width: 0px;
    border-top-color: rgb(255, 255, 255);
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    border-top-style: none;
    border-top-width: 0px;
    color: rgb(255, 255, 255);
    cursor: pointer;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    line-height: 14px;
    margin-bottom: 0px;
    margin-left: 0px;
    margin-right: 0px;
    margin-top: 0px;
    padding-bottom: 4px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 4px;
}
#declineButton:hover {
    background-color: rgb(200, 26, 26);
}
</style>

<SCRIPT>


    $(document).ready(function() {

        $('#example1').DataTable({
            "ordering": false
        });
        $('#example2').DataTable({
            "ordering": false
        });
    } );
</SCRIPT>

<?php
if(!is_vacation_advance_list_duration()){
    //echo 'Advance Summer Vacation List not authorized access';
    exit();
}
//echo 'Vacation Advance List Duration='.$is_action;
?>

    <h3 style="text-align: center;">  LIST OF MATTERS DECLINED BY SELF <?=date('Y');?></h3>

<table id="example1" class="display" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>#</th>
            <th >Case No @ Diary No.</th>
            <th >Cause Title</th>
           <th>Advocate</th>
           <!-- <th width="30%">Advocate</th>-->
            <th >Decline/Listed</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>#</th>
            <th>Case No @ Diary No.</th>
            <th style="width:25%;">Cause Title</th>
            <th style="width:25%;">Advocate</th>
           <!-- <th>Advocate</th>-->
            <th width="15%">Decline/Listed</th>
        </tr>
        </tfoot>
        <tbody>
        <?php
        $psrno = "1";
        $srNo=0;
        if (!empty($vacation_advance_list)){
        foreach ($vacation_advance_list as $r){
        //while ($r = $stmt->fetch()) {
            if ($r['diary_no'] == $r['conn_key'] OR $r['conn_key'] == 0) {
                // $print_brdslno = $row['brd_slno'];
                $print_brdslno=$psrno;
                $print_srno = $psrno;
                $con_no = "0";
                $is_connected = "";
            } else if ($r['main_or_connected'] == 1) {
                $print_brdslno = "&nbsp;".$print_srno.".".++$con_no;
                $is_connected = "<span style='color:red;'>Connected</span><br/>";
            }
            //$srNo++;
                      $srNo++;
            ?>
            <tr>
                <td><?= $srNo;?>
                    <?php
                    if ($is_connected != '') {
                        //$print_srno = "";

                    } else {
                        $print_srno = $print_srno;
                        $psrno++;
                    } ?>


                </td>
                <td style="text-align: left;">
                    <?= $r['case_no'];?>
                    <br>
                    <?php if($r['main_or_connected']==1) {
                        echo "<span style='color:red;'>Connected</span><br/>";
                    }?>

                </td>
                <td style="text-align: left;"><?= sprintf('%s' ,  $r['cause_title']);?></td>
                <td style="text-align: left;"><?= sprintf('%s' ,  $r['advocate']);?></td>

                <td>
                    <?PHP
                    if ($r['declined_by_aor'] == 't') { $diary_no=$r['diary_no'];
                        ?>
                        <span style="color: red;">Declined</span>
                        <?php
                    } else {
                       echo '<span style="color: red;">Pending Declined</span>';
                    }

                    ?>
                </td>
            </tr>
            <?php } } ?>

    </tbody>
</table>
        <hr>
        <br><br>
<?php if (!empty($matters_declined_by_counter)){?>

            <h3 style="text-align: center;">LIST OF MATTERS DECLINED BY COUNTER PART <?=$current_year=date('Y');?> </h3>

            <table id="example2" class="display" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>#</th>
                <th >Case Details</th>
                <th style="width:50%">Message</th>
                <th>Decline Date@Time</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#</th>
                <th >Case Details</th>
                <th >Message</th>
                <th>Decline Date@Time</th>
            </tr>
            </tfoot>
            <tbody>
             <tr>
                    <td></td>
                    <td style="text-align: left;"></td>
                    <td style="text-align: left;"></td>
                    <td style="text-align: left;"></td>
                </tr>
            <?php
            $psrno1 = "1";
            $srNo1=0;
                foreach ($matters_declined_by_counter as $r1){
                $srNo1++;
                ?>
                <tr>
                    <td><?= $srNo1;?></td>
                    <td style="text-align: left;"><?= $r1['case_no'];?></td>
                    <td style="text-align: left;"><?= sprintf('%s' ,  $r1['msg']);?></td>
                    <td style="text-align: left;"><?= sprintf('%s' ,  $r1['updated_on']);?></td>
                </tr>
                <?php  }  ?>


        </tbody>
        </table>
<?php }  ?>

