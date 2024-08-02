<div class="col-md-12 col-sm-12 col-xs-12">
    <a href="" class="list-group-item" style="background: #EDEDED;" ><b>Earlier Courts Information</b></a>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr class="success">
                        <th width="5%">#</th>
                        <th width="15%">Type</th>
                        <th width="30%">Court</th>
                        <th width="15%">Case Details</th>
                        <th width="40">Fir Details</th>
                        <th width="10%">Date</th>
                        <th width="5%">Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php   // echo '<pre>'; print_r($subordinate_court_details); exit;
                    $i = 1; $state_name=''; $district_name='';$lower_court_code=''; $high_court_name='';$high_court_bench='';$k=0;
                    foreach ($subordinate_court_details as $dataRes) {
                        if ($dataRes['appellate_trial'] == 1) {
                            $st = explode('$$', $dataRes['app_court_state_name']);
                            $dist = explode('$$', $dataRes['app_court_distt_name']);
                            $court = explode('$$', $dataRes['app_court_sub_court_name']);
                        } elseif ($dataRes['appellate_trial'] == 2) {
                            $st = explode('$$', $dataRes['trial_court_state_name']);
                            $dist = explode('$$', $dataRes['trial_court_distt_name']);
                            $court = explode('$$', $dataRes['trial_court_sub_court_name']);
                        }
                        if ($dataRes['appellate_trial'] == 1 || $dataRes['appellate_trial'] == 3) {
                            $appellate_trial_name = strtoupper('First Appellate Court' . '<br>' . $court_name);
                        } elseif ($dataRes['appellate_trial'] == 2 || $dataRes['appellate_trial'] == 4) {
                            $appellate_trial_name = strtoupper('Trial Court Information' . '<br>' . $court_name);
                        } else {
                            $appellate_trial_name = strtoupper('' . $court_name);
                        }
                            $fir_state_name = !empty($dataRes['fir_state_name']) ? strtoupper($dataRes['fir_state_name']) : '';
                            $fir_district_name = !empty($dataRes['fir_district_name']) ? strtoupper($dataRes['fir_district_name']) : '';
                            $fir_police_station_name = !empty($dataRes['fir_police_station_name']) ? strtoupper($dataRes['fir_police_station_name']) : '';
                            $fir_complete_fir_no = !empty($dataRes['fir_complete_fir_no']) ? $dataRes['fir_complete_fir_no'] : '';
                        if ($dataRes['sub_qj_high'] == 1) {
                            $court_name = strtoupper('Lower Court');
                            $state_name= !empty($dataRes['state_name']) ? $dataRes['state_name'] : NULL;
                            $district_name=!empty($dataRes['district_name']) ? $dataRes['district_name'] : NULL;
                            $estab_name= !empty($dataRes['estab_name']) ? $dataRes['estab_name'] : NULL;
                            $cc_applied_date = !empty($dataRes['lcc_applied_date']) ?  $dataRes['lcc_applied_date'] : '';
                            $lcc_received_date = !empty($dataRes['lcc_received_date']) ?  $dataRes['lcc_received_date'] : '';
                            $case_no= !empty($dataRes['case_no']) ? $dataRes['case_no'] : NULL;
                            $case_year= !empty($dataRes['case_year']) ? $dataRes['case_year'] : NULL;
                            $case_no= !empty($dataRes['case_no']) ? $dataRes['case_no'] : NULL;
                            echo '<tr>';
                            echo '<td>' . $i++ . '</td>';
                            echo '<td>' . $court_name . '</td>';
                            echo '<td>'; echo 'State:'. $state_name.' <br/> District:'.$district_name. '<br>Estab Name:'.$estab_name.'</td>';
                            echo '<td>';echo 'Case No.:'.$case_no.'<br/> Case Year:'.$case_year.'</td>';
                            echo '<td>'.'State Name:'.$fir_state_name.'<br>'.'District Name:'.$fir_district_name.'<br>'.'Police Statation Name:'.$fir_police_station_name.'<br>'.'Fir No.'.$fir_complete_fir_no.'</td>';
                            echo '<td> Order Dt : ' . date('d-m-Y H:i:s',strtotime($cc_applied_date)) . '</td>';
                        }
                        else if ($dataRes['sub_qj_high'] == 2) {
                            $court_name = strtoupper('Quasi Judicial');
                            $court = strtoupper('Judicial');
                        }
                        else if ($dataRes['sub_qj_high'] == 3) {
                            $court_name = strtoupper('High Court');
                            $court = strtoupper('High Court');
                            $high_court_name = !empty($dataRes['high_court_name']) ? $dataRes['high_court_name'] : NULL;
                            $high_court_bench = !empty($dataRes['bench_name']) ? $dataRes['bench_name'] : NULL;
                            echo '<tr>';
                            echo '<td>' . $i++ . '</td>';
                            echo '<td>' . $court_name . '</td>';
                            //echo '<td>' . $court . '</td>';
                            if(isset($state_name) && !empty($state_name) && !empty($district_name) && isset($district_name) && !empty($lower_court_code) && isset($lower_court_code)){
                                echo '<td>'; echo 'State:'. $state_name.' <br/> District:'.$district_name .'<br/> Subordinate Court:'.$lower_court_code; '</td>';
                            }
                            else{
                                echo '<td>'; echo 'High court name: '. $high_court_name.' <br/> Bench Name: '.$high_court_bench.'</td>';
                            }

                            if (!empty($dataRes['lower_cino'])) {
                                echo '<td> CNR No. : ' . strtoupper(cin_preview($dataRes['lower_cino'])) . '</td>';
                            } else {
                                    echo '<td> Case / Reference No. : ' . strtoupper($dataRes['case_ref_no']) . '</td>';
                            }
                            echo '<td>'.'State Name:'.$fir_state_name.'<br>'.'District Name:'.$fir_district_name.'<br>'.'Police Statation Name:'.$fir_police_station_name.'<br>'.'Fir No.'.$fir_complete_fir_no.'</td>';
                            $cc_applied_date = !empty($dataRes['lcc_applied_date']) ? '<br>CC Applied Dt : ' . $dataRes['lcc_applied_date'] : '';
                            $lcc_received_date = !empty($dataRes['lcc_received_date']) ? '<br>CC Ready Dt : ' . $dataRes['lcc_received_date'] : '';
                            if (!empty($dataRes['lower_court_dec_dt'])) {
                                echo '<td> Decision Dt : ' . strtoupper($dataRes['lower_court_dec_dt']) . $cc_applied_date . $lcc_received_date . '</td>';
                            } else {
                                echo '<td> Order Dt : ' . strtoupper($dataRes['date_of_order']) . '</td>';
                            }
                        }
                        else if ($dataRes['sub_qj_high'] == 5) {
                            $court_name = strtoupper('State Agency');
                            $agency_state = !empty($dataRes['agency_state']) ? $dataRes['agency_state'] : NULL;
                            $agency_name = !empty($dataRes['agency_name']) ? $dataRes['agency_name'] : NULL;
                            $case_name = !empty($dataRes['case_name']) ? $dataRes['case_name'] : NULL;
                            $case_year =  !empty($dataRes['case_year']) ? $dataRes['case_year'] : NULL;
                            $case_no =  !empty($dataRes['case_no']) ? $dataRes['case_no'] : NULL;
                            $date_of_order = !empty($dataRes['date_of_order']) ?  $dataRes['date_of_order'] : '';
                            echo '<tr>';
                            echo '<td>' . $i++ . '</td>';
                            echo '<td>' . $court_name . '</td>';
                            echo '<td>'.'State Agency:'. $agency_state.' <br/> Agency Name:'.$agency_name. '</td>';
                            echo '<td> Case Name : ' . $case_name.' <br/>Case No.'.$case_no.'<br/>Case Year:'.$case_year.'</td>';
                            echo '<td>'.'State Name:'.$fir_state_name.'<br>'.'District Name:'.$fir_district_name.'<br>'.'Police Statation Name:'.$fir_police_station_name.'<br>'.'Fir No.'.$fir_complete_fir_no.'</td>';
                            echo '<td> Order Dt : ' . $date_of_order . '</td>';

                        }
                        echo '<td> <a onclick="return confirm(\'Are you sure to delete record ?\');"  href="' . base_url('caveat/subordinate_court/reset_subordinate_court_data/') . url_encryption($dataRes['id'] . '$$delete_id') . '" class="btn btn-danger btn-xs" title="Delete" ><i class="fa fa-trash" aria-hidden="true"></i> Delete</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
