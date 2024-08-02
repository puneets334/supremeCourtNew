@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'Caveat Request in a Case')
@section('heading', 'Caveat Request in a case')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')

<!--@if(!empty(@$direct_access_params))-->
<!--<form id="case_caveat-crud-form" target="case-caveat-crud-iframe" method="POST" action="{{base_url('caveat')}}">-->
<!---->
<!--</form>-->
<!--@endif-->

<div class="uk-margin-small-top uk-border-rounded">

    <iframe name="case-caveat-crud-iframe" class="uk-width internal-content-iframe" src="{{(empty(@$registration_id) ? base_url((@$tab == 'case/caveat/crud/' ? @$tab : 'caveat/'.@$tab)) : base_url('caveat/defaultController/processing/'.($registration_id)))}}">
    </iframe>
</div>


@endsection
