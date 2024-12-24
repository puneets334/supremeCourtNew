@extends('responsive_variant.layouts.master.uikit_scutum_2.index')
@section('title', 'Download Template')
@section('heading', 'Download Template')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection
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
         <div class="col-md-6 col-sm-6 col-xs-6 center-block">
            {{$this->session->flashdata('message')}}
            @if(!empty(validation_errors()))
            <div class='alert alert-danger'>{{validation_errors()}}</div>
            @endif
         </div>
      </div>
      @php 
      $attribute = [
         'class'        => 'form-horizontal',
         'id'           => 'create_update_template', 
         'name'         => 'search_case_details_pdf', 
         'autocomplete' => 'off'
      ];
      @endphp
      @php $url = 'admin/PrepareTemplate_Controller/prepared_templates_download?case='.$case @endphp
      {{form_open($url, $attribute)}}

      <fieldset class="uk-fieldset">
         <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
            <label><input class="uk-radio" type="radio" value="P" name="case_name" {{$case == 'P' ? 'checked':''}}> Petition</label>
            <label><input class="uk-radio" type="radio" value="IA" name="case_name" {{$case == 'IA' ? 'checked':''}}> IA</label>
         </div>
      @if($case == 'P')
         <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
               <div class="form-group">
                  <input type="text" onfocus="document.getElementById('diary_no').value = ''"
                  value="{{ $this->session->flashdata('efileno') }}" name="efileno" id="efileno"
                  class="uk-input" autocomplete="off" placeholder="E-file No">
               </div>
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
            <div class="col-md-3 col-sm-3 col-xs-3 center-block">
               <div class="form-group">
                  <label for="remarks">Template Type</label>
                  <select name="sc_template_type" id="sc_template_type" class="uk-select">
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
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3 center-block">
            <label>&nbsp;</label>
            <div class="form-group">&nbsp;
               <input type="hidden" name="download" id="downloadinput" value="0">
               <button type="submit" id="only_serach" class="uk-button uk-button-primary btn btn-success">Search</button>
            </div>
         </div>
         @if(isset($template_type) && !empty($template_type))
         <div class="col-md-3 col-sm-3 col-xs-3">
         <label for="remarks">Variables:</label>
            @if (count($templates))
               @foreach ($templates as $template)
                     @if($template_type==$template->id)
                     {{$template->variables}}
                     @endif
               @endforeach
            @endif
         </div>
         @endif
      </div>
   
      @if(isset($created_template) && !empty($created_template))
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
               <label for="template_text">Template Text</label>
               <textarea id="template_text" name="template_text">{{$created_template}}</textarea>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-md-4 col-sm-4 col-xs-4">
            <label>&nbsp;</label>
            <div class="form-group">
            <button type="submit" id="download_pdf" class="uk-button uk-button-primary btn btn-success btn-block">Download</button>
            </div>
         </div>
      </div>
      @endif
      </fieldset>
      {{form_close()}}
   </div>
</div>

<link rel="stylesheet" href="<?=base_url('/assets/editor/jodit/jodit.min.css');?>">
<script src="<?=base_url('/assets/editor/jodit/jodit.min.js');?>"></script>
<script>
   if ($('#template_text').length > 0) {
      const editor = Jodit.make("#template_text", {
         "autofocus": true,
         "useSearch": false,
         "askBeforePasteHTML": false,
         "minHeight": 700
      });
   }

   $(document).ready(function(){
      $("#template_id").change(function(){
         if(this.value){
            document.location.href="{{base_url('admin/PrepareTemplate_Controller')}}?template_type="+this.value;
         }else{
            document.location.href="{{base_url('admin/PrepareTemplate_Controller')}}";
         }
      });

      var template_type = '<?php echo $template_type;?>';
      $('input[name=case_name]').change(function(){
         if($(this).val()=='IA'){
               document.location.href="{{base_url('admin/PrepareTemplate_Controller/prepared_templates_download')}}?case="+$(this).val()
         }else{
               document.location.href="{{base_url('admin/PrepareTemplate_Controller/prepared_templates_download')}}?case="+$(this).val()
         }
      });

      if ($('#download_pdf').length > 0) {
         var download_pdf_element = document.getElementById("download_pdf");
         download_pdf_element.onclick = function() {
            document.getElementById('downloadinput').value='1'; 
            setTimeout(function() {
               $('#loading-overlay').hide();
               window.location.replace(window.location.href);
            }, 2000);
         };
      }

      if ($('#only_search').length > 0) {
         var only_search_element = document.getElementById("only_search");
         only_search_element.onclick = function() {
            document.getElementById('downloadinput').value='0';
            setTimeout(function() {
               $('#loading-overlay').hide();
               window.location.replace(window.location.href);
            }, 2000);
         };
      }
   });
  </script>
@endsection