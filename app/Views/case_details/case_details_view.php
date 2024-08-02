<?php
if ($this->uri->segment(2) != 'view') {
    if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS) {
        $this->load->view('miscellaneous_docs/misc_docs_breadcrumb');
    } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) {
        $this->load->view('IA/ia_breadcrumb');
    }elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING) {
        $this->load->view('mentioning/mentioning_breadcrumb');
    } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_CITATION) {
        $this->load->view('citation/citation_breadcrumb');
    } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_CERTIFICATE_REQUEST) {
        $this->load->view('certificate/certificate_breadcrumb');
    }  elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == OLD_CASES_REFILING) {
        $this->load->view('oldCaseRefiling/old_efiling_breadcrumb');
    }
    
}
?>
<div class="panel panel-default panel-body">
    <h4 style="text-align: center;color: #31B0D5">Case Details </h4>
    <div class="row">
        <div class="col-md-12">

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4 text-right" for="diary_no">Diary No. :</label>
                    <div class="col-md-8">
                        <p> <?php echo_data($case_details[0]['diary_no'] . ' / ' . $case_details[0]['diary_year']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4 text-right" for="reg_num">Registration No.:</label>
                    <div class="col-md-8">
                        <p> <?php echo_data($case_details[0]['reg_no_display']); ?></p>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4 text-right"  for="cause_title">Cause Title :</label>
                    <div class="col-md-8">
                        <p> <?php echo_data($case_details[0]['cause_title']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4 text-right" for="case_status">Case Status:</label>
                    <div class="col-md-8">
                        <!--<p> <?php /*echo $case_details[0]['c_status'] == 'D' ? 'Disposed' : 'Pending'; */?></p>-->
                        <p> <?php echo $details['details'][0]['c_status'] == 'D' ? 'Disposed' : 'Pending'; ?></p>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php
            if(isset($filedByData) && !empty($filedByData)) {
                $filedBy = '';
                $name = !empty($filedByData['name']) ? $filedByData['name'] : '';
                if (isset($filedByData['pp']) && !empty($filedByData['pp']) && empty($filedByData['aor_code']) && empty($filedByData['bar_id'])) {
                    $filedBy = $name . ' ( Party In Person )';
                } else {
                    $aor_code = !empty($filedByData['aor_code']) ? $filedByData['aor_code'] : '';
                    $filedBy = $name . ' (AOR- ' . $aor_code . ')';
                }
                echo '<div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 text-right" for="filed_by">Filed By: </label>
                        <div class="col-md-8">
                            <p>' . $filedBy . '</p>
                        </div>
                    </div>
                </div>';
            }
            if(isset($case_listing_details->listed[0]) && !empty($case_listing_details->listed[0])) {
                ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <?php
                        if (strtotime($case_listing_details->listed[0]->next_dt) >= strtotime(date("Y-m-d"))) {
                            ?>
                            <span  style="color:red; font-size:14px; font-weight: bold;">
                    <label  class="control-label col-md-4 text-right" for="case_status">Listed For :</label>
                    <div class="col-md-8">
                            <p> <?= date('d-m-Y', strtotime($case_listing_details->listed[0]->next_dt)) ?>(<?=$case_listing_details->listed[0]->board_type?>)</p>
                    </div>
                </span>
                        <?php  } else { ?>
                            <label class="control-label col-md-4 text-right" for="case_status">Last Listed On :</label>
                            <div class="col-md-8">
                                <p> <?= date('d-m-Y', strtotime($case_listing_details->listed[0]->next_dt)) ?>(<?=$case_listing_details->listed[0]->board_type?>)</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php  }
            if(isset($details) && !empty($details)) {
                ?>
                <div class="col-md-6">
                    <label class="control-label col-md-6 text-right"><?php if($details['details'][0]['judgment_reserved_date']!=null){
                        echo '<font color=red>Judgment is reserved for :' .date('d-m-Y',strtotime($details['details'][0]['judgment_reserved_date'])) .'</font>';?></label>
                    <?php }?>
                </div>
            <?php  }

            if($case_details[0]['p_r_type']=='I'){ ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 text-right" for="case_status">Intervenor Name:</label>
                        <div class="col-md-8">
                            <p>
                                <?php
                                //                            echo $case_details[0]['intervenor_name'];
                                if(isset($case_details[0]['intervenorname']) && !empty($case_details[0]['intervenorname'])){
                                    echo strtoupper($case_details[0]['intervenorname']);
                                }
                                ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>


            </br>

            <?php if ($this->uri->segment(2) != 'view') { ?>
                <div class="row">
                    <div class="col-md-offset-5 col-md-2 col-sm-offset-3 col-sm-6 col-xs-12 efiling_search">
                        <?php if($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING){ ?>
                            <a href="<?= base_url('mentioning/Listing'); ?>" class="btn btn-primary btn-block" type="button">Next</a>
                        <?php  }
                        else if($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_CITATION){ ?>
                            <a href="<?= base_url('citation/CitationController'); ?>" class="btn btn-primary btn-block" type="button">Next</a>
                        <?php }
                        else if($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_CERTIFICATE_REQUEST){ ?>
                            <a href="<?= base_url('certificate/AddDetails'); ?>" class="btn btn-primary btn-block" type="button">Next</a>
                        <?php  }
                        else if($_SESSION['efiling_details']['ref_m_efiled_type_id'] == OLD_CASES_REFILING){ ?>
                            <a href="<?= base_url('uploadDocuments/DefaultController'); ?>" class="btn btn-primary btn-block" type="button">Next</a>
                        <?php  }
                        else { ?>
                            <a href="<?= base_url('case/interim_application/crud_registration/'.url_encryption(trim($_SESSION['efiling_details']['registration_id'] . '#' . $_SESSION['efiling_details']['ref_m_efiled_type_id'] . '#' . 1))); ?>" class="btn btn-primary btn-block" type="button">Next</a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


