<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="panel-body">
                    <div class="row">
                        <?php
                        $from_date = !empty($typeDetails['from_date']) ? date('d/m/Y',strtotime($typeDetails['from_date'])) : '';
                        $to_date = !empty($typeDetails['to_date']) ? date('d/m/Y',strtotime($typeDetails['to_date'])) : '';
                        $user_type = !empty($typeDetails['user_type']) ? $typeDetails['user_type'] : '';
                        $type = !empty($typeDetails['type']) ? $typeDetails['type'] : '';
                        $file_type = !empty($typeDetails['file_type']) ? $typeDetails['file_type'] : '';
                        $dateLevel =  !empty($typeDetails['dateLevel']) ? $typeDetails['dateLevel'] : '';
                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php
                            echo '<div class="col-md-3 col-sm-3 col-xs-3">
                                <label>Dates :  </label> '.$from_date.' - '.$to_date.'
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <label>File Action : </label> '.$type.' 
                            </div>
                             <div class="col-md-3 col-sm-3 col-xs-3">
                                <label>File Type : </label>  '.$file_type.'
                            </div>
                             <div class="col-md-3 col-sm-3 col-xs-3">
                                <label>User Nmae :  </label> '.$user_type.'
                            </div>
                            ';
                            $fileCaseType = !empty($_GET['fileType']) ? $_GET['fileType'] : NULL;
                            $fileType = !empty($_GET['type']) ? $_GET['type'] : NULL;
                            $diaryCaveatType='';
                            if(isset($fileCaseType) && !empty($fileCaseType) && $fileCaseType == 'N'){
                                $diaryCaveatType = 'DiaryNo / Diary Year';
                            }
                            else  if(isset($fileCaseType) && !empty($fileCaseType) && $fileCaseType == 'C'){
                                $diaryCaveatType = 'CaveatNo / Caveat Year';
                            }
                            else{
                                $diaryCaveatType = 'DiaryNo / Diary Year';
                            }

                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
   <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="panel-body" id="tableData">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr class="success">
                            <th>#</th>
                            <th>Efiling No.</th>
                            <th>Cause Title </th>
                            <th>Stage </th>
                            <th><?php echo $diaryCaveatType;?></th>
                            <th><?php echo $dateLevel;?> </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                      // echo '<pre>'; print_r($listData); //exit;
                        if(isset($listData) && !empty($listData)){?>
                           <?php foreach ($listData as $k=>$v){
                                $registration_id = !empty($v['registration_id']) ? $v['registration_id'] : '';
                                $efiling_number = !empty($v['efiling_no']) ? $v['efiling_no'] : '';
                                $cause_title = !empty($v['cause_title']) ? $v['cause_title'] : '---';
                                $activated_on = !empty($v['activated_on']) ? date('d/m/Y H:i:s',strtotime($v['activated_on'])) : '';
                                $user_stage_name = !empty($v['user_stage_name']) ? strtoupper($v['user_stage_name']) : '';
                                $diaryNo_diaryYear = '---';
                                if(isset($v['diarycaveatno']) && !empty($v['diarycaveatno'])){
                                    $diaryNo = substr($v['diarycaveatno'],0,-4);
                                    $diaryYear = substr($v['diarycaveatno'],-4);
                                    $diaryNo_diaryYear = $diaryNo.' / '.$diaryYear;
                                }elseif(isset($v['misc_docs_ia_diaryno']) && !empty($v['misc_docs_ia_diaryno'])){
                                    $diaryNo = substr($v['misc_docs_ia_diaryno'],0,-4);
                                    $diaryYear = substr($v['misc_docs_ia_diaryno'],-4);
                                    $diaryNo_diaryYear = $diaryNo.' / '.$diaryYear;
                                }
                                   $v='/'.$v['registration_id'].'/' . $v['ref_m_efiled_type_id'] .'/' . $v['stage_id']. '/' .$v['efiling_type'];
                                    $redirect_url =base_url('efiling_search/identify').$v;
                                    $efiling_no = '<a target="_blank" href="' . $redirect_url . '">' . $efiling_number . '</a>';
                             ?>
                                <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $efiling_no;?></td>
                                        <td><?php echo $cause_title;?></td>
                                        <td><?php echo $user_stage_name;?></td>
                                        <td><?php if(!empty($type) && $type=='File Diaries'){ echo $diaryNo_diaryYear;}else{echo '---';}?></td>
                                        <td><?php echo $activated_on;?></td>
                                    </tr>

                           <?php $i++; }?>
                       <?php }?>
                        </tbody></table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#datatable-responsive').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdf',
                    title: 'Admin Report List',
                    filename: 'Report_pdf_file_name'
                }, {
                    extend: 'excel',
                    title: 'Admin Report List',
                    filename: 'Report_excel_file_name'
                }, {
                    extend: 'csv',
                    title: 'Admin Report List',
                    filename: 'Report_csv_file_name'
                }, {
                    extend: 'print',
                    title: 'Admin Report List',
                    filename: 'Report_print_file_name'
                }]

            });
        });
    </script>


