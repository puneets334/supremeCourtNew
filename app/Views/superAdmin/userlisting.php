<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="panel-body">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Emp ID</th>
                            <th>Assigned File Type</th>
                            <th>User Type</th>
                            <th>Present/Absent</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        if(isset($users) && !empty($users)){
                            foreach ($users as $k=>$v) {
                                $first_name = !empty($v->first_name) ? $v->first_name : '';
                                $emailid = !empty($v->emailid) ? $v->emailid : '';
                                $emp_id = !empty($v->emp_id) ? $v->emp_id : '';
                                $attend = (!empty($v->attend) && $v->attend == 'P') ? 'Present' : 'Absent';
                                $pp_a = (!empty($v->pp_a) && $v->pp_a == 'P') ? 'Party In Person' : 'Advocate';
                                $efiling_type = !empty($v->efiling_type) ? $v->efiling_type : '';
                                $user_id = !empty($v->user_id) ? $v->user_id : '';
                                if(isset($efiling_type) && !empty($efiling_type) && $efiling_type != 'NULL'){
                                    $fileType = explode(',',$efiling_type);
                                    $roleText ='';
                                    foreach ($fileType as $k=>$v){
                                        $roleText .= str_replace('_',' ',strtoupper($v)).'</br>';
                                    }
                                }
                                else if($efiling_type == 'NULL'){
                                    $roleText ='---';
                                }
                                echo '<tr>
                                        <td>'.$i.'</td>
                                        <td>'.strtoupper($first_name).'</td>
                                        <td>'.$emp_id.'</td>
                                        <td>'.strtoupper($roleText).'</td>
                                        <td>'.strtoupper($pp_a).'</td>
                                        <td>'.strtoupper($attend).'</td>
                                      
                                    </tr>';
                                $i++;
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

