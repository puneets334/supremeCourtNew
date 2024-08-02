

<?php
if (!strpos($_SESSION['efiling_details']['breadcrumb_status'], '8')) {
    $s = 'CASE DATA ENTRY';
} else {
    $s = 'E FILE';
}


//$Array = array(Draft_Stage, Initial_Defected_Stage, DEFICIT_COURT_FEE, I_B_Defected_Stage, I_B_Rejected_Stage, E_REJECTED_STAGE);

$allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT, JAIL_SUPERINTENDENT);
$allowed_users_trash = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT);

if (in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
    $stages_array = array(Draft_Stage);
    if (in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {
        if($_SESSION['efiling_details']['ref_m_efiled_type_id']==1){
            //if (in_array(NEW_CASE_ACT_SECTION, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {
            if (in_array(NEW_CASE_COURT_FEE, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {

                /*if (!strpos($_SESSION['efiling_details']['breadcrumb_status'], '8')) { */?><!--   <a
                        href="<?php /*echo base_url('newcase/finalSubmit/forcde') */?>" class="btn btn-success btn-sm" id='cde'>SUBMIT
                    FOR CDE</a>
                <?php /*} else {
                    */?><a href="<?php /*echo base_url('newcase/finalSubmit') */?>" class="btn btn-success btn-sm" id='efil'>
                        SUBMIT FOR EFILING</a>
                    --><?php
/*
                } */?>
                <!--<a href="<?php /*echo base_url('newcase/finalSubmit') */?>" class="btn btn-success btn-sm" id='efil'> SUBMIT FOR EFILING</a>-->
                <?php
                if($_SESSION['login']['ref_m_usertype_id']==USER_ADVOCATE) {
                    ?>
                <button class="btn btn-success btn-sm" id='efilaor'> SUBMIT FOR EFILING </button>
            <?php }
                else{
                    ?>
                    <button class="btn btn-success btn-sm" id='efilpip'> SUBMIT FOR EFILING </button>
                        <?php
                }
                }
        }
        else{
            if (in_array(JAIL_PETITION_SUBORDINATE_COURT, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {


                ?><a href="<?php echo base_url('jailPetition/FinalSubmit') ?>" class="btn btn-success btn-sm" id='jail'>
                    SUBMIT FOR EFILING</a>
            <?php }
        }
        /*----------------*/

        //Pasted below
        /*$stages_array = array(Initial_Defected_Stage, I_B_Defected_Stage);
        if (in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {

            echo '<div class="col-md-8"><h5>Please ensure that you have cured the defects notified by admin. Then only proceed with final submit.</h5></div>';
            if (in_array(NEW_CASE_AFFIRMATION, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {
                echo '<a href="' . base_url('newcase/finalSubmit') . '" class="btn btn-success btn-sm">Final Submit</a>';
            }
        }*/

    }
    //Copied from above
    $stages_array = array(Initial_Defected_Stage, I_B_Defected_Stage);
    if (in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {

        echo '<div class="col-md-8"><h5>Please ensure that you have cured the defects notified by admin. Then only proceed with final submit.</h5></div>';
        //if (in_array(NEW_CASE_AFFIRMATION, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {
        if (in_array(NEW_CASE_COURT_FEE, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {
            echo '<a href="' . base_url('newcase/finalSubmit') . '" class="btn btn-success btn-sm">SUBMIT FOR RE-FILING </a>';
        }
    }
    $stages_array = array(Draft_Stage);
    if (in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_trash) && in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {
        ?>
        <!--<a href="<?php /*echo base_url('stage_list/trash'); */?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Are you sure that you really want to trash this record?')">Trash</a>-->
        <!--<a href="<?php /*echo base_url('userActions/trash'); */?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Are you sure that you really want to trash this record?')">Trash</a>-->
        <a class="btn btn-danger btn-sm" onclick="ActionToTrash('UAT')">Trash</a>
    <?php }
}

?>
<script type="text/javascript">
    $("#cde").click(function () {
// alert("helo");

        $.ajax({
            //type: "POST",
            //data: '',
            url: "<?php echo base_url('newcase/finalSubmit/valid_cde'); ?>",
            success: function (data) {
                //alert(data);
                var dataas = data.split('?');
                var ct = dataas[0];


                var dataarr = dataas[1].slice(1).split(',');
                // alert("data array "+dataarr[0]);


                if ((dataarr[0] != 2) && (dataarr[0] != 3) && (dataarr[0] != 6) && (dataarr[0] != 7)) {
                    // alert("all completed");
                    window.location.href = "<?php echo base_url('newcase/finalSubmit/forcde')?>";

                    // echo base_url('newcase/finalSubmit/forcde')

                }
                if ((dataarr[0]) == 2) {
                    alert("Petitioner details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/petitioner')?>";
                }

                if ((dataarr[0]) == 3) {
                    alert("Respondent details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/respondent')?>";
                }

                if (((dataarr[0]) == 7) && (ct != 5) && (ct != 6) && (ct != 7) && (ct != 8)) {
                    alert("Subordinate_courts details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/subordinate_court')?>";
                }

            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }


        });
        return false;
    });
    $("#efilaor").click(function () { //alert('efilaor'); return false;  alert('2222efilaor');
        $.ajax({
            //type: "POST",
            //data: '',

            url: "<?php echo base_url('newcase/AutoDiary/valid_efil'); ?>", // enabled this for auto diary generation
            success: function (data) {
                console.log(data);
                var dataas = data.split('?');
                var ct = dataas[0];


                var dataarr = dataas[1].slice(1).split(',');
                 //alert("data array "+dataarr[0]);


               // if ((dataarr[0] != 2) && (dataarr[0] != 3) && (dataarr[0] != 6) && (dataarr[0] != 7) && (dataarr[0]) != 8 && (dataarr[0]) != 10 && (dataarr[0]) != 12) {
               // if ((dataarr[0] != 2) && (dataarr[0] != 3) && (dataarr[0] != 6) && (dataarr[0] != 7) && (dataarr[0]) != 8 && (dataarr[0]) != 10) {
                if ((dataarr[0] != 2) && (dataarr[0] != 3) && (dataarr[0] != 7) && (dataarr[0]) != 8 && (dataarr[0]) != 10) {
                     alert("all completed");
                    window.location.href = "<?php echo base_url('newcase/AutoDiary')?>"; //ENABLED THIS FOR AUTO DIARY


                }
                if ((dataarr[0]) == 2) {
                    alert("Petitioner details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/petitioner')?>";
                }

                if ((dataarr[0]) == 3) {
                    alert("Respondent details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/respondent')?>";
                }

                if (((dataarr[0]) == 7) && (ct != 5) && (ct != 6) && (ct != 7) && (ct != 8)) {
                    alert("Subordinate_courts details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/subordinate_court')?>";
                }
                if (((dataarr[0]) == 8)) {
                    alert("Documents are not uploaded. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/uploadDocuments')?>";
                }
                if (((dataarr[0]) == 10)) {
                    alert("Court Fees not paid. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/courtFee')?>";
                }
                /*if (((dataarr[0]) == 12)) {
                    alert("Advocate affirmation not done. Redirecting to page !!");
                    window.location.href = "<//?php echo base_url('affirmation')?>";
                }*/

            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }


        });
        return false;
    });
    $("#efilpip").click(function () {
        $.ajax({
            //type: "POST",
            //data: '',
            url: "<?php echo base_url('newcase/finalSubmit/valid_efil'); ?>",
            /*url: "<//?php echo base_url('newcase/AutoDiary/valid_efil'); ?>",*/ // enabled this for auto diary generation
            success: function (data) {
                console.log(data);
                var dataas = data.split('?');
                var ct = dataas[0];


                var dataarr = dataas[1].slice(1).split(',');
                //alert("data array "+dataarr[0]);


                // if ((dataarr[0] != 2) && (dataarr[0] != 3) && (dataarr[0] != 6) && (dataarr[0] != 7) && (dataarr[0]) != 8 && (dataarr[0]) != 10 && (dataarr[0]) != 12) {
                // if ((dataarr[0] != 2) && (dataarr[0] != 3) && (dataarr[0] != 6) && (dataarr[0] != 7) && (dataarr[0]) != 8 && (dataarr[0]) != 10) {
                if ((dataarr[0] != 2) && (dataarr[0] != 3) && (dataarr[0] != 7) && (dataarr[0]) != 8 && (dataarr[0]) != 10) {
                    alert("all completed");
                    /* window.location.href = "<//?php echo base_url('newcase/AutoDiary')?>";*/ //ENABLED THIS FOR AUTO DIARY
                    window.location.href = "<?php echo base_url('newcase/finalSubmit')?>";
                    // echo base_url('newcase/finalSubmit/forcde')

                }
                if ((dataarr[0]) == 2) {
                    alert("Petitioner details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/petitioner')?>";
                }

                if ((dataarr[0]) == 3) {
                    alert("Respondent details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/respondent')?>";
                }

                if (((dataarr[0]) == 7) && (ct != 5) && (ct != 6) && (ct != 7) && (ct != 8)) {
                    alert("Subordinate_courts details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/subordinate_court')?>";
                }
                if (((dataarr[0]) == 8)) {
                    alert("Documents are not uploaded. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/uploadDocuments')?>";
                }
                if (((dataarr[0]) == 10)) {
                    alert("Court Fees not paid. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/courtFee')?>";
                }
                /*if (((dataarr[0]) == 12)) {
                    alert("Advocate affirmation not done. Redirecting to page !!");
                    window.location.href = "<//?php echo base_url('affirmation')?>";
                }*/

            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }


        });
        return false;
    });
    $("#jail").click(function () {

        $.ajax({
            //type: "POST",
            //data: '',
            url: "<?php echo base_url('jailPetition/FinalSubmit/validate'); ?>",
            success: function (data) {
                var dataarr = data.slice(1).split(',');

                if ((dataarr[0] != 1) && (dataarr[0] != 3)) {
                    window.location.href = "<?php echo base_url('jailPetition/FinalSubmit')?>";

                }
                if ((dataarr[0]) == 1) {
                    alert("Basic Case details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('jailPetition/BasicDetails')?>";
                }

                if ((dataarr[0]) == 3) {
                    alert("Earlier Court Details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('jailPetition/Subordinate_court')?>";
                }
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }


        });
        return false;
    });
</script>
