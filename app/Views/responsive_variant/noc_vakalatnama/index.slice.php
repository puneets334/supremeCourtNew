@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'NOC Vakalatnama')
@section('heading', 'NOC Vakalatnama')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')
<div class="form-response" id="msg" >
    <?php
    /*    if (isset($_SESSION['MSG']) && !empty($_SESSION['MSG'])) {
            echo $_SESSION['MSG'];
        } unset($_SESSION['MSG']);
        */?>
</div>
<!--start akg-->
<style>
    .pointer {cursor: pointer;}
</style>
<div id="widgets-container" ng-init="widgets.recentDocuments.byOthers.ifVisible=true;" class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@l ukchild-width-1-4@xl ukmargin-medium-top uk-grid-medium ukflex-between uk-grid" uk-grid="">

</div>

<!--end akg-->
<div class="uk-margin-small-top uk-border-rounded">


    <!--<div class="uk-width">
    @php
        print_r($scheduled_cases);
        @endphp

    </div>-->
    <div class="uk-width-expand uk-margin-medium-top uk-overflow-auto tabcontent" id="ShowCases">
        <h4 class="uk-heading-bullet uk-text-bold">Cases <span class="uk-text-small">Transferred by Vakalatnama</span></h4>
        <table class="uk-table uktable-justify uktable-striped uk-table-hover uk-table-divider display" id="datatable-responsive">
            <!--<table class="display" style="width:100%" id="efiled-cases-table">-->
            <thead>
            <tr class="uk-text-bold">
                <th class="uk-text-bold d-print-none">#</th>
                <th class="uk-text-bold">E-filing Number</th>
                <th class="uk-text-bold">Year</th>
                <th class="uk-text-bold">Diary No.</th>
                <th class="uk-text-bold">Case Transferred On </th>
                <th class="uk-text-bold">Transferred To AOR (AOR code)</th>
            </tr>
            </thead>
            <!--Start-->

            @foreach ($get_transferred_cases as $index=>$case)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$case['efiling_no']}}</td>
                <td>{{$case['efiling_year']}}</td>
                <td>{{$case['diary_no']}}</td>
                <td>{{$case['updated_on']}}</td>
                <td>{{$case['name']}} ({{$case['aor_code']}})</td>
            </tr>
            @endforeach
            </tbody>

        </table>
    </div>




</div>

@endsection
<script type="text/javascript">
    $('#efiled-cases-table').DataTable({
        "bSort": false
    });
</script>