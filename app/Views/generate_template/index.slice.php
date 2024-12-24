@extends('responsive_variant.layouts.master.uikit_scutum_2.index')
@section('title', 'Generate Template') 
@section('heading', 'Generate Template')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon') @endsection
@section('content')
<style>
    .orcls {
        display: flex;
        align-items: center;
        width: 40px;
        height: 40px;
        font-weight: bold;
    }
</style>
<div class="uk-margin-small-top uk-border-rounded">
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6 ">
                {{$this->session->flashdata('message')}}
                @if(!empty(validation_errors()))
                <div class='alert alert-danger'>{{validation_errors()}}</div>
                @endif
            </div>
        </div>
        @php 
        $attribute = [
            'class'        => 'form-horizontal',
            'id'           => 'generate_template_id', 
            'name'         => 'generate_template_name', 
            'autocomplete' => 'off'
        ];
        @endphp

        @php $url = 'generate_template/GenerateTemplate_Controller/index?case='.$case @endphp

        {{form_open($url, $attribute)}}

        <fieldset class="uk-fieldset">
            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                <label><input class="uk-radio" type="radio" value="P" name="case_name" {{$case == 'P' ? 'checked':''}}> Petition</label>
                <label><input class="uk-radio" type="radio" value="IA" name="case_name" {{$case == 'IA' ? 'checked':''}}> IA</label>
            </div>
            @if($case == 'P')
         <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" onfocus="document.getElementById('diary_no').value = ''"
                value="{{ $this->session->flashdata('efileno') }}" name="efileno" id="efileno"
                class="uk-input" autocomplete="off" placeholder="E-file No"> 
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1 orcls">
               OR
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
               <input type="text" onfocus="document.getElementById('efileno').value = ''"
               value="{{ $this->session->flashdata('diary_no') }}" name="diary_no" id="diary_no"
               class="uk-input" autocomplete="off" placeholder="Diary No">
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                  <select name="diary_year" class="uk-select" id="diary_year" aria-label="Diary Year">
                  <option value="">Select Year</option>
                  @for ($year = 2024; $year > 1973; $year--)
                     @if(isset($diary_year) && !empty($diary_year))
                     <option value="{{$year}}" {{ $diary_year == $year ? 'selected' : '' }}>{{$year}}</option>
                     @else
                     <option value="{{$year}}" {{ $this->session->flashdata('diary_year') == $year ? 'selected' : '' }}>{{$year}}</option>
                     @endif
                  @endfor
                  </select>
            </div>
      </div>
      @else
      <div class="row">
         <div class="col-md-2 col-sm-2 col-xs-2">
            <input type="text" onfocus="document.getElementById('efileno').value = ''"
               value="{{ $this->session->flashdata('diary_no') }}" name="diary_no" id="diary_no"
               class="uk-input" autocomplete="off" placeholder="Diary No">
         </div>
         <div class="col-md-2 col-sm-2 col-xs-2">
            <select name="diary_year" class="uk-select" id="diary_year" aria-label="Diary Year">
            <option value="">Select Year</option>
            @for ($year = 2024; $year > 1973; $year--)
               @if(isset($diary_year) && !empty($diary_year))
               <option value="{{$year}}" {{ $diary_year == $year ? 'selected' : '' }}>{{$year}}</option>
               @else
               <option value="{{$year}}" {{ $this->session->flashdata('diary_year') == $year ? 'selected' : '' }}>{{$year}}</option>
               @endif
            @endfor
            </select>
         </div>
      </div>
      @endif
         <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3 ">
                <label for="remarks">Template Type</label>
                <select name="sc_template_id" id="sc_template_id" class="uk-select">
                    <option value="">Select Template Type</option>
                    @if(count($sc_case_types))
                    @foreach ($sc_case_types as $sc_case_type)
                        @if(isset($template_id))
                        <option {{ $template_id == $sc_case_type->id ? 'selected' : '' }} value="{{$sc_case_type->id}}">{{$sc_case_type->name}} </option>
                        @else
                        <option {{ $this->session->flashdata('template_id') == $sc_case_type->id ? 'selected' : '' }} value="{{$sc_case_type->id}}">{{$sc_case_type->name}} </option>
                        @endif
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3 ">
            <label>&nbsp;</label>
            <div class="form-group">&nbsp;
               <button type="submit" id="only_serach" class="uk-button uk-button-primary btn btn-success">Download</button>
            </div>
         </div>
        </fieldset>
        {{form_close()}}     
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[name=case_name]').change(function(){
            if($(this).val()=='IA'){
                document.location.href="{{base_url('generate_template/GenerateTemplate_Controller/index')}}?case=IA"
            }else{
                document.location.href="{{base_url('generate_template/GenerateTemplate_Controller/index')}}?case=P"
            }
        });
    });
    if ($('#only_serach').length > 0) {
         var only_serach_element = document.getElementById("only_serach");
         only_serach_element.onclick = function() {
            setTimeout(function() {
               $('#loading-overlay').hide();
               window.location.replace(window.location.href);
            }, 2000);
         };
      }
  </script>
@endsection