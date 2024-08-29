<?php
$track_horizonal_timeline = array();
$disposed_flag = array('F', 'R', 'D', 'C', 'W');
    if (count($results) > 0) {
        $row = $results;
        pr($row);
        $case_no = "";
        $request_received_f = '<strong class="text-success">Received</strong>';
        array_push($track_horizonal_timeline, array("flag_type" => 'Request', "flag_description" => $request_received_f . ' ' . date("d-m-Y H:i:s", strtotime($row['application_receipt']))));

        if ($row['application_request'] == 'request') {
            if ($row['allowed_request'] == 'request_to_available') {
                //section movement
                //   array_push($track_horizonal_timeline, array("flag_type"=>'Disposed',"flag_description"=>date("d-m-Y H:i:s", strtotime($row['dispatch_delivery_date']))));
            } else {

                $sql_asset = "select * from (select u.verify_remark, u.id, u.asset_type, a.asset_name, u.id_proof_type, i.id_name, u.file_path, u.verify_status, u.verify_on, u.video_random_text from user_assets u inner join user_asset_type_master a on a.id = u.asset_type left join id_proof_master i on i.id = u.id_proof_type and i.display = 'Y' where u.mobile ='" . $row['mobile'] . "' and u.email = '" . $row['email'] . "' and u.asset_type in (1) and u.diary_no = 0 order by ent_time desc limit 1) a
union
select * from (select u.verify_remallowed_requestark, u.id, u.asset_type, a.asset_name, u.id_proof_type, i.id_name, u.file_path, u.verify_status, u.verify_on, u.video_random_text from user_assets u inner join user_asset_type_master a on a.id = u.asset_type left join id_proof_master i on i.id = u.id_proof_type and i.display = 'Y' where u.mobile = '" . $row['mobile'] . "' and u.email = '" . $row['email'] . "' and u.asset_type in (2) and u.diary_no = 0 order by ent_time desc limit 1) b
union
select * from (select u.verify_remark, u.id, u.asset_type, a.asset_name, u.id_proof_type, i.id_name, u.file_path, u.verify_status, u.verify_on, u.video_random_text from user_assets u inner join user_asset_type_master a on a.id = u.asset_type left join id_proof_master i on i.id = u.id_proof_type and i.display = 'Y' where u.mobile = '" . $row['mobile'] . "' and u.email = '" . $row['email'] . "' and u.asset_type in (3) and u.diary_no = 0 order by ent_time desc limit 1) c";
                $sql_asset = $dbo->prepare($sql_asset);
                $sql_asset->execute();
                if ($sql_asset->rowCount() > 0) {
                    while ($data_asset = $sql_asset->fetch(PDO::FETCH_ASSOC)) {
                        if ($data_asset['verify_status'] == 1) {
                            $data_asset_status = ' <strong class="text-primary">Pending</strong>';
                        }allowed_request
                        if ($data_asset['verify_status'] == 2) {
                            $data_asset_status = ' <strong class="text-success">Accepted</strong>';
                        }
                        if ($data_asset['verify_status'] == 3) {
                            $data_asset_status = ' <strong class="text-danger">Rejected</strong>';
                        }
                        $data_asset_string .= $data_asset['asset_name'] . $data_asset_status . ' (' . date("d-m-Y H:i:s", strtotime($data_asset['verify_on'])) . ')<br>';
                    }
                }

                if ($row['filed_by'] == 2) {
                    $asset_type_flag = 5;
                } //party
                if ($row['filed_by'] == 3) {
                    $asset_type_flallowed_requestag = 6;
                } //appearing counsel
                if ($row['filed_by'] == 4) {
                    $asset_type_flag = 4;
                } //affidavit

                $sql_asset = "select u.verify_remark, u.id, u.asset_type, a.asset_name, u.id_proof_type, i.id_name, u.file_path, u.verify_status, u.verify_on, u.video_random_text from user_assets u
                            inner join user_asset_type_master a on a.id = u.asset_type
                            left join id_proof_master i on i.id = u.id_proof_type and i.display = 'Y'
                        where u.mobile = '" . $row['mobile'] . "' and u.email = '" . $row['email'] . "' and u.asset_type = $asset_type_flag
                                and u.diary_no = " . $row['diary'] . " order by ent_time desc limit 1";
                $sql_asset = $dbo->prepare($sql_asset);
                $sql_asset->executallowed_requeste();
                if ($sql_asset->rowCount() > 0) {
                    while ($data_asset = $sql_asset->fetch(PDO::FETCH_ASSOC)) {
                        if ($data_asset['verify_status'] == 1) {
                            $data_asset_status = ' <strong class="text-primary">Pending</strong>';
                        }
                        if ($data_asset['verify_status'] == 2) {
                            $data_asset_status = ' <strong class="text-success">Accepted</strong>';
                        }
                        if ($data_asset['verify_status'] == 3) {
                            $data_asset_status = ' <strong class="text-danger">Rejected</strong>';
                        }
                        //array_push($track_horizonal_timeline, array("flag_type"=> 'Verify '.$data_asset['asset_name'] ,"flag_description"=>$data_asset_status.' ('.date("d-m-Y H:i:s", strtotime($data_asset['verify_on'])).')'));
                        $data_asset_string .= $data_asset['asset_name'] . $data_asset_status . ' (' . date("d-m-Y H:i:s", strtotime($data_asset['verify_on'])) . ')';
                    }
                }
                array_push($track_horizonal_timeline, array("flag_type" => 'Verification', "flag_description" => $data_asset_string));
            }allowed_request
        }


        if ($row['reg_no_display'] != '') {
            $case_no = $row['reg_no_display'];
        }
        $case_no .= ' DNo. ' . substr($row['diary'], 0, -4) . '-' . substr($row['diary'], -4);
        if ($row['c_status'] == 'P') {
            $case_status = 'Pending';
        } else {
            $case_status = 'Disposed';
        }
?>

        <div class="card mt-2">
            <div class="card-header bg-info text-white font-weight-bolder">Details</div>
            <div class="card-body">
                <div style="border-radius: 15px 15px 15px 15px;" class="p-2 m-1">
                    <div class="row">
                        <div class="col-md-4">Application No.: <span class="font-weight-bold text-gray"><?= $row['application_request'] == 'application' ? $row['application_number_display'] : 'NA'; ?></span>
                        </div>
                        <div class="col-md-4">CRN: <span class="font-weight-bold text-gray"><?= $row['crn'] == '0' ? '' : $row['crn']; ?></span></div>
                        <div class="col-md-4">Date: <span class="font-weight-bold text-gray"><?= date("d-m-Y", strtotime($row['application_receipt'])); ?></span>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">Source: <span class="font-weight-bold text-gray"><?= $row['description']; ?></span></div>
                        <div class="col-md-4">Applied By: <span class="font-weight-bold text-gray"><?php
                                                                                                    if ($row['filed_by'] == 1) {
                                                                                                        echo "AOR";
                                                                                                    }
                                                                                                    if ($row['filed_by'] == 2) {
                                                                                                        echo "Party";
                                                                                                    }
                                                                                                    if ($row['filed_by'] == 3) {
                                                                                                        echo "Appearing Counsel";
                                                                                                    }
                                                                                                    if ($row['filed_by'] == 4) {
                                                                                                        echo "Third Party";
                                                                                                    }
                                                                                                    if ($row['filed_by'] == 6) {
                                                                                                        echo "Authenticated By AOR";
                                                                                                    }
                                                                                                    ?></span></div>
                        <div class="col-md-4">Applicant Name: <span class="font-weight-bold text-gray"><?= $row['name']; ?></span></div>


                    </div>

                    <div class="row">
                        <div class="col-md-4">Application Status: <span class="font-weight-bold text-gray"><?= (in_array($row['application_status'], $disposed_flag)) ?  "Action Completed" : "Pending" ?></span></div>
                        <div class="col-md-4">Delivery Mode: <span class="font-weight-bold text-gray"><?php
                                                                                                        if ($row['delivery_mode'] == 1) {
                                                                                                            echo "Post";
                                                                                                            $sql_barcode = "select group_concat(barcode) as barcode from post_bar_code_mapping where copying_application_id = :id group by copying_application_id having barcode is not null";
                                                                                                            $prepared_array = array('id' => $row['id']);
                                                                                                            //echo $sql;
                                                                                                            $rs_barcode = $dbo2->prepare($sql_barcode);
                                                                                                            $rs_barcode->execute($prepared_array);
                                                                                                            if ($rs_barcode->rowCount() > 0) {
                                                                                                                $row_barocode = $rs_barcode->fetch(PDO::FETCH_ASSOC);
                                                                                                                $explode_barcode = explode(",", $row_barocode['barcode']);
                                                                                                        ?>
                                        <a href="#" onclick="mytrack_record()" id='myBtn'>Click to Track</a>
                                <?php
                                                                                                            }
                                                                                                        }
                                                                                                        if ($row['delivery_mode'] == 2) {
                                                                                                            echo "Counter";
                                                                                                        }
                                                                                                        if ($row['delivery_mode'] == 3) {
                                                                                                            echo "Email";
                                                                                                        }
                                ?></span>
                        </div>
                        <?php
                        if ($row['application_request'] == 'application' && $row['delivery_mode'] != 3) {
                        ?>
                            <div class="col-md-4">Fee: <span class="font-weight-bold text-gray">Rs. <?= $row['court_fee'] + $row['postal_fee']; ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">Case No.: <span class="font-weight-bold text-gray"><?= $case_no; ?></span></div>
                    </div>
                </div>






                <?php

                if ($row['application_request'] == 'application') {
                    $sql1 = "select b.sent_to_applicant_on, b.pdf_embed_on, b.pdf_digital_signature_on, r.order_type order_name, '' as reject_cause, b.* from copying_application_documents b
                    left join ref_order_type r on b.order_type = r.id
                    where b.copying_order_issuing_application_id = :id ";
                }
                if ($row['application_request'] == 'request') {
                    $sql1 = "select b.path, r.order_type order_name, b.reject_cause, b.* from copying_request_verify_documents b
                    left join ref_order_type r on b.order_type = r.id
                    where b.copying_order_issuing_application_id = :id ";
                }

                $rs1 = $dbo2->prepare($sql1);
                $rs1->execute(array('id' => $row['id']));
                if ($rs1->rowCount() > 0) {
                    $sno = 1;
                    //$row1 = $rs1->fetch(PDO::FETCH_ASSOC);

                ?>


                    <div class="table-responsive fixed-table-body row m-1 p-1 application_document">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>SNo.</th>
                                    <th>Document Type</th>
                                    <th>Date</th>
                                    <th>Copies</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row1 = $rs1->fetch(PDO::FETCH_ASSOC)) {
                                    // echo "<pre>";
                                    // print_r($row);
                                    // exit;


                                    if ($row['application_request'] == 'request' && $row['allowed_request'] == 'request_to_available') {

                                        $recv_from_sec = "select c.from_section_sent_on, us.section_name as from_section1, us2.section_name as to_section1 
from copying_request_movement c 
left join usersection us on us.id = c.from_section 
left join usersection us2 on us2.id = c.to_section 
where c.copying_request_verify_documents_id = :id and c.display = 'Y' 
and from_section_sent_by != 0 order by c.from_section_sent_on";
                                        $recv_from_sec = $dbo->prepare($recv_from_sec);
                                        $recv_from_sec->execute(array('id' => $row1['id']));

                                        if ($recv_from_sec->rowCount() > 0) {
                                            $section_data_avl = 'YES';
                                            while ($row_section = $recv_from_sec->fetch(PDO::FETCH_ASSOC)) {

                                                $snoo2++;
                                                $section_movement .= $snoo2 . ". Section " . $row_section['from_section1'] . " -> " . $row_section['to_section1'] . '<br>(' . date("d-m-Y H:i:s", strtotime($row_section['from_section_sent_on'])) . ")";
                                                $section_movement .= "<br>";
                                            }
                                            if (!empty($row1['path'])) {
                                                $section_movement .= "<strong class='text-success'>Uploaded</strong> " . date("d-m-Y H:i:s", strtotime($row1['updated_on'])) . "<br>";
                                            }
                                            if (empty($row1['path']) && $row1['request_status']) {
                                                $section_movement .= "<strong class='text-success'>Rejected</strong> " . date("d-m-Y H:i:s", strtotime($row1['updated_on'])) . "<br>";
                                            }
                                        }
                                    }

                                    if ($row['application_request'] == 'application' && $row['delivery_mode'] == 3) {
                                        $snoo++;
                                        //digital signed
                                        if ($row1['pdf_embed_on'] != null && $row1['pdf_embed_on'] != '0000-00-00 00:00:00')
                                            $action_on_pdf .= $snoo . ". Verify " . date("d-m-Y H:i:s", strtotime($row1['pdf_embed_on'])) . "<br>";
                                        if ($row1['pdf_digital_signature_on'] != null && $row1['pdf_digital_signature_on'] != '0000-00-00 00:00:00')
                                            $action_on_pdf .= "Digital Sign " . date("d-m-Y H:i:s", strtotime($row1['pdf_digital_signature_on'])) . "<br>";
                                        if ($row1['sent_to_applicant_on'] != null && $row1['sent_to_applicant_on'] != '0000-00-00 00:00:00')
                                            $action_on_pdf .= "Sent to user " . date("d-m-Y H:i:s", strtotime($row1['sent_to_applicant_on'])) . "<br>";
                                    }


                                ?>
                                    <tr>
                                        <td>
                                            <?= $sno++; ?>
                                        </td>
                                        <td>
                                            <?= $row1['order_name']; ?>
                                        </td>
                                        <td>
                                            <?= date("d-m-Y", strtotime($row1['order_date'])); ?>
                                        </td>
                                        <td>
                                            <?= $row1['number_of_copies']; ?>
                                        </td>
                                    </tr>
                                <?php
                                }

                                if ($row['application_request'] == 'application' && $row['delivery_mode'] == 3) {
                                    //digital signed
                                    array_push($track_horizonal_timeline, array("flag_type" => 'Signature', "flag_description" => $action_on_pdf));
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
            </div>
        </div>



    <?php
                    if ($section_data_avl == 'YES' && $row['application_request'] == 'request' && $row['allowed_request'] == 'request_to_available') {
                        array_push($track_horizonal_timeline, array("flag_type" => 'Movement', "flag_description" => $section_movement));
                    }
                }
                //


                if (in_array($row['application_status'], $disposed_flag)) {

                    //$data_disposed_content = "<strong class='text-danger'>".$row['status_description']."</strong>";
                    $data_disposed_content = "<strong class='text-danger'>Action Completed</strong>";

                    if ($row['application_status'] == 'D')
                        array_push($track_horizonal_timeline, array("flag_type" => 'Disposed', "flag_description" => $data_disposed_content . ' ' . date("d-m-Y H:i:s", strtotime($row['dispatch_delivery_date']))));
                    else
                        array_push($track_horizonal_timeline, array("flag_type" => 'Disposed', "flag_description" => $data_disposed_content . ' ' . date("d-m-Y H:i:s", strtotime($row['updated_on']))));
                }

    ?>


    <!--START HORIZONTAL TIMELINE -->



    
    <div class="card mt-2">
        <div class="card-header bg-info text-white font-weight-bolder">Timeline
        </div>
        <div class="card-body">
            <div class="container my-2" id="show_tracking">
                <div class="row">
                    <div class="col-md-12 ">

                        <ul class="timeline" style="list-style-type: none;">
                            <?php
                            foreach ($track_horizonal_timeline as $val_track_rpt) {

                                // print_r($val_track_rpt); exit;
                                $flag_type = $val_track_rpt['flag_type'];
                                $flag_description = $val_track_rpt['flag_description'];
                            ?>
                                <li>
                                    <h6 style="color: blueviolet; "><?= $flag_type ?> </h6>
                                    <p><b></b><?= $flag_description ?></p>

                                </li>
                            <?php
                            }



                            ?>

                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--END HORIZONTAL TIMELINE -->

    <style>
    ul.timeline {
        list-style-type: none;
        position: relative;
    }
    ul.timeline:before {
        content: ' ';
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: 29px;
        width: 2px;
        height: 100%;
        z-index: 400;
    }
    ul.timeline > li {
        margin: 20px 0;
        padding-left: 20px;
    }
    ul.timeline > li:before {
        content: ' ';
        background: white;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #22c0e8;
        left: 20px;
        width: 20px;
        height: 20px;
        z-index: 400;
    }


    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }




        #app {
            padding: 50px 0;
        }
    .timeline1 {
        margin: 50px 0;
        list-style-type: none;
        display: flex;
        padding: 0;
        text-align: center;
    }
    .timeline1 li {
        transition: all 200ms ease-in;
    }
    .timestamp {
        width: 100%; 
    margin-bottom: 20px;
        padding: 0px 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-weight: 100;
    }
    .status {
        padding: 0px 40px;
        display: flex;
        justify-content: center;
        border-top: 4px solid #3e70ff;
        position: relative;
        transition: all 200ms ease-in ;
    }

    .status span {
        font-weight: 600;
        padding-top: 20px;
    }
    .status span:before {
        content: '';
        width: 25px;
        height: 25px;
        background-color: #e8eeff;
        border-radius: 25px;
        border: 4px solid #3e70ff;
        position: absolute;
        top: -15px;
        left: calc(50% - 12px); 
    transition: all 200ms ease-in;
    }
    .swiper-control {
        text-align: right;
    }

    .swiper-container {
        width: 100%;
        height: 300px;
        /*margin: 50px 0;*/
        /*overflow: hidden;*/
        /*overflow: scroll;*/
        padding: 0 20px 30px 20px;
    }
    .swiper-slide {
        width: 300px;
        text-align: center;
        font-size: 14px;
    }
    .swiper-slide:nth-child(2n) {
        /*width: 40%;*/
    }
    .swiper-slide:nth-child(3n) {
        /*width: 20%;*/
    }
</style>


    <div class="row col-12 mb-3" id="result" style="overflow: auto !important;"></div>
    <div id="track_record"></div>
    <div id="myModal" class="modal">
        <!-- Modal content -->

        <?php

        for ($k = 0; $k < count($explode_barcode); $k++) {
            $postage_response = article_tracking_offline($explode_barcode[$k]);
            $postage_response = json_decode($postage_response, true);
            //var_dump($postage_response);
        ?>

            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title">Consignment No. : <span class="font-weight-bolder"><?= $explode_barcode[$k] ?></span></p>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="container my-2" id="show_tracking">
                    <div class="row">
                        <div class="col-md-12 ">

                            <ul class="timeline" style="list-style-type: none;">
                                <?php
                                if ($postage_response['Status'] == 'success') {
                                    foreach ($postage_response['DataValue'] as $value) {
                                ?>
                                        <li>
                                            <h6 style="color: blueviolet; "><?= date('d-M-Y (h:i A)', strtotime($value['event_date'])) ?> </h6>
                                            <p><b>Event:</b><?= $value['event_type'] . ' / ' ?> <b>Office:</b><?= $value['office'] ?></p>

                                        </li>
                                <?php
                                    }
                                } else {
                                    echo "<span class='text-danger'>No Records Found</span>";
                                }

                                ?>
                            </ul>

                        </div>
                    </div>
                </div>
            </div><!--END OF DIV class="modal-content" -->
        <?php } ?>
    </div><!--END OF DIV class="modal" -->

<?php
    } else {
?>
    <div class="alert alert-danger alert-dismissible">
        <strong>No Record Found</strong>
    </div>
<?php
    }
?>

