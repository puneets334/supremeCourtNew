<div class="right_col" role="main">
    <div class="row" id="printData">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-edit"></i> Prepare Template</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="panel-body">
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
                @if(isset($template_type) && !empty($template_type))
                @php $url = 'admin/PrepareTemplate_Controller?template_type='.$template_type @endphp
                @else
                @php $url = 'admin/PrepareTemplate_Controller' @endphp
                @endif

                {{form_open($url, $attribute)}}
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="remarks">Template Type</label>
                                    <select name="template_id" id="template_id" class="form-control">
                                        <option value="">Select Template Type</option>
                                        @if (count($templates))
                                            @foreach ($templates as $template)
                                            <option {{ $template_type == $template->id ? 'selected' : '' }} value="{{$template->id}}">{{$template->name}} </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @if(isset($template_type) && !empty($template_type))
                            <div class="col-md-4 col-sm-4 col-xs-4">
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
                        
                        @if(isset($template_type) && !empty($template_type))
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label for="template_text">Template Text</label>
                                    <textarea id="template_text" name="template_text">{{$created_template->template_text}}</textarea>
                                </div>
                            </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <div class="form-group">
                                    @if(!empty($this->session->userdata('login')['ref_m_usertype_id']) && $this->session->userdata('login')['ref_m_usertype_id'] == USER_ADVOCATE)
                                    <button type="submit" class="btn btn-success Download1 btn-block">Download</button>
                                    @else 
                                    <button type="submit" class="btn btn-success Download1 btn-block">Save</button>
                                    @endif
                                </div>
                            </div>
                            {{form_close()}}
                        </div>
                    </div>
                </div>
            </div>
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
                "minHeight": 700,
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
        });
  </script>
