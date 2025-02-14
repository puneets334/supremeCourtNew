<div class="table-responsive" style="height: auto; overflow-x: overlay;">
<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
    <table id="userTable"
        class="table table-striped custom-table ">
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
<!-- Datatable CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>

<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Datatable JS -->
<script src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
<script>
    $(document).ready(function(){
      $('#userTable').DataTable({
         'processing': true,
         'serverSide': true,
         'serverMethod': 'post',
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
            { data: 'allocated_to' },
         ]
      });
   });
</script>