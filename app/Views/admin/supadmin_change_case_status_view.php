<div class="right_col" role="main">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="" id="msg">
                    <?php
                    if (isset($_SESSION['MSG']) && !empty($_SESSION['MSG'])) {
                        echo $_SESSION['MSG'];
                    } unset($_SESSION['MSG']);
                    ?>
                </div>
                <div class="x_panel">
                    <div class="x_content">
                        <div class="col-lg-12 col-xs-12">
                            <h4 class="title1"><i class="fa fa-recycle"></i> Change Case Status </h4>
                        </div>
                        <div class="form-group">
                            <span style="color: red;"> NOTE : Stage of a eFiling Number can be reverted to one step back only when the said number is active on any of the following stages mentioned here in Admin login.</br>
                                Stages are </span><span>: <strong><u> For Compliance</u>, <u>Pay Deficit Fee</u>, <u>Transfer to CIS</u>, <u> Idle/Unprocessed</u>, <u>Mark as error</u> .</strong></span>

                            <br><br><br>
                            <label for="usr">Enter Efiling Number </label>
                            <?php
                            $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'search_case', 'id' => 'search_case', 'autocomplete' => 'off');
                            echo form_open('admin/supadmin/search_case_status', $attribute);
                            ?>
                            <div class="input-group">
                                <input type="text" class="form-control" id="efil_no" name="efil_no" required placeholder="Enter Efiling Number" maxlength="20">                                
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Enter an existing Efiling Number.">
                                    <i class="fa fa-question-circle-o" ></i>
                                </span>
                            </div> 
                            <input type="submit" name="submit" value="Search" class="btn btn-primary btn-block">
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>