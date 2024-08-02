<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="panel-body">
                    <!--<form action="#" class="form-horizontal" name="search_user" id="search_user" autocomplete="off" method="post" accept-charset="utf-8">-->
                        <?php
                        $attribute = array('class' => 'form_horizontal', 'name' => 'search_user', 'id' => 'search_user','accept-charset'=>'utf-8', 'autocomplete' => 'off');
                        echo form_open(base_url(), $attribute);
                        ?>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Emp.No.
                                                <span style="color: red">*</span></label>
                                            <div class="col-md-7 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" name="empNo" id="empNo" placeholder="Emp.No." maxlength="15" class="form-control input-sm"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">
                                            </label>
                                            <div class="col-md-7 col-sm-12 col-xs-12">
                                                <div class="input-group">
                                                    <button id="empButton" class="btn btn-primary" type="button">Get Details</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row" id="norecordDiv" style="display: none;">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div id="norecord" class="text-center"></div>
                    </div>
                </div>

                <div class="panel-body" id="addUserDiv" style="display: none;">
                    <!--<form action="#" class="form-horizontal" name="addsciuser" id="addsciuser" autocomplete="off" method="post" accept-charset="utf-8">-->
                        <?php
                        $attribute = array('class' => 'form_horizontal', 'name' => 'addsciuser', 'id' => 'addsciuser','accept-charset'=>'utf-8', 'autocomplete' => 'off' );
                        echo form_open(base_url(), $attribute);
                        ?>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Name</label>
                                            <div class="col-md-7 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text"  autocomplete="off" name="emp_name" id="emp_name" placeholder="Name" maxlength="35" class="form-control input-sm"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Emp.No. </label>
                                            <div class="col-md-7 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" autocomplete="off" name="empid" id="empid" placeholder="Emp.No." maxlength="15" class="form-control input-sm"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Mobile</label>
                                            <div class="col-md-7 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" autocomplete="off" name="mobile" id="mobile" placeholder="Mobile" maxlength="10" class="form-control input-sm"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Filing Type</label>
                                            <div class="col-md-7 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <select id="filing_type" name="filing_type" class="form-control input-sm" multiple="multiple" required>
                                                        <option value="">Select Filing Type</option>
                                                        <?php
                                                        if(isset($filingType) && !empty($filingType)){
                                                            foreach ($filingType as $k=>$v){
                                                                echo '<option value="'.$v->id.'">'.str_replace('_',' ',$v->efiling_type).'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"></label>
                                            <div class="col-md-7 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <input type="submit" autocomplete="off" name="adduser" value="Add User" id="adduser" class="btn btn-primary"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Email</label>
                                            <div class="col-md-7 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" autocomplete="off" name="email" id="email" placeholder="Email" maxlength="35" class="form-control input-sm"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Attend</label>
                                            <div class="col-md-7 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" autocomplete="off" name="attend" id="attend" placeholder="Mobile" maxlength="1" class="form-control input-sm"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Party In Person / Advocate</label>
                                            <div class="col-md-7 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <select id="pp_a" name="pp_a" class="form-control input-sm" required>
                                                        <option value="">Select Party In Person / Advocate</option>
                                                        <option value="P">Party In Person</option>
                                                        <option value="A">Advocate</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">DOB</label>
                                            <div class="col-md-7 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" autocomplete="off" name="dob" id="dob" placeholder="DOB" maxlength="10" class="form-control input-sm user_dob"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="usercode" id="usercode"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#filing_type').multiselect();
    });
</script>

<script>
    $(document).ready(function(){
        $('.user_dob').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            maxDate: new Date(),
            dateFormat: "dd-mm-yy",
            yearRange: '1970:2099'
        });
        $(document).on('click','#empButton',function(){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var empNo = $.trim($("#empNo").val()).replace(/[^a-zA-Z0-9]/g, "");
            var errorFlag = true;
            if(empNo == ''){
                errorFlag = false;
                alert("Please fill Emp. No.");
                $("#empNo").focus();
                $("#empNo").css({'border-color':'red'});
                return false;
            }
            if(errorFlag && empNo){
                $.ajax({
                    type: "POST",
                    data: {CSRF_TOKEN: CSRF_TOKEN_VALUE,empNo:empNo },
                    url: "<?php echo base_url('superAdmin/DefaultController/getEmpDetails'); ?>",
                    async:false,
                    cache:false,
                    dataType:'json',
                    success: function(res)
                    {
                        if(res && typeof res == 'string'){
                            res = JSON.parse(res);
                        }
                        if(res.status == 'success'){
                            $("#addUserDiv").show();
                            $("#norecordDiv").hide();
                            if(res.usercode){
                                $("#usercode").val(res.usercode);
                            }
                            if(res.name){
                                $("#emp_name").val(res.name);
                                $("#emp_name").prop('disabled',true);
                            }
                            if(res.email_id){
                                $("#email").val(res.email_id);
                            }
                            if(res.empid){
                                $("#empid").val(res.empid);
                                $("#empid").prop('disabled',true);
                            }
                            if(res.attend){
                                $("#attend").val(res.attend);
                                $("#attend").prop('disabled',true);
                            }
                            if(res.mobile_no){
                                $("#mobile").val(res.mobile_no);
                            }
                            if(res.dob){
                                $("#dob").val(res.dob);
                                $("#dob").prop('disabled',true);
                            }
                        }
                        else if(res.status == 'already'){
                            $("#norecordDiv").show();
                            $("#addUserDiv").hide();
                            $("#norecord").html(res.message);
                        }
                        else if(res.status == 'error'){
                            $("#norecordDiv").show();
                            $("#addUserDiv").hide();
                            $("#norecord").html(res.message);
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
            }
        });
        $(document).on('click','#adduser',function(e){
            e.preventDefault();
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var validationError = true;
            var emp_name = $.trim($("#emp_name").val());
            var email = $.trim($("#email").val());
            var empid = $.trim($("#empid").val());
            var attend = $.trim($("#attend").val());
            var mobile_no = $.trim($("#mobile").val());
            var dob = $.trim($("#dob").val());
            var usercode = $.trim($("#usercode").val());
            var filing_type = $("select#filing_type").val();
            var pp_a = $("select#pp_a option:selected").val();
            // alert(pp_a);
            // return false;
            var numRegExp = /^\d+$/;
            var mobileRegExp = /^\d{10}$/;
            var emailRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if(emp_name == ''){
                alert("Please fill emp. name");
                $("#emp_name").css({'border-color':'red'});
                $("#emp_name").focus();
                validationError = false;
                return false;
            }
            else if(empid == ''){
                alert("Please fill emp.no.");
                $("#empid").css({'border-color':'red'});
                $("#empid").focus();
                validationError = false;
                return false;
            }
            else if(!empid.match(numRegExp)){
                alert("Please fill emp.no. as numeric.");
                $("#empid").css({'border-color':'red'});
                $("#empid").focus();
                $("#empid").val('');
                validationError = false;
                return false;
            }
            else if((mobile_no) && !mobile_no.match(mobileRegExp)){
                alert("Please fill valid mobile No.");
                $("#mobile").css({'border-color':'red'});
                $("#mobile").focus();
                $("#mobile").val('');
                validationError = false;
                return false;
            }
            else if((email) && ! email.match(emailRegExp)){
                alert("Please fill valid email Id");
                $("#email").css({'border-color':'red'});
                $("#email").focus();
                $("#email").val('');
                validationError = false;
                return false;
            }
            else if(attend == ''){
                alert("Please fill attend.");
                $("#attend").css({'border-color':'red'});
                $("#attend").focus();
                validationError = false;
                return false;
            }
            else  if(filing_type == ''){
                alert("Please select file type");
                $("#filing_type").css({'border-color':'red'});
                $("#filing_type").focus();
                validationError = false;
                return false;
            }
            else if(pp_a == ''){
                alert("Please select Party In Person / Advocate");
                $("#pp_a").css({'border-color':'red'});
                $("#pp_a").focus();
                validationError = false;
                return false;
            }
            if(validationError == true){
                var formData = {CSRF_TOKEN: CSRF_TOKEN_VALUE,emp_name:emp_name,email:email,empid:empid,attend:attend,mobile_no:mobile_no,dob:dob,usercode:usercode,filing_type:filing_type,pp_a:pp_a };
                $.ajax({
                    type: "POST",
                    data: JSON.stringify(formData),
                    url: "<?php echo base_url('superAdmin/DefaultController/addSciUser'); ?>",
                    async:false,
                    cache:false,
                    dataType:'json',
                    success: function(res)
                    {
                        if(res && typeof res == 'string'){
                            res = JSON.parse(res);
                        }
                        if(res.status == 'success'){
                            alert(res.message);
                            window.location.reload();
                        }
                        else  if(res.status == 'error'){
                            alert(res.message);
                            $("#"+res.id).focus();
                            $("#"+res.id).css({'border-color':'red'});
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
            }


        })
    });
</script>