<div class="modal-header">
    <h4 class="modal-title">Appearance Slip</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @if(count($data['is_submitted'])>0)
        <div class="row">
            <div class="col-12">
                <div class="callout callout-danger">
                    You have already submited your appearance slip and forwarded to court master of court room no. {{$posted_data['courtno']}}.
                </div>
            </div>
        </div>
    @else
        <?PHP  
        // pr($postedData['next_dt']);
        // pr($data['added_data']);    
        ?>
        <div class="row">
            <div class="col-12">
                <div class="callout callout-danger">
                    The appearance should be updated by {{config("constants.APPEARANCE_ALLOW_TIME_STRING")}} on the day when the matter is listed.
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body box-profile">

                        <ul class="list-group mb-3">
                            <li class="list-group-item">
                                <b>List Date</b> <a class="float-right">{{date('d-m-Y', strtotime($posted_data['next_dt']))}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Court No.</b> <a class="float-right">{{$posted_data['courtno']}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Item No.</b> <a class="float-right">{{$posted_data['brd_slno']}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Case No.</b> <a class="float-right">{{$posted_data['reg_no_display'] ?: 'Diary No. '.$posted_data['diary_no']}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Title</b> <a class="float-right">{{$posted_data['pet_name'].' Vs. '.$posted_data['res_name']}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Appearing For</b> <a class="float-right">{{$posted_data['appearing_for'] == 'P' ? 'Petitioner' : 'Respondent'}}</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        @if($posted_data['next_dt'] == config("constants.CURRENT_DATE") && date('H:i:s') > config("constants.APPEARANCE_ALLOW_TIME"))
            <span class="badge badge-danger">{{config("constants.MSG_TIME_OUT")}}</span>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Add - Name of Advocates </h3>
                            <div class="card-tools">
                                <span title="Master List - You may add previously added name of advocates"  >
                                    <a href="#"
                                    data-diary_no="{{$posted_data['diary_no']}}"
                                    data-next_dt="{{$posted_data['next_dt']}}"
                                    data-appearing_for="{{$posted_data['appearing_for']}}"
                                    data-courtno="{{$posted_data['courtno']}}"
                                    data-brd_slno="{{$posted_data['brd_slno']}}"
                                    class="fas fa-address-book add_from_case_advocate_master_list text-white" ></a>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <form>
                                <input type="hidden" name="csrf_test_name" value="{{ csrf_token() }}">
                                <div class="input-group">
                                    <select class="form-control cus-form-ctrl mb-2" id="advocate_type" name="advocate_type" aria-labelledby="advocate_type_addon" required>
                                        <option value='Adv.'>Advocate</option>
                                        <option value='Sr. Adv.'>Sr. Advocate</option>
                                        <option value='AOR'>AOR</option>
                                        <option value='Attorney General for India'>Attorney General for India</option>
                                        <option value='Solicitor General'>Solicitor General</option>
                                        <option value='A.S.G.'>A.S.G.</option>
					                    <option value='Advocate General'>Advocate General</option>
                                        <option value='Sr. A.A.G.'>Sr. A.A.G.</option>
                                        <option value='A.A.G.'>A.A.G.</option>
                                        <option value='D.A.G.'>D.A.G.</option>
                                        <option value='Amicus Curiae'>Amicus Curiae</option>
                                    </select>

                                    <select class="form-control cus-form-ctrl mb-2" id="advocate_title" name="advocate_title" aria-labelledby="advocate_title_addon" required>
                                        <option value=''>-Title-</option>
                                        <option value='Mr.'>Mr.</option>
                                        <option value='Mrs.'>Mrs.</option>
                                        <option value='Ms.'>Ms.</option>
                                        <option value='M/S'>M/S</option>
                                        <option value='Dr.'>Dr.</option>
                                        <option value='None'>None</option>
                                    </select>

                                    <input type="text" name="advocate_name" id="advocate_name" placeholder="Type Name ..." class="form-control cus-form-ctrl">
                                    <span class="input-group-append">
                                        <button type="button"
                                        data-diary_no="{{$posted_data['diary_no']}}"
                                        data-next_dt="{{$posted_data['next_dt']}}"
                                        data-appearing_for="{{$posted_data['appearing_for']}}"
                                        data-courtno="{{$posted_data['courtno']}}"
                                        data-brd_slno="{{$posted_data['brd_slno']}}"
                                        name="btn_save" type="button" class=" btn_save quick-btn gray-btn mt-2">Add</button>
                                    </span>
                                    <span class="load_process"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row display_master_list justify-content-center"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">List of Advocates Addded</h3>
                        </div>
                        <div class="card-body p-0">
                            @if($data['added_data'])
                                <table class="table_added_advocates table table-sortable" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Advocate Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="sortable">
                                        @foreach($data['added_data'] as $added_data)
                                            <tr>
                                                <td><span class="drag_to_sort fas fa-arrows-alt"></span>
                                                    <input type="hidden" name="sortable_id[]" value="{{$added_data->id}}" />
                                                </td>
                                                <td>{{$added_data->advocate_title.' '.$added_data->advocate_name.', '.$added_data->advocate_type}}</td>
                                                <td class="text-right py-0 align-middle">
                                                    <span class="badge badge-light">{{date('d-m-Y h:i:s A', strtotime($added_data->entry_date))}}</span>
                                                    <div class="btn-group btn-group-sm advocate_remove_{{$added_data->id}}">
                                                        <a href="#" data-next_dt="{{$posted_data['next_dt']}}" data-id="{{$added_data->id}}" data-is_active="{{$added_data->is_active}}" class="@if($added_data->is_active == 't') btn-danger @else btn-warning @endif btn advocate_remove" title="@if($added_data->is_active == 't') Click to Remove @else Click to Restore @endif">
                                                            @if($added_data->is_active == 't')
                                                                <i class="fa fa-trash"></i></a>
                                                        @else
                                                            <i class="fa fa-repeat"></i></a>
                                                        @endif                                                      
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                No Records Found
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="callout callout-danger">
                    <div class="d-flex">
                        <div class="d-inline-block"> <input type="checkbox" style="min-width: 20px" value="1" class="form-control" name="certify_check_box" id="certify_check_box"  /> </div>
                        <div class="d-inline-block mt-1 ml-2"> I certify that above Senior Advocates/Advocates will appear/appeared in the above mentioned matter. </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-right" style="text-align: right!important;">
                {{ucwords(strtolower(session('user_title'))).' '.ucwords(strtolower(session('user_name')))}}
                <br>
                For the {{$posted_data['appearing_for'] == 'P' ? 'Petitioner' : 'Respondent'}}
            </div>
        </div>

    </div>


@endif


<div class="modal-footer justify-content-between" style="float:right !important;">

    {{-- <h3 class="card-title">Add - Name of Advocates</h3>--}}

    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

    @if(count($data['is_submitted'])==0)
        <button type="button" class="quick-btn gray-btn final-submit"
                data-diary_no="{{$posted_data['diary_no']}}"
                data-next_dt="{{$posted_data['next_dt']}}"
                data-appearing_for="{{$posted_data['appearing_for']}}"
                data-courtno="{{$posted_data['courtno']}}"
                data-brd_slno="{{$posted_data['brd_slno']}}"
                data-case_no="{{$posted_data['reg_no_display'] ?: 'Diary No. '.$posted_data['diary_no']}}"
                data-cause_title="{{$posted_data['pet_name'].' Vs. '.$posted_data['res_name']}}"
        >Submit</button>
    @endif




    {{--<div class="row text-right">
        <br>{{ucwords(strtolower(session('user_title'))).' '.ucwords(strtolower(session('user_name')))}}
        <br>
        For the {{$posted_data['appearing_for'] == 'P' ? 'Petitioner' : 'Respondent'}}
    </div>
    <div class="row">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary final-submit" data-next_dt="{{$posted_data['next_dt']}}" >Submit</button>
    </div>--}}

</div>

<script>
    $(function() {
        $(".display_master_list").hide();

        $('.table-sortable tbody').sortable({
            handle: 'span'
        });
    });
    //$(document).ready(function(){
    //$(function() {


    // });
</script>
