@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'Add Clerk')
@section('heading', '')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')

<div class="uk-margin-small-top uk-border-rounded">
    <iframe name="content-iframe" class="uk-width internal-content-iframe"  src="{{base_url('add/clerk')}}"></iframe>
</div>

@endsection