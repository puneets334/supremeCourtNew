@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="dashboard-section dashboard-tiles-area"></div>
                <div class="dashboard-section">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="dash-card">
                                {{-- Page Title Start --}}
                                <div class="title-sec">
                                    <h5 class="unerline-title">Cases Transferred by Vakalatnama </h5>
                                    <!-- <a href="javascript:void(0)" class="quick-btn pull-right" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left"></span>Back</a> -->
                                </div>
                                <div class="table-sec">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table first-th-left">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>E-filing Number</th>
                                                    <th>Year</th>
                                                    <th>Diary No.</th>
                                                    <th>Case Transferred On</th>
                                                    <th>Transferred To AOR (AOR code)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ( isset($get_transferred_cases) && is_array($get_transferred_cases) && count($get_transferred_cases) > 0)
                                                    @foreach ($get_transferred_cases as $index=>$case)
                                                    <tr>
                                                        <td>{{$index+1}}</td>
                                                        <td>{{$case->efiling_no}}</td>
                                                        <td>{{$case->efiling_year}}</td>
                                                        <td>{{$case->diary_no}}</td>
                                                        <td>{{$case->updated_on}}</td>
                                                        <td>{{$case->name}} ({{$case->aor_code }})</td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="6">
                                                        <span class="text-danger fw-bold">Record Not Found</span>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection