<style>
    body {
        background-color: #ffffff !important;
    }
#declineButton {
    background-attachment: scroll;
    background-clip: border-box;
    background-color: rgb(13 131 21);
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
    margin-right: 248px;
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

$attribute = array('class' => 'form-horizontal', 'name' => 'vacation', 'id' => 'vacation', 'autocomplete' => 'off' , 'enctype' => 'multipart/form-data');
echo form_open('#', $attribute);

form_close();
?>

    <h3 style="text-align: center;"> Advance Summer Vacation List <?=date('Y');?></h3>
<div align="right">
    <div id="declineButton" class="ui-button ui-widget ui-corner-all" onclick="javascript:confirmBeforeDecline();"><strong >Decline Selected Case(s)</strong></div>
    </div>
<input type="hidden" id="aorCode" name="aorCode" value="<?=$this->session->userdata['login']['aor_code']?>">
<input type="hidden" id="fromIP" name="fromIP" value="<?=getClientIP()?>">


<table id="example1" class="display" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>#</th>
            <th >Case Details</th>
            <th >Cause Title</th>
           <th>Advocate</th>
           <!-- <th width="30%">Advocate</th>-->
            <th >Decline/Listed</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>#</th>
            <th>Case Details</th>
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
                <!--   <td ><?/*=date('d-m-Y', strtotime($r['filing_date']));*/?></td>-->
                <!--<td><?/*=$r['advocate'];*/?></td>-->


                <td>
                    <?php
                    if (!empty($r['declined_by_aor']) && $r['declined_by_aor'] === 't') { $diary_no=$r['diary_no'];
                         echo "<a class='btn btn-xs btn-primary text-center'   title=\"List\"  onclick=\"javascript:confirmBeforeList($diary_no);\">Restore</a><br/>";

                        ?>
                        <span style="color: red;">Declined</span>
                        <?php
                    } else {
                        if($r['is_fixed']!='Y') {
                            echo "<input type='checkbox' name='vacationList' id='vacationList' value='$r[diary_no]'>";
                        }
                        else
                        {
                            echo "<span style='color:green;'>Fixed For <br> Vacation</span><br/>";
                        }

                    }

                    ?>
                </td>
            </tr>
            <?php } } ?>

    </tbody>
</table>



<script>
    function confirmBeforeDecline() {

        var allVals = [];
        var noOfCases;
       $("input:checkbox[name=vacationList]:checked").each(function() {
            allVals.push($(this).val());
        });
        noOfCases=allVals.length;
     if(noOfCases<1)
     {
         alert('Please select atleast one Case which need to be Decline');
         return false;
     }
     else {

         var choice = confirm("I hereby agree with the Notice dated..... and matter so declined are after serving a copy there of on other side for Not Listing the matter before Vacation Bench during the Summer Vacation, <?=$current_year=date('Y');?> \n\n Do you really want to decline the case.....?");
         if (choice === true) {
             declineVacationCase(allVals);
         }
         else
             return false;

     }
    }

    function confirmBeforeList(diary_no)
    {
        var choice = confirm('Do you really want to List the Selected Case.....?');
        if(choice === true) {
            ListVacationCase(diary_no);
        }

    }

    function declineVacationCase(allVals)
    {
        var userIP=$('#fromIP').val();
       // var userID=$('#user_mid').val();
         var userID='<?php echo $this->session->userdata['login']['id'];?>';


        var aorCode=$('#aorCode').val();

       //alert(userIP);
       //alert(userID);
       //alert(aorCode);
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#msg').hide();
        $(".form-response").html('');
         $.ajax
        ({
            url: "<?=base_url('vacation/advance/declineVacationListCasesAOR')?>",
            type: "POST",
            data: {diary_no: allVals,userIP:userIP,userID:userID,aorCode:aorCode,CSRF_TOKEN: CSRF_TOKEN_VALUE},
            cache: false,
            success: function(data)
            {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });

                var resArr = data.split('@@@');
                if (resArr[0] == 1) {
                    alert(resArr[1]);
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                } else if (resArr[0] == 2) {
                    alert('Selected Case with Diary No:('+allVals+') Successfully Declined');
                    location.reload();
                }



                //getVacationAdvanceListAOR();

            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
                alert('Selected Case with Diary No:('+allVals+') Successfully Declined');
            }
        });
    }

    function ListVacationCase(diary_no)
    {
        var userIP=$('#fromIP').val();
        var userID=$('#user_mid').val();
        var aorCode=$('#aorCode').val();


        userIP=$('#fromIP').val();
       // var userID=$('#user_mid').val();
        var userID='<?php echo $this->session->userdata['login']['id'];?>';



        aorCode=$('#aorCode').val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#msg').hide();
        $(".form-response").html('');
        $.ajax
        ({
            url: "<?=base_url('vacation/advance/restoreVacationAdvanceListAOR')?>",
            type: "POST",
            data: {diary_no: diary_no,userIP:userIP,userID:userID,aorCode:aorCode,CSRF_TOKEN: CSRF_TOKEN_VALUE},
            cache: false,
            success: function (data)
            {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });

                var resArr = data.split('@@@');
                if (resArr[0] == 1) {
                    alert(resArr[1]);
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                } else if (resArr[0] == 2) {
                    alert('Selected Case with Diary NO:'+diary_no+' Successfully Restore');
                    location.reload();
                }


                //getVacationAdvanceListAOR();

            },
            error: function () {
                alert('ERROR');
            }
        });
    }

</script>

