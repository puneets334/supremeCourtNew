@extends('responsive_variant.layouts.master.uikit_scutum_2.index')
@section('title', 'Add/Clerk(s)')
@section('heading', 'Add Clerk')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection
@section('content')
<style>

.uk-button-success {
    background-color: #82bb42;
    color: #fff;
    background-image: -webkit-linear-gradient(top,#9fd256,#6fac34);
    background-image: linear-gradient(to bottom,#9fd256,#6fac34);
    border-color: rgba(0,0,0,.2);
        border-bottom-color: rgba(0, 0, 0, 0.2);
    border-bottom-color: rgba(0,0,0,.4);
    text-shadow: 0 -1px 0 rgba(0,0,0,.2);
}
</style>
<div class="uk-margin-small-top uk-border-rounded">
    <h3 class="uk-label-warning  uk-text-lighter" style="padding:5px;background-color:#EEEEEE;color:#000000;">{{$add_limit_str}}</h3>
    @php
        $action="clerks/Clerk_Controller/add_clerk";
        $attribute = [
            'class'        => 'form-horizontal form-label-left',  
            'id'           => 'add_clerk_form', 
            'name'         => 'add_clerk_form', 
            'autocomplete' => 'off'
        ];
    @endphp

    {{form_open($action, $attribute)}}
   <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-small uk-grid">
    @if($can_add_clerk)
      <!-- left box start -->
      <div class="uk-visible@m uk-first-column">
         <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">First Name <span style="color: red">*</span> :</label>
            <div class="uk-form-controls">
               <input class="uk-input" type="text" name="first_name" id="first_name" placeholder="First Name"  value="{{$this->session->flashdata('first_name')}}" maxlength="100" minlength="3" tabindex="1">
               {{$this->session->flashdata('error_first_name')}}
            </div>
         </div>
         <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Last Name :</label>
            <div class="uk-form-controls">
               <input class="uk-input" type="text" name="last_name" id="last_name" placeholder="Last Name"  value="{{$this->session->flashdata('last_name')}}" maxlength="100" minlength="3" tabindex="1">
               {{$this->session->flashdata('error_last_name')}}
            </div>
         </div>

         <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-text"><span>Gender <span class="uk-text-danger">*</span> :</span></label>
                <div class="uk-form-controls">
                    <div class="uk-inline">
                        <label class="radio-inline"><input type="radio" id="gender" name="gender" @if($this->session->flashdata('gender')=='M') checked @endif value="M">Male</label>
                        <label class="radio-inline"><input type="radio" id="gender" name="gender" @if($this->session->flashdata('gender')=='F') checked @endif value="F">Female</label>
                        <label class="radio-inline"><input type="radio" id="gender" name="gender" @if($this->session->flashdata('gender')=='O') checked @endif value="O">Other</label>
                        {{$this->session->flashdata('error_gender')}}
                    </div>
                </div>
            </div>
      </div>
      <!-- left box end -->

      <!-- right box start -->
      <div class="uk-visible@m uk-first-column">
         <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Email <span style="color: red">*</span> :</label>
            <div class="uk-form-controls">
               <input class="uk-input" type="email" name="email_id" id="email_id" value="{{$this->session->flashdata('email_id')}}" maxlength="100" placeholder="admin@gmail.com "  tabindex="2"/>
               {{$this->session->flashdata('error_email_id')}}
            </div>
         </div>
         <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Mobile <span style="color: red">*</span> :</label>
            <div class="uk-form-controls">
               <input class="uk-input" type="text" name="mobile_no" id="mobile_no" value="{{$this->session->flashdata('mobile_no')}}" placeholder="9876543XXX" maxlength="10" minlength="10" tabindex="3" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
               {{$this->session->flashdata('error_mobile_no')}}
            </div>
         </div>
         
         
      </div>
      <!-- right box end -->
      <div class="uk-margin uk-width-1-1">
            <input type="submit" class="uk-button uk-button-primary uk-align-center" name="add_arguing_counsel_submit" id="add_arguing_counsel_submit" value="Register">
         </div>
      @endif
   </div>
    {{form_close()}}
    <div class="uk-margin uk-width-1-1 uk-inline">
    {{$this->session->flashdata('error')}}
    {{$this->session->flashdata('success')}}
    </div>

   @if(count($clerks))
   <hr>
    <div class="x_content">
        <h2 class="textwhite uk-margin-remove uk-visible@m ukwidth-expand">Engage/Disengage Clerk(s)</h2>
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap uk-table" width="100%">
            <thead>
                <tr class="success input-sm" role="row" >
                    <th>#S.No.</th>
                    <th>Name</th>
                    <th>Mobile No.</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clerks as $key => $clerk)
                <tr>
                    <td width="4%">{{$key+1}}</td>
                    <td width="10%">{{$clerk->first_name}}</td>
                    <td width="20%">{{$clerk->moblie_number}}</td>
                    <td width="10%">{{$clerk->emailid}}</td>
                    <td width="10%">
                    @if($clerk->gender=='M')
                        Male
                    @elseif($clerk->gender=='F')
                        Female
                    @elseif($clerk->gender=='O')
                        Other
                    @endif
                </td>
                <td>
                    {{date("Y-m-d h.i.s A", strtotime($clerk->created_on))}}
                </td>
                    <td width="10%">
                    @php
                    $action="clerks/Clerk_Controller/engaged_disengaged_clerk";
                        $attribute = [
                        'class'        => 'form-horizontal form-label-left',  
                        'id'           => 'engaged_clerk_form', 
                        'name'         => 'engaged_clerk_form', 
                        'autocomplete' => 'off'
                        ];
                    @endphp
                    {{form_open($action, $attribute)}}
                    <input type="hidden" name="ref_user_id" value="{{$clerk->id}}">
                    @if(is_null($clerk->to_date))
                       
                        <input type="hidden" name="is_engaged" value="1">
                        <button class="uk-button uk-button-success" type="submit">Disengage</button>
                    @else 
                    <input type="hidden" name="is_engaged" value="0">
                    <button class="uk-button uk-button-danger" type="submit">Engage</button>
                    @endif
                    {{form_close()}}
                    </td>
                </tr>
                
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
<script>

</script>
@endsection