<?php
if (isset($_SESSION['efiling_for_details']['case_type_pet_title']) && !empty($_SESSION['efiling_for_details']['case_type_pet_title'])) {
    $case_type_pet_title = htmlentities($_SESSION['efiling_for_details']['case_type_pet_title'], ENT_QUOTES);
} elseif (isset($efiling_civil_data[0]['case_type_pet_title']) && !empty($efiling_civil_data[0]['case_type_pet_title'])) {
    $case_type_pet_title = htmlentities($efiling_civil_data[0]['case_type_pet_title'], ENT_QUOTES);
} else {
    $case_type_pet_title = htmlentities('Caveator', ENT_QUOTES);
}


if (isset($_SESSION['efiling_for_details']['case_type_res_title']) && !empty($_SESSION['efiling_for_details']['case_type_res_title'])) {
    $case_type_res_title = htmlentities($_SESSION['efiling_for_details']['case_type_res_title'], ENT_QUOTES);
} elseif (isset($efiling_civil_data[0]['case_type_res_title']) && !empty($efiling_civil_data[0]['case_type_res_title'])) {
    $case_type_res_title = htmlentities($efiling_civil_data[0]['case_type_res_title'], ENT_QUOTES);
} else {
    $case_type_res_title = htmlentities('Caveatee', ENT_QUOTES);
}



if ($this->uri->segment(2) == 'caveat') {
    include 'caveator_form.php';
} elseif ($this->uri->segment(2) == 'caveatee') {
    include 'caveatee_form.php';
} elseif ($this->uri->segment(2) == 'extra_party') {
    include 'extra_party_form.php';
} elseif ($this->uri->segment(2) == 'subordinate_court') {
   // include 'add_subordinate_court.php';
    $this->load->view('caveat/caveat_breadcrumb');
    $this->load->view('caveat/caveat_subordinate_court_view');

} elseif ($this->uri->segment(1) == 'uploadDocuments' || $this->uri->segment(1) == 'documentIndex') {
    //$this->load->view('uploadDocuments/upload_document');
    $this->load->view('documentIndex/documentIndex_view');
} elseif ($this->uri->segment(1) == 'documentIndex') {
    $this->load->view('documentIndex/documentIndex_view');
} elseif ($this->uri->segment(1) == 'courtFee') {
    $this->load->view('newcase/courtFee_view');
} elseif ($this->uri->segment(2) == 'view') {
    include 'caveat_preview.php';
}
?>
</div>
</div>
</div>
</div>             
</div>
</div>
</div>


<script>
    $('#pet_dob').datepicker({
        onSelect: function (value) {
            var parts = value.split("/");
            var day = parts[0] && parseInt(parts[0], 10);
            var month = parts[1] && parseInt(parts[1], 10);
            var year = parts[2] && parseInt(parts[2], 10);
            var str = month + '/' + day + '/' + year;
            var today = new Date(),
                    dob = new Date(str),
                    age = new Date(today - dob).getFullYear() - 1970;
            $('#pet_age').val(age);
        },
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:-1",
        dateFormat: "dd/mm/yy",
        defaultDate: '-40y'
    });

    $('#res_dob').datepicker({
        onSelect: function (value) {
            var parts = value.split("/");
            var day = parts[0] && parseInt(parts[0], 10);
            var month = parts[1] && parseInt(parts[1], 10);
            var year = parts[2] && parseInt(parts[2], 10);
            var str = month + '/' + day + '/' + year;
            var today = new Date(),
                    dob = new Date(str),
                    age = new Date(today - dob).getFullYear() - 1970;
            $('#res_age').val(age);
        },
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:-1",
        dateFormat: "dd/mm/yy",
        defaultDate: '-40y'
    });
    $('#cause_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd/mm/yy",
        maxDate: new Date

    });
    $('#filing_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd/mm/yy",
        maxDate: new Date
    });
    $('#decision_date,#cc_applied_date,#cc_ready_date,#offence_date,#charge_sheet_date,#accident_date,#fir_file_date,\n\
       #trial_decision_date,#trial_cc_applied_date,#trial_cc_ready_date,#hc_decision_date,#hc_cc_applied_date,\n\
       #hc_cc_ready_date,#case_order_dt').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd/mm/yy",
        maxDate: new Date
    });

    function compareDate(element) {

        if (element == 'cc_applied_date') {
            var decision_dt = $('#decision_date').val();
            var cc_applied_dt = $('#cc_applied_date').val();
            $('#cc_ready_date').val('');
            if (decision_dt == '' || decision_dt == 'NULL') {
                alert('First select decision date');
                $('#cc_applied_date').val('');

            } else {
                var decision_dt = $.datepicker.parseDate('dd/mm/yy', decision_dt);
                var cc_applied_dt = $.datepicker.parseDate('dd/mm/yy', cc_applied_dt);
                if (decision_dt > cc_applied_dt)
                {
                    alert('CC Applied Date is greater than OR Equal to Date of Decision');
                    $('#cc_applied_date').val('');
                }
            }
        } else if (element == 'cc_ready_date') {
            var decision_dt = $('#decision_date').val();
            var cc_applied_dt = $('#cc_applied_date').val();
            var cc_ready_dt = $('#cc_ready_date').val();
            if (decision_dt == '' || decision_dt == 'NULL') {
                alert('First select decision date');
                $('#cc_ready_date').val('');
            } else if (cc_applied_dt == '' || cc_applied_dt == 'NULL') {
                alert('Select CC Applied Date');
                $('#cc_ready_date').val('');
            } else {
                var cc_applied_dt = $.datepicker.parseDate('dd/mm/yy', cc_applied_dt);
                var cc_ready_dt = $.datepicker.parseDate('dd/mm/yy', cc_ready_dt);
                if (cc_applied_dt > cc_ready_dt) {
                    alert('CC Ready date is greater than OR Equal to CC Applied Date');
                    $('#cc_ready_date').val('');
                }
            }
        } else if (element == 'trial_cc_applied_date') {
            var trial_decision_dt = $('#trial_decision_date').val();
            var trial_cc_applied_dt = $('#trial_cc_applied_date').val();
            $('#trial_cc_ready_date').val('');
            if (trial_decision_dt == '' || trial_decision_dt == 'NULL') {
                alert('First select decision date');
                $('#trial_cc_applied_date').val('');
            } else {
                var trial_decision_dt = $.datepicker.parseDate('dd/mm/yy', trial_decision_dt);
                var trial_cc_applied_dt = $.datepicker.parseDate('dd/mm/yy', trial_cc_applied_dt);
                if (trial_decision_dt > trial_cc_applied_dt) {
                    alert('CC Applied Date is greater than OR Equal to Date of Decision');
                    $('#trial_cc_applied_date').val('');
                }
            }
        } else if (element == 'trial_cc_ready_date') {
            var trial_decision_dt = $('#trial_decision_date').val();
            var trial_cc_applied_dt = $('#trial_cc_applied_date').val();
            var trial_cc_ready_dt = $('#trial_cc_ready_date').val();
            if (trial_decision_dt == '' || trial_decision_dt == 'NULL') {
                alert('First select decision date');
                $('#trial_cc_ready_date').val('');
            } else if (trial_cc_applied_dt == '' || trial_cc_applied_dt == 'NULL') {
                alert('Select CC Applied Date');
                $('#trial_cc_ready_date').val('');
            } else {
                var trial_cc_applied_dt = $.datepicker.parseDate('dd/mm/yy', trial_cc_applied_dt);
                var trial_cc_ready_dt = $.datepicker.parseDate('dd/mm/yy', trial_cc_ready_dt);
                if (trial_cc_applied_dt > trial_cc_ready_dt) {
                    alert('CC Ready Date is greater than OR Equal to CC Applied date');
                    $('#trial_cc_ready_date').val('');
                }
            }
        } else if (element == 'hc_cc_applied_date') {
            var hc_decision_dt = $('#hc_decision_date').val();
            var hc_cc_applied_dt = $('#hc_cc_applied_date').val();
            $('#hc_cc_ready_date').val('');
            if (hc_decision_dt == '' || hc_decision_dt == 'NULL') {
                alert('First select decision date');
                $('#hc_cc_applied_date').val('');
            } else {
                var hc_decision_dt = $.datepicker.parseDate('dd/mm/yy', hc_decision_dt);
                var hc_cc_applied_dt = $.datepicker.parseDate('dd/mm/yy', hc_cc_applied_dt);
                if (hc_decision_dt > hc_cc_applied_dt) {
                    alert('CC Applied Date is greater than OR Equal to Date of Decision');
                    $('#hc_cc_applied_date').val('');
                }
            }
        } else if (element == 'hc_cc_ready_date') {
            var hc_decision_dt = $('#hc_decision_date').val();
            var hc_cc_applied_dt = $('#hc_cc_applied_date').val();
            var hc_cc_ready_dt = $('#hc_cc_ready_date').val();
            if (hc_decision_dt == '' || hc_decision_dt == 'NULL') {
                alert('First select decision date');
                $('#hc_cc_ready_date').val('');
            } else if (hc_cc_applied_dt == '' || hc_cc_applied_dt == 'NULL') {
                alert('Select CC Applied Date');
                $('#hc_cc_ready_date').val('');
            } else {
                var hc_cc_applied_dt = $.datepicker.parseDate('dd/mm/yy', hc_cc_applied_dt);
                var hc_cc_ready_dt = $.datepicker.parseDate('dd/mm/yy', hc_cc_ready_dt);
                if (hc_cc_applied_dt > hc_cc_ready_dt) {
                    alert('CC Ready Date is greater than OR Equal to CC Applied date');
                    $('#hc_cc_ready_date').val('');
                }
            }
        }
    }

<?php if ($efiling_civil_data[0]['pet_legal_heir'] == 'Y') { ?>
        $(document).ready(function () {
            document.getElementById('address_label_name').innerHTML = 'Address :';
        });
<?php } elseif ($efiling_civil_data[0]['res_legal_heir'] == 'Y') { ?>
        $(document).ready(function () {
            document.getElementById('address_label_name_res').innerHTML = 'Address :';
        });
<?php } else { ?>
        $(document).ready(function () {
         //   document.getElementById('address_label_name').innerHTML = 'Address <span style="color: red">*</span> :';
          //  document.getElementById('address_label_name_res').innerHTML = 'Address <span style="color: red">*</span> :';
        });
<?php } ?>
</script>