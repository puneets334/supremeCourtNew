@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'Resources')
@section('heading', 'Resources')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')

<div class="uk-margin-small-top uk-border-rounded">
    @php
        $iframe_src_route_uri = 'resources/hand_book';
        if($tab == 'video-tutorial'){
            $iframe_src_route_uri = 'resources/video_tutorial/view';
        }
        else if($tab == 'FAQs'){
            $iframe_src_route_uri = 'resources/FAQ';
        }
	else if($tab == 'hand-book-old-efiling'){
            $iframe_src_route_uri = 'resources/hand_book_old_efiling/';
        }
    else if($tab == 'three-pdf-user-manual'){
        $iframe_src_route_uri = 'resources/Three_PDF_user_manual/';
    }
    @endphp
    <div class="uk-width">
        <div class="uk-button-group">
            <a href="{{base_url('e-resources')}}" class="uk-button {{(current_url() == base_url('e-resources')) ? 'uk-background-secondary text-white' : ''}}">Handbook</a>
            <a href="{{base_url('e-resources/video-tutorial')}}" class="uk-button {{current_url() == base_url('e-resources/video-tutorial') ? 'uk-background-secondary text-white' : ''}}">Video Tutorial</a>
            <a href="{{base_url('e-resources/FAQs')}}" class="uk-button {{current_url() == base_url('e-resources/FAQs') ? 'uk-background-secondary text-white' : ''}}">FAQ</a>
            <a href="{{base_url('e-resources/hand-book-old-efiling')}}" class="uk-button {{current_url() == base_url('e-resources/hand-book-old-efiling') ? 'uk-background-secondary text-white' : ''}}">Refile Old eFiling Cases</a>
            <a href="{{base_url('e-resources/three-pdf-user-manual')}}" class="uk-button {{current_url() == base_url('e-resources/three-pdf-user-manual') ? 'uk-background-secondary text-white' : ''}}">3PDF User Manual</a>
        </div>
    </div>
    <iframe name="content-iframe" class="uk-width uk-margin-small-top internal-content-iframe"  ukheight-viewport="offset-top:true;" src="{{base_url($iframe_src_route_uri)}}"></iframe>

</div>

@endsection