<div class="table-responsive" style="height: auto; overflow-x: overlay;">
<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
<div class="table-sec">
                                                        <div class="table-responsive">
    <table id="userTables"
        class="table table-striped custom-table " style="width: 100% !important">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Stage</th>
                <th>eFiling No.</th>
                <th>Type</th>
                <th>Case Detail</th>
                <th>Submitted On</th>
                <th>...</th>
                <th>Allocated To DA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $allocated = '';
            
            ?>
        </tbody>
    </table>
</div>
</div>
</div>
<script>
    $(document).ready(function(){
      $('#userTables').DataTable({
         'processing': true,
         'serverSide': true,
         'serverMethod': 'post',
         'searching' : false,
         'ajax': {
            'url':"<?=base_url('getData')?>",
            'data': function(data){
               // CSRF Hash
               var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
               var csrfHash = $('.txt_csrfname').val(); // CSRF hash

               return {
                  data: data,
                  [csrfName]: csrfHash // CSRF Token
               };
            },
            dataSrc: function(data){

              // Update token hash
              $('.txt_csrfname').val(data.token);

              // Datatable data
              return data.aaData;
            }
         },
         'columns': [
            { data: 'id' },
            { data: 'user_stage_name' },
            { data: 'efiling_no' },
            { data: 'type' },
            { data: 'case_details' },
            { data: 'submitted_on' },
            { data: 'action' },
            { data: 'allocated_to' },
         ]
      });
   });
</script>