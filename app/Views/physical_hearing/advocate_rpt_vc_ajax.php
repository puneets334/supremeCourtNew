<?php
if(is_array($list))
{
?>

    <div id="show_result" >
        <hr>
        <?php if(!empty($list)) { ?>
        <p class="table_heading"><u>Consent for Dated : <?= $date_of_hearing; ?>,  Total Entries : <?= $case_count; ?></u></p>
        <?php } ?>
        <table id="head" style="display:none;">
            <caption> </caption>

            <thead>
            <tr>
                <th>#</th>
                <th>Search by List Date</th>
                <th>Search by Court No</th>
                <th>Search by Item No</th>
                <th>Search by Total cases</th>
                <th>Search by Cases</th>
                <th>Search by Consent</th>
                <th>Search by Updated On</th>
            </tr>
            </thead>
        </table>

        <table id="reportTable1" class="table table-striped table-hover">
            <thead>
            <tr>
                <th style="width:2%;">#</th>
                <th style="width:5%;" class="lead text-center">List Date</th>
                <th style="width:5%;" class="lead text-center">Court No</th>
                <th style="width:5%;" class="lead text-center">Item No</th>
                <th style="width:10%;" class="lead text-center">Total Cases</th>
                <th style="width:40%;" class="lead text-center">Consent given for Cases</th>
                <th style="width:5%;" class="lead text-center">Mode of Hearing</th>
                <th style="width:5%;" class="lead text-center">Updated On</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($list as $value)
            {
                ?>
                <tr>
                    <th style="width:5%;">#</th>
                    <td class="lead text-center"><?=  date("d-m-Y", strtotime($value['next_dt'])); ?> </td>
                    <td class="lead text-center"><?= $value['court_no']; ?> </td>
                    <td class="lead text-center"><?= $value['item_number'] ;?></td>
                    <td class="lead text-center"><?= $value['case_count'] ;?></td>
                    <td class="lead text-center"><?= $value['consent_for_cases'] ;?></td>
                    <th class="lead text-center"><?= $value['consent'] ;?></th>
                    <td class="lead text-center"><?= $value['updated_on'] ;?></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
        <br>
    </div><!--END OF DIV id="show_result"-->
    <?PHP
}
else
    echo "Data Not Found! ";

?>
<script>
    $(document).ready(function () {
        $('#head thead tr').clone(true).prependTo('#reportTable1 thead');
        $('#reportTable1 thead tr:eq(0) th').each(function (i) {
            if (i != 0 && i != 8) {
                var title = $(this).text();
                var width = $(this).width();
                if (width > 200) {
                    width = width - 100;
                }
                else if (width < 100) {
                    width = width + 20;
                }
                $(this).html('<input type="text" style="width: ' + width + 'px" placeholder="' + title + '" />');

                $('input', this).on('keyup change', function () {
                    if (t.column(i).search() !== this.value) {
                        t
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });


        var t = $('#reportTable1').DataTable({
            "order": [[1, 'asc']],
            "ordering": false,
            "lengthMenu": [5],
            fixedHeader: true,
            scrollX: true,
            autoFill: true,
            dom: 'Brtip',
            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        // columns: ':visible',
                        columns: [0, 1, 2, 3, 4, 5, 6],
                        stripHtml: false
                    }
                }
            ]



        });

        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
                t.cell(cell).invalidate('dom');
            });
        }).draw();
    });
</script>