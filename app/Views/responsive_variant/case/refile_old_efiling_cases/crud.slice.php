@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'Refile old efiling cases')
@section('heading', 'Refile old efiling cases')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')

@if(!empty(@$direct_access_params))
<!--<form id="case-document-crud-form" target="case-document-crud-iframe" method="POST" action="{{base_url('case/search/search_case_details')}}">-->
    <?php
    $attribute = array('id' => 'case-document-crud-form', 'target'=>'case-document-crud-iframe');
    echo form_open(base_url('case/search/search_case_details'), $attribute);
    ?>
    @foreach($direct_access_params as $key=>$value)
        <input type="hidden" name="{{$key}}" value="{{$value}}">
    @endforeach
</form>
@endif
<div class="uk-margin-small-top uk-border-rounded">
    <iframe name="case-document-crud-iframe" class="uk-width internal-content-iframe"  src="{{empty(@$direct_access_params) ? base_url('case/search/'.url_encryption('refile_old_efiling_cases')) : ''}}"></iframe>
</div>

<script type="text/javascript">
    $(function(){
        $('#case-document-crud-form').submit();
    });
</script>

@endsection
