<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="msg">
                <?php
                if (isset($_SESSION['MSG']) && !empty($_SESSION['MSG'])) {
                    echo $_SESSION['MSG'];
                } unset($_SESSION['MSG']);
                ?></div> 
        </div>
    </div>    
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">            
            <div class="x_panel">                
                <?php if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN) { ?>
                    <div class="x_title">
                        <h2><i class="fa  fa-newspaper-o"></i> Performa(s) </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php
                        if (!$get_data) {
                            $action = 'assistance/performas/add_notice_circurlar';
                        } else {
                            $action = 'assistance/performas/add_notice_circurlar/' . url_encryption($get_data[0]['id']);
                        }
                        $attribute = array('class' => 'form-horizontal form-label-left', 'id' => 'add_notice_circurlar', 'name' => 'add_notice_circurlar', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                        echo form_open($action, $attribute);
                        ?>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-5"> Title <span style="color: red">*</span> :</label>
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <input id="performa_title" name="performa_title" value="<?php echo htmlentities($get_data[0]['performa_title'], ENT_QUOTES); ?>" placeholder="News Title" maxlength="250"  class="form-control" type="text">
                                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Title only accept Charaters and Spaces(eg. ABC XYZ).">
                                                <i class="fa fa-question-circle-o" ></i>
                                            </span>
                                        </div> 
                                        <?php echo ($this->session->flashdata('performa_title') != NULL) ? $this->session->flashdata('performa_title') : NULL; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-5">PDF <span style="color: red">*</span> :</label>
                                    <div class="col-sm-7">
                                        <input id="news_doc"  name="news_doc"  value=""  type="file">
                                        <?php if (!empty($get_data[0]['file_name'])) { ?>
                                            <span class="help-block"><a href="<?php echo base_url('assistance/performas/view/' . url_encryption($get_data[0]['id'])); ?>" class="btn btn-link" target="_blank">View Old File</a></span>
                                        <?php } ?>
                                        <?php echo ($this->session->flashdata('news_doc') != NULL) ? $this->session->flashdata('news_doc') : NULL; ?>
                                    </div>
                                </div> 
                                <br>
                            </div> 


                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">

                                    <?php if ($get_data[0] == '') { ?>
                                        <input type="submit" name="add_notice" value="Add" class="btn btn-success">
                                    <?php } else { ?>
                                        <input type="submit" name="update_notice" value="Update" class="btn btn-success">
                                    <?php } ?>
                                    <button onclick="location.href = '<?php echo base_url('assistance/performas'); ?>'" class="btn btn-primary" type="reset">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                <?php } else { ?> 

                    <h2><i class="fa  fa-newspaper-o"></i> Proforma(s)</h2>
                    <div class="clearfix"></div>

                <?php } ?>
            </div>
        </div>
    </div>        
    <!------------Table--------------------->

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr class="success input-sm" role="row" >
                                <th>#</th>
                                <th> Proforma(s) </th>
                                <?php if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN) { ?>
                                    <th>Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($notice_circualrs as $itm) {
                                $lbl_is_notice_circular = $tim['is_circular'] ? 'Circular' : 'Notice';
                                ?>
                                <tr>
                                    <td width="5%"> <?php echo htmlentities($i++, ENT_QUOTES); ?></td>
                                    <td><a href="<?php echo base_url('assistance/performas/view/' . url_encryption($itm['id'])); ?>" target="blank"><i class="fa fa-file-pdf-o danger" aria-hidden="true"  style="color:red"></i>
                                            &nbsp;<?php echo htmlentities($itm['performa_title'], ENT_QUOTES); ?><br>
                                            (<?php echo htmlentities(date('d-m-Y', strtotime($itm['create_date'])), ENT_QUOTES); ?>)
                                        </a>
                                    </td> 
                                    <?php if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN) { ?>
                                        <td width="15%">
                                            <a href="<?php echo base_url('assistance/performas/edit/' . url_encryption($itm['id'])); ?>" class="btn btn-primary" role="button"><i class="fa fa-pencil"></i></a>
                                            <?php if ($itm['is_deleted'] == 'f') { ?>
                                                <a href="<?php echo base_url('assistance/performas/action/' . url_encryption($itm['id'] . '$$' . 'D')); ?>" class="btn btn-danger" role="button" onclick="return confirm('Are you sure, want to Deactivate this Notice/Circular ?')">Deactivate</a><?php } ?>
                                            <?php if ($itm['is_deleted'] == 't') { ?>
                                                <a href="<?php echo base_url('assistance/performas/action/' . url_encryption($itm['id'] . '$$' . 'A')); ?>" class="btn btn-success" role="button" onclick="return confirm('Are you sure, want to Activate this Notice/Circular ?')">Activate</a><?php } ?>

                                        </td> 
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!------------Table--------------------->
    </div>
</div>
</div>
<?php if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN) { ?>
    <script type="text/javascript">

        $(document).ready(function () {
            $('.news_datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy",
                minDate: new Date,
                yearRange: '2000:2099'
            });


            $.validator.addMethod('onecheck', function (value, ele) {
                return $("input:checked").length >= 1;
            }, 'Please Select Atleast One CheckBox')

            $('#getResult').on('submit', function() {
            // $('#add_notice_circurlar').validate({
                focusInvalid: true,
                ignore: ":hidden",
                rules: {
                    performa_title: {
                        required: true
                    }, deactivate_date: {
                        required: true

                    },

                    "pdf_is[]": {
                        required: true,
                        minlength: 1
                    }


                },
                messages: {
                    performa_title: {
                        required: 'Enter Title.'
                    }, deactivate_date: {
                        required: 'Enter deactivate date.'

                    },
                    "pdf_is[]": "Please select at least one Item."






                },
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                errorElement: 'span',
                errorClass: 'error-tip',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
<?php } ?>