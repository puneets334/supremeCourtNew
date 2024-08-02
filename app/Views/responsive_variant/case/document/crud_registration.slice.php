@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'File a Document')
@section('heading', 'File a Document')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')

<!--@if(!empty(@$direct_access_params))
<form id="case-document-crud-form" target="case-document-crud-iframe" method="POST" action="{{base_url('case/search/search_case_details')}}">
    @foreach($direct_access_params as $key=>$value)
        <input type="hidden" name="{{$key}}" value="{{$value}}">
    @endforeach
</form>
@endif-->
<div class="uk-margin-small-top uk-border-rounded">
    <iframe name="case-document-crud-iframe" class="uk-width internal-content-iframe"  src="{{(empty(@$registration_id) ? base_url((@$tab == 'affirmation' ? @$tab : (@$tab == 'courtFee'?'miscellaneous_docs/'.@$tab:'newcase/'.@$tab) )) : base_url('miscellaneous_docs/defaultController/'.($registration_id)))}}"></iframe>
</div>

<script type="text/javascript">
    $(function(){
        $('#case-document-crud-form').submit();
    });
</script>

@endsection
