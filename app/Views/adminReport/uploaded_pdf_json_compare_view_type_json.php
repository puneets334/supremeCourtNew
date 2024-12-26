<style>
    table {
    table-layout: fixed;
    word-wrap: break-word;
}
    </style>
<div class="right_col" role="main">
    <div class="row" id="printData">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="panel-body">
                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                            <th style="width:33%" scope="col">IITM JSON</th>
                            <th style="width:33%" scope="col">EFILING JSON</th>
                            <th style="width:33%" scope="col">ICMIS JSON</th>
                            </tr>
                        </thead>
                    <tbody>
                        <tr class="d-flex">
                            <td style="width:33%" class="col-4">
                            <?php
                                echo "<pre>";
                                echo json_encode(json_decode($json_detail->iitm_api_json, true), JSON_PRETTY_PRINT);
                                echo "</pre>";
                              ?>
                            </td>
                            <td style="width:33%" class="col-4"><?php 
                           
                            echo "<pre>";
                            echo json_encode(json_decode($json_detail->efiling_json, true), JSON_PRETTY_PRINT);
                            echo "</pre>";
                            ?></td>
                            <td style="width:33%" class="col-4"><?php 
                        
                            echo "<pre>";
                            echo json_encode(json_decode($json_detail->icmis_json, true), JSON_PRETTY_PRINT);
                            echo "</pre>";
                            ?>
                            
                        </td>
                        </tr>
                    </tbody>
                    </table>
                    </div>
     
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#from_date').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            maxDate: new Date
            //defaultDate: '-6d'
        });
      
    });
    </script>