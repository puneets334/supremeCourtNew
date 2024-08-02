@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'Advance Summer Vacation List')
@section('heading', '')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')

<div class="uk-margin-small-top uk-border-rounded">
    @php

        $iframe_src_route_uri = 'vacation/advance/alllist';
        if($tab == 'vacation/advance/declinelist'){
            $iframe_src_route_uri = 'vacation/advance/get_declinelist';
        }
    @endphp
    <div class="uk-width">
        <a href="{{base_url('vacation/advance')}}" class="uk-button {{(current_url() == base_url('vacation/advance')) ? 'uk-background-secondary text-white' : ''}}">ADVANCE SUMMER VACATION LIST (ALL MATTERS) - FOR CONSENT</a>
        <a href="{{base_url('vacation/advance/declinelist')}}" class="uk-button {{current_url() == base_url('vacation/advance/declinelist') ? 'uk-background-secondary text-white' : ''}}"> ADVANCE SUMMER VACATION LIST (DECLINED MATTERS)</a>

    </div>
    <iframe name="content-iframe" class="uk-width uk-margin-small-top internal-content-iframe"  ukheight-viewport="offset-top:true;" src="{{base_url($iframe_src_route_uri)}}"></iframe>

</div>

@endsection