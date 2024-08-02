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
                            <h4 class="title1"> Change Case Status </h4>
                        </div>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr class="success input-sm">
                                    <th>Sno</th>
                                    <th>Filing Number</th>
                                    <th>Current Status</th>
                                    <th>Status To Be Updated and Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($status_that_can_be_changed as $s) {
                                    if (($s->stage_id == Initial_Defected_Stage || $s->stage_id == DEFICIT_COURT_FEE || $s->stage_id == Transfer_to_IB_Stage || $s->stage_id == LODGING_STAGE || $s->stage_id == MARK_AS_ERROR)) {
                                        echo '<tr>';
                                        echo '<td>' . ++$i . '</td>';
                                        echo '<td>' . efile_preview($s->efiling_no) . '</td>';

                                        if ($s->stage_id == Initial_Defected_Stage)
                                            echo '<td>' . 'For Compliance' . '</td>';
                                        else if ($s->stage_id == DEFICIT_COURT_FEE)
                                            echo '<td>' . 'Pay Deficit Fee' . '</td>';
                                        else if ($s->stage_id == Transfer_to_IB_Stage)
                                            echo '<td>' . 'Transfer to CIS' . '</td>';
                                        else if ($s->stage_id == MARK_AS_ERROR)
                                            echo '<td>' . 'Mark as error' . '</td>';
                                        else
                                            echo '<td>' . 'Idle / Unprocessed' . '</td>';
                                        echo '<td>';
                                        $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'status_change', 'id' => 'status_change', 'autocomplete' => 'off');
                                        echo form_open('admin/supadmin/final_case_status_change', $attribute);
                                        echo '<select class="form-control" id="to_change_status_id" name="to_change_status_id" required="required">
                                                        <option disabled="disabled" selected="selected">Select Status to be Changed</option>';
                                        echo $s->last_stage_to_be_updated;
                                        if ($s->last_stage_to_be_updated == New_Filing_Stage) {
                                            $this->session->set_userdata(array(
                                                'last_stage_to_be_updated' => $s->last_stage_to_be_updated));
                                            echo '<option value="' . htmlentities($s->last_stage_to_be_updated, ENT_QUOTES) . '">New Filing Stage</option>';
                                        }
                                        if ($s->last_stage_to_be_updated == Initial_Defects_Cured_Stage) {
                                            $this->session->set_userdata(array(
                                                'last_stage_to_be_updated' => $s->last_stage_to_be_updated));
                                            echo '<option value="' . htmlentities($s->last_stage_to_be_updated, ENT_QUOTES) . '">Refiling Stage</option>';
                                        }
                                        if ($s->last_stage_to_be_updated == Draft_Stage) {
                                            $this->session->set_userdata(array(
                                                'last_stage_to_be_updated' => $s->last_stage_to_be_updated));
                                            echo '<option value="' . htmlentities($s->last_stage_to_be_updated, ENT_QUOTES) . '">Draft Stage</option>';
                                        }
                                        echo '</select>';

                                        echo '&nbsp;&nbsp;<input type="text" class="form-control" id="remark" name="remark" required="required" placeholder=" Remarks ">';
                                        echo '&nbsp;&nbsp;<input type="submit" class="btn btn-primary" name="submit" value="Change Status">';

                                        echo form_close();
                                        echo '</td>';
                                        echo '</tr>';
                                    } else if (( $s->stage_id == Transfer_to_Dealing_Section)) {
                                        
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


