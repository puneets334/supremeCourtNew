@extends('admin.master')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .form-group.required .control-label:after {
            content:"*";
            color:red;
        }

    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0">{{$heading}}</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class='row '>
                    <!-- Message -->
                    @if (session('status'))
                        <div class="col-12 alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>{{ session('status') }}</strong></div>
                    @elseif(session('failed'))
                        <div class="col-12 alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>{{ session('failed') }}</strong></div>
                    @endif
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Search</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form class="form-horizontal" method="POST" action="{{ route('advocate::report') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row">


                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">List Date (dd-mm-yyyy)</label>
                                                <div class="input-group date" id="cause_list_date" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input @error('cause_list_date') is-invalid @enderror" value="{{old('cause_list_date')}}" name="cause_list_date" data-target="#cause_list_date"/>
                                                    <div class="input-group-append" data-target="#cause_list_date" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                                    </div>
                                                    @error('cause_list_date')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" name="search" class="btn btn-primary">Search</button>

                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <!-- /.card -->

@if(isset($list))
                        <div class="row">

                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Advocates Appearing for List Date {{$cause_list_date}}</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover table-striped ">
                                                <thead>
                                                <tr>
                                                    <th>SNo.</th>
                                                    <th>Listed On</th>
                                                    <th>Court No.</th>
                                                    <th>Item No.</th>
                                                    <th>Case No.</th>
                                                    <th>Cause Title</th>
                                                    <th>Name of Advocates</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $sno = 1;
                                                @endphp
                                                @foreach($list as $advocate)



                                                    @if($advocate['diary_details']->pno == 2)
                                                        @php $pet_name = $advocate['diary_details']->pet_name." AND ANR."; @endphp
                                                    @elseif($advocate['diary_details']->pno > 2)
                                                        @php $pet_name = $advocate['diary_details']->pet_name." AND ORS."; @endphp
                                                    @else
                                                        @php $pet_name = $advocate['diary_details']->pet_name; @endphp
                                                    @endif

                                                    @if($advocate['diary_details']->rno == 2)
                                                        @php $res_name = $advocate['diary_details']->res_name." AND ANR."; @endphp
                                                    @elseif($advocate['diary_details']->rno > 2)
                                                        @php $res_name = $advocate['diary_details']->res_name." AND ORS."; @endphp
                                                    @else
                                                        @php $res_name = $advocate['diary_details']->res_name; @endphp
                                                    @endif

                                                    <tr>
                                                        <td>{{ $sno++ }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($advocate['list_date'])) }}</td>

                                                        <td>{{ $advocate['court_no'] }}</td>
                                                        <td>{{ $advocate['item_no'] }}</td>
                                                        <td> {{ $advocate['diary_details']->reg_no_display ?: $advocate['diary_details']->diary_no; }} </td>
                                                        <td>
                                                            {{ $pet_name }}<br>
                                                            Vs.
                                                            <br>
                                                            {{ $res_name }}
                                                        </td>
                                                        <td>
                                                            <div>
                                                                @if( $advocate['appearing_for'] == 'P')
                                                                    <u><b>For Petitioner</b></u>
                                                                @else
                                                                    <u><b>For Respondent</b></u>
                                                                @endif
                                                            </div>

                                                            <?php $sub_sno = 1; ?>
                                                            @foreach($advocate['advocate_name'] as $key => $adv_name)
                                                                <div>{{ $sub_sno++.'. '.$adv_name->advocate_title.' '.$adv_name->advocate_name.', '.$adv_name->advocate_type.''; }}</div>
                                                            @endforeach

                                                        </td>

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                        <!-- /.card-footer -->

                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
@endif

                    </div>


                </div>
            </div><!-- /.container-fluid -->
        </section>

    </div>
    <!-- /.content-wrapper -->
    <script>
        $(function () {
            bsCustomFileInput.init();
            $('#cause_list_date').datetimepicker({
                format: 'DD-MM-YYYY'
            });

        });

    </script>
@endsection