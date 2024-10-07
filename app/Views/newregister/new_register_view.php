
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
        <!------------Table--------------------->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title"><h2> <i class="fa fa-newspaper-o"></i> New Registration</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content"> 
                    <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"> 

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content">
                                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr class="success input-sm" role="row" >
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Type  </th>
                                                    <th>Address </th>
                                                    <th>Request On</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($advocate_details as $res) {
                                                    if ($res->office_distt_name != 'NULL') {
                                                        $state_name = ', ' . $res->office_distt_name;
                                                    }
                                                    if ($res->office_state_name != 'NULL') {
                                                        $dist_name = ', ' . $res->office_state_name;
                                                    }
                                                    if ($res->m_pincode != '') {
                                                        $m_pincode = '- ' . $res->m_pincode;
                                                    }
                                                    if ($res->ref_m_usertype_id == USER_ADVOCATE) {
                                                        $user_type = 'Advocate';
                                                    } else {
                                                        $user_type = '';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td width="5%" data-key="#"> <?php echo htmlentities($i++, ENT_QUOTES); ?></td>
                                                        <td width="15%" data-key="Name"><a href="<?= base_url('newRegister/Advocate/view/') ?><?php echo htmlentities(trim(url_encryption($res->id)), ENT_QUOTES); ?>" style="color: #385198;"><?php echo htmlentities(strtoupper($res->first_name), ENT_QUOTES); ?></a></td>
                                                        <td width="8%" data-key="Type"><?php echo htmlentities($user_type, ENT_QUOTES); ?></td> 
                                                        <td width="10%" data-key="Address"><?php echo htmlentities($res->m_address1 . ' , ' . $res->m_city . $m_pincode, ENT_QUOTES); ?></td>                                    
                                                        <td width="15%" data-key="Request On"> <?php echo htmlentities(date("d-m-Y h:i:s A", strtotime($res->created_on)), ENT_QUOTES); ?> </td> 
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!------------Table--------------------->
                        </div>
                    </div></div>
            </div>
        </div>
        <!------------Table--------------------->
    </div>

</div>
