@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'Support Center')
@section('heading', 'Support Center')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')

<div class="uk-margin-small-top uk-border-rounded">
    @php
        $iframe_src_route_uri = 'assistance/notice_circulars';
        if($tab == 'contact_us'){
            $iframe_src_route_uri = 'contact_us';
        }
        else if($tab == 'proformas'){
            $iframe_src_route_uri = 'assistance/performas';
        }
    @endphp
    <div class="uk-width">
        <div class="uk-button-group">
            <a href="{{base_url('support/circulars')}}" class="uk-button {{(current_url() == base_url('support') || current_url() == base_url('support/circulars')) ? 'uk-background-secondary text-white' : ''}}">Circulars</a>
            <a href="{{base_url('support/proformas')}}" class="uk-button {{current_url() == base_url('support/proformas') ? 'uk-background-secondary text-white' : ''}}">Proformas</a>
            <a href="{{base_url('support/contact_us')}}" class="uk-button {{current_url() == base_url('support/contact_us') ? 'uk-background-secondary text-white' : ''}}">Contact Us</a>
        </div>
    </div>
    <iframe name="content-iframe" class="uk-width uk-margin-small-top internal-content-iframe"  ukheight-viewport="offset-top:true;" src="{{base_url($iframe_src_route_uri)}}"></iframe>
</div>

@endsection