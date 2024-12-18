<div class="panel panel-default">
    <div class="panel-body">
        <h4 style="text-align: center;color: #31B0D5">Defect Petition Documents Report </h4>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr class="success">
                    <th>S.N.</th>
                    <th>Defect Label </th>
                    <th>Defect Status </th>
                    <th>Defect Affected Pages </th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($defect_list)){
                $sr = 1;

                foreach ($defect_list as $json) {
                    $defect_affected_pages=$defect_affected_pages_1=$defect_affected_pages_2=$defect_status='';
                    if (!empty($json['defect_data'])){
                        if (is_array($json['defect_data']['defect_affected_pages'])){
                            if (isset($json['defect_data']['defect_affected_pages']['system_truth'])){

                            }else{
                                $defect_affected_pages_1=$json['defect_data']['defect_affected_pages'][0];
                                $defect_affected_pages_2=$json['defect_data']['defect_affected_pages'][1];
                            }
                        }
                    }

                    ?>
                    <tr>
                        <td><?= $sr++; ?></td>
                        <td><?= $json['defect_label']; ?></td>
                        <td><?= $json['defect_data']['defect_status'];?></td>
                        <td><?= !empty($defect_affected_pages_1) && !empty($defect_affected_pages_2) ? $defect_affected_pages_1.'/'.$defect_affected_pages_2 :$defect_affected_pages_1.$defect_affected_pages_2;?></td>


                    </tr>
                <?php } }?>

                </tbody>
            </table>


        </div>
    </div>
</div>