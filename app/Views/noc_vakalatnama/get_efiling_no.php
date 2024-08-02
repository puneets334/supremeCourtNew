<div class="right_col" role="main">
    <h3>NOC Vakalatnama</h3>
    <div id="loader_div"></div>
    <?php echo $this->session->flashdata('message'); ?>
    <div class="row" id="printData">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="panel-body">
                        <div class="row">
                            <?= form_open(); ?>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <div class="form-group">
                                        <label>Enter E-filing Number:</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <div class="form-group">
                                        <input type="text" name="e_filing_num" id="e_filing_num" class="form-control" value="<?php echo (!is_null($case_details['efiling_no'])) ? $case_details['efiling_no'] : ''; ?>">
                                        <span id="e_filing_num"></span>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <div class="form-group">
                                        <button type="submit" id="getResult" class="btn btn-primary"> Search</button>
                                    </div>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        </div>
                        <?php if (!is_null($case_details) && !empty($case_details['aor_code'])) { ?>
                            <?= form_open(); ?>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <div class="form-group">
                                            <label>CauseTitle:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <div class="form-group">
                                            <?= $case_details['cause_title'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <div class="form-group">
                                            <label>Case Filed by AOR:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <div class="form-group">
                                            <?= $case_details['first_name'] . ' (' . $case_details['aor_code'] . ')' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <div class="form-group">
                                            <label>Select AOR:</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="registration_id" value="<?= $case_details['registration_id'] ?>">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <div class="form-group">
                                            <select name="new_aor" id="new_aor" class="form-control input-sm filter_select_dropdown" required>
                                                <option value="">Select AOR</option>
                                                <?php foreach ($aor_list as $aor) { ?>
                                                    <option value="<?= $aor['id'] ?>"><?= $aor['first_name'] . ' (' . $aor['aor_code'] . ')' ?></option>
                                                <?php } ?>
                                            </select>
                                            <span id="new_aor"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary">
                            <?= form_close(); ?>
                        <?php } ?>

                    </div>
                </div>
            </div>