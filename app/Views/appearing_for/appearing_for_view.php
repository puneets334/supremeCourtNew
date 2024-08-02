<?php
if ($this->uri->segment(2) != 'view') {
    if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS) {
        $this->load->view('miscellaneous_docs/misc_docs_breadcrumb');
    } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) {
        $this->load->view('IA/ia_breadcrumb');
    }elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING) {
        $this->load->view('mentioning/mentioning_breadcrumb');
    }
}
?>

<div class="panel panel-default">
    <h4 style="text-align: center;color: #31B0D5">Appearing For Parties</h4>
    <div class="clearfix"></div>
<!--    <span class="text-danger"><center>[ Select party(s) to whom you represent in the present case. <br>-->
<!--            It is recommended to provide email and mobile of parties, which you representing, for your own convenience. ]</center></span>-->
    <div class="panel-body">
        <?php
        $attribute = array('class' => 'form-horizontal', 'name' => 'add_appearing_details', 'id' => 'add_appearing_details', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
        echo form_open('#', $attribute);
        if(!empty($this->session->userdata('radio_appearing_for')) && $this->session->userdata('radio_appearing_for') == 'N' && !empty($appearing_for_details))
        {
                        /*$pet_default_checked = ($appearing_for_details[0]['partytype'] == 'P' || $appearing_for_details[0]['appearing_for'] == NULL) ? 'checked' : NULL;
                        $res_checked = ($appearing_for_details[0]['partytype'] == 'R') ? 'checked' : NULL;
                        if ($pet_default_checked) {
                            $party_name_array = explode('##', $parties_details[0]['p_partyname']);
                            $party_sr_no_array = explode('##', $parties_details[0]['p_sr_no']);
                        } else {
                            $party_name_array = explode('##', $parties_details[0]['r_partyname']);
                            $party_sr_no_array = explode('##', $parties_details[0]['r_sr_no']);
                        }
                        $parties_list = array_combine($party_sr_no_array, $party_name_array);

                        if (($appearing_for_details[0]['partytype'] == 'P') || ($appearing_for_details[0]['partytype'] == 'R')) {
                            $saved_appearing_for = $appearing_for_details[0]['appearing_for'];
                            $saved_appearing_for = explode('$$', $saved_appearing_for);

                            $saved_appearing_for_email = $appearing_for_details[0]['p_email'];
                            $saved_appearing_for_email = explode('$$', $saved_appearing_for_email);

                            $saved_appearing_for_mobile = $appearing_for_details[0]['p_mobile'];
                            $saved_appearing_for_mobile = explode('$$', $saved_appearing_for_mobile);
                        } else {
                            $saved_appearing_for = NULL;
                            $saved_appearing_for_email = NULL;
                            $saved_appearing_for_mobile = NULL;
                        }
                        */?>
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Appearing For <span style="color: red">*</span> :</label>
                <div class="col-lg-9 col-md-9 col-sm-12  col-xs-12">
                    <div class="form-group">
                        <?php
                        if(!empty($this->session->userdata('radio_appearing_for')) && (($this->session->userdata('radio_appearing_for')=='I') || ($this->session->userdata('radio_appearing_for')=='N')))                               {
                            $petitioner_user_type_disabled='';
                            $respondent_user_type_disabled='';
                        }
                        else
                        {

                            if($appearing_for_details[0]['partytype'] == 'P')
                            {
                                $petitioner_user_type_disabled='';
                                $respondent_user_type_disabled='disabled';

                            }
                            elseif($appearing_for_details[0]['partytype'] == 'R')
                            {
                                $petitioner_user_type_disabled='disabled';
                                $respondent_user_type_disabled='';
                            }
                            else
                            {
                                //$petitioner_user_type_disabled='disabled';
                                //$respondent_user_type_disabled='disabled';
                                $petitioner_user_type_disabled='';
                                $respondent_user_type_disabled='';
                            }
                        }
                        //echo 'petitioner_user_type_disabled:'.$petitioner_user_type_disabled.'#respondent_user_type_disabled:'.$respondent_user_type_disabled.'#pet_default_checked:'.$pet_default_checked.'#res_checked:'.$res_checked.'<br>';
                        //$pet_default_checked = ($appearing_for_details[0]['partytype'] == 'P' || $appearing_for_details[0]['appearing_for'] == NULL) ? 'checked' : NULL;
                        $pet_default_checked = ($appearing_for_details[0]['partytype'] == 'P') ? 'checked' : NULL;
                        $res_checked = ($appearing_for_details[0]['partytype'] == 'R') ? 'checked' : NULL;
                        ?>
                        <label class="radio-inline"><input type="radio" name="user_type" class="user_type_PR" value="P" <?php echo $petitioner_user_type_disabled; ?>  <?php echo $pet_default_checked;?>><strong>Petitioner / Complainant</strong></label>
                        <label class="radio-inline"><input type="radio" name="user_type" class="user_type_PR" value="R" <?php echo $respondent_user_type_disabled; ?>  <?php echo $res_checked;?>><strong>Respondent / Accused</strong></label>

                        <?php
                        if ($pet_default_checked) {
                            $party_name_array = explode('##', $parties_details[0]['p_partyname']);
                            $party_sr_no_array = explode('##', $parties_details[0]['p_sr_no']);
                        } else {
                            $party_name_array = explode('##', $parties_details[0]['r_partyname']);
                            $party_sr_no_array = explode('##', $parties_details[0]['r_sr_no']);
                        }

                        $parties_list = array_combine($party_sr_no_array, $party_name_array);

                        if (($appearing_for_details[0]['partytype'] == 'P') || ($appearing_for_details[0]['partytype'] == 'R')) {
                            $saved_appearing_for = $appearing_for_details[0]['appearing_for'];
                            $saved_appearing_for = explode('$$', $saved_appearing_for);

                            $saved_appearing_for_email = $appearing_for_details[0]['p_email'];
                            $saved_appearing_for_email = explode('$$', $saved_appearing_for_email);

                            $saved_appearing_for_mobile = $appearing_for_details[0]['p_mobile'];
                            $saved_appearing_for_mobile = explode('$$', $saved_appearing_for_mobile);
                        } else {
                            $saved_appearing_for = NULL;
                            $saved_appearing_for_email = NULL;
                            $saved_appearing_for_mobile = NULL;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="onbehalf_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">Party Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Mobile</th>
                        <th class="text-center">Select</th>
                    </tr>
                    </thead>
                    <tbody class="parties_list_data">
                    <?php
                    //echo "<pre>"; print_r($parties_list); echo "</pre>";
                    if (count($parties_list) > 0) {
                        $i = 1;
                        foreach ($parties_list as $key => $value) {

                            $selected = (in_array($key, $saved_appearing_for)) ? 'checked' : NULL;
                            $saved_sr_no = array_search($key, $saved_appearing_for);
                            $email = $selected ? $saved_appearing_for_email[$saved_sr_no] : NULL;
                            $mobile = $selected ? $saved_appearing_for_mobile[$saved_sr_no] : NULL;
                            $appearing_id = $appearing_for_details[0]['id'];
                            $appearing_contact_id = $appearing_for_details[0]['contact_tbl_id'];
                            ?>
                            <tr>
                                <td><input class="form-control" name="party_name[]" type="text"  value="<?php echo_data($value); ?>" ></td>
                                <td><input class="form-control" name="party_email[]" type="email" placeholder="Email"  value="<?php echo_data($email); ?>"  ></td>
                                <td><input class="form-control" name="party_mob[]" placeholder="Mobile"  value="<?php echo_data($mobile); ?>" type="text" maxlength="10" minlength="10" value="" ></td>
                                <td class="text-center"><input class="checkBoxClass" type="checkbox"  name="selected_party[]" value="<?php echo url_encryption($i . '$$$' . $key . '$$$' . $appearing_id . '$$$' . $appearing_contact_id); ?>" <?php echo $selected; ?>></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
           }
            else{
            ?>
            <span class="text-danger"><center>[ Select party(s) to whom you represent in the present case. <br>
            It is recommended to provide email and mobile of parties, which you representing, for your own convenience. ]</center></span>
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Appearing For <span style="color: red">*</span> :</label>
                <div class="col-lg-9 col-md-9 col-sm-12  col-xs-12">
                    <div class="form-group">
                        <?php
                        if(!empty($this->session->userdata('radio_appearing_for')) && (($this->session->userdata('radio_appearing_for')=='I') || ($this->session->userdata('radio_appearing_for')=='N')))                               {
                                $petitioner_user_type_disabled='';
                                $respondent_user_type_disabled='';
                            }
                        else
                            {

                                if($appearing_for_details[0]['partytype'] == 'P')
                                {
                                    $petitioner_user_type_disabled='';
                                    $respondent_user_type_disabled='disabled';

                                }
                                elseif($appearing_for_details[0]['partytype'] == 'R')
                                {
                                    $petitioner_user_type_disabled='disabled';
                                    $respondent_user_type_disabled='';
                                }
                                else
                                {
                                    //$petitioner_user_type_disabled='disabled';
                                    //$respondent_user_type_disabled='disabled';
                                    $petitioner_user_type_disabled='';
                                    $respondent_user_type_disabled='';
                                }
                            }
                            //echo 'petitioner_user_type_disabled:'.$petitioner_user_type_disabled.'#respondent_user_type_disabled:'.$respondent_user_type_disabled.'#pet_default_checked:'.$pet_default_checked.'#res_checked:'.$res_checked.'<br>';
                        //$pet_default_checked = ($appearing_for_details[0]['partytype'] == 'P' || $appearing_for_details[0]['appearing_for'] == NULL) ? 'checked' : NULL;
                        $pet_default_checked = ($appearing_for_details[0]['partytype'] == 'P') ? 'checked' : NULL;
                        $res_checked = ($appearing_for_details[0]['partytype'] == 'R') ? 'checked' : NULL;
                        ?>
                        <label class="radio-inline"><input type="radio" name="user_type" class="user_type_PR" value="P" <?php echo $petitioner_user_type_disabled; ?>  <?php echo $pet_default_checked;?>><strong>Petitioner / Complainant</strong></label>
                        <label class="radio-inline"><input type="radio" name="user_type" class="user_type_PR" value="R" <?php echo $respondent_user_type_disabled; ?>  <?php echo $res_checked;?>><strong>Respondent / Accused</strong></label>

                        <?php
                        if ($pet_default_checked) {
                            $party_name_array = explode('##', $parties_details[0]['p_partyname']);
                            $party_sr_no_array = explode('##', $parties_details[0]['p_sr_no']);
                        } else {
                            $party_name_array = explode('##', $parties_details[0]['r_partyname']);
                            $party_sr_no_array = explode('##', $parties_details[0]['r_sr_no']);
                        }

                        $parties_list = array_combine($party_sr_no_array, $party_name_array);

                        if (($appearing_for_details[0]['partytype'] == 'P') || ($appearing_for_details[0]['partytype'] == 'R')) {
                            $saved_appearing_for = $appearing_for_details[0]['appearing_for'];
                            $saved_appearing_for = explode('$$', $saved_appearing_for);

                            $saved_appearing_for_email = $appearing_for_details[0]['p_email'];
                            $saved_appearing_for_email = explode('$$', $saved_appearing_for_email);

                            $saved_appearing_for_mobile = $appearing_for_details[0]['p_mobile'];
                            $saved_appearing_for_mobile = explode('$$', $saved_appearing_for_mobile);
                        } else {
                            $saved_appearing_for = NULL;
                            $saved_appearing_for_email = NULL;
                            $saved_appearing_for_mobile = NULL;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="onbehalf_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">Party Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Mobile</th>
                        <th class="text-center">Select</th>
                    </tr>
                    </thead>
                    <tbody class="parties_list_data">
                    <?php
                    //echo "<pre>"; print_r($parties_list); echo "</pre>";
                    if (count($parties_list) > 0) {
                        $i = 1;
                        foreach ($parties_list as $key => $value) {

                            $selected = (in_array($key, $saved_appearing_for)) ? 'checked' : NULL;
                            $saved_sr_no = array_search($key, $saved_appearing_for);
                            $email = $selected ? $saved_appearing_for_email[$saved_sr_no] : NULL;
                            $mobile = $selected ? $saved_appearing_for_mobile[$saved_sr_no] : NULL;
                            $appearing_id = $appearing_for_details[0]['id'];
                            $appearing_contact_id = $appearing_for_details[0]['contact_tbl_id'];
                            ?>
                            <tr>
                                <td><input class="form-control" name="party_name[]" type="text"  value="<?php echo_data($value); ?>" readonly=""></td>
                                <td><input class="form-control" name="party_email[]" type="email" placeholder="Email"  value="<?php echo_data($email); ?>" ></td>
                                <td><input class="form-control" name="party_mob[]" placeholder="Mobile"  value="<?php echo_data($mobile); ?>" type="text" maxlength="10" minlength="10" value="" ></td>
                                <td class="text-center"><input class="checkBoxClass" type="checkbox" name="selected_party[]" value="<?php echo url_encryption($i . '$$$' . $key . '$$$' . $appearing_id . '$$$' . $appearing_contact_id); ?>" <?php echo $selected; ?>></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>


        <?php
        }
        ?>
        <div class="text-center">
            <a href="<?= base_url('case_details'); ?>" class="btn btn-primary btnPrevious" type="button">Previous</a>            
            <?php if (isset($appearing_for_details[0]['appearing_for']) && !empty($appearing_for_details[0]['appearing_for'])) { ?>
                <input type="submit" class="btn btn-success" id="save_efiling_for" name="submit" value="UPDATE">
                <a href="<?= base_url('on_behalf_of'); ?>" class="btn btn-primary btnNext" type="button">Next</a>
            <?php } else { ?>
                <input type="submit" class="btn btn-success" id="save_efiling_for" name="submit" value="SAVE">
            <?php } ?>

        </div>
        <?php
        echo form_close();
        ?>
    </div>
</div>
</div> 
</div>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $('#add_appearing_details').on('submit', function () {
            $(".user_type_PR").prop("disabled", false);
            var form_data = $(this).serialize();
            $('#modal_loader').show();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('appearing_for/appearing_for/save_appearing_details'); ?>",
                data: form_data,
                success: function (data) {
                    $(".user_type_PR").prop("disabled", true);
                    $('#modal_loader').hide();
                    var resArr = data.split('@@@');
                    if (resArr[0] == 1) {
                        $('#msg').show();
                        $(".form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                        setTimeout(function () {
                            location.reload();
                        });
                    }
                    if (resArr[0] == 2) {
                        $('#msg').show();
                        $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                        setTimeout(function () {
                            location.reload();
                        });
                    }
                    if (resArr[0] == 3) {
                        $('#msg').show();
                        $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");                        
                    }
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                },
                error: function () {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
            return false;
        });
    });

    $('[name="user_type"]').change(function () {
        var partytype = $(this).val();
        
        $('#modal_loader').show();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('appearing_for/ajaxcalls/get_parties_list'); ?>",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, partytype: partytype},
            success: function (data) {
                $('#modal_loader').hide();
                var resArr = data.split('@@@');
                if (resArr[0] == 1) {
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                } else if (resArr[0] == 2) {
                    $('.parties_list_data').html(resArr[1]);
                } 
                $.getJSON("<?php echo base_url() . 'csrftoken'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    });



</script>