@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'File an IA')
@section('heading', 'File an IA')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')

<!--@if(!empty(@$direct_access_params))
<form id="case-ia-crud-form" target="case-ia-crud-iframe" method="POST" action="{{base_url('case/search/search_case_details')}}">
    @foreach($direct_access_params as $key=>$value)
        <input type="hidden" name="{{$key}}" value="{{$value}}">
    @endforeach
</form>
@endif-->
<div class="uk-margin-small-top uk-border-rounded">
    <iframe name="case-ia-crud-iframe" class="uk-width internal-content-iframe"  src="{{(empty(@$registration_id) ? base_url((@$tab == 'affirmation' ? @$tab : (@$tab == 'courtFee'?'IA/'.@$tab:'newcase/'.@$tab) )) : base_url('IA/defaultController/'.($registration_id)))}}"></iframe>
</div>

<script type="text/javascript">
    $(function(){
        $('#case-ia-crud-form').submit();
    });
</script>

@endsection
