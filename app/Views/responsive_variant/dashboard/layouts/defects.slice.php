@if(count($applications))
    <div class="ukcard uk-background-default" uk-drop="mode: click;pos:bottom-justify;boundary: .defects-widget;boundary-align: true;animation:uk-animation-slide-top-medium;" style="border:0.15rem dashed #ccc;border-top:0;">
        <table class="uk-table uk-table-striped uk-table-small uk-table-hover">
            <thead class="md-bg-red-600">
            <tr>
                <th class="uk-text-bold text-white">#</th>
                <th class="uk-text-bold text-white">Case/App</th>
                <th class="uk-text-bold text-white">Started On</th>
            </tr>
            </thead>
            <tbody>
            @foreach($applications as $index=>$application)
            @php
            $redirect_url_prefix = '';
            $params_url_segment = '/'.url_encryption(trim($application->registration_id . '#' . $application->ref_m_efiled_type_id . '#' . 1));
            if ($application->ref_m_efiled_type_id == E_FILING_TYPE_MISC_DOCS) {
            $redirect_url_prefix = 'case/document/crud_registration';
            } elseif($application->ref_m_efiled_type_id == E_FILING_TYPE_IA) {
            $redirect_url_prefix = 'case/interim_application/crud_registration';
            }elseif($application->ref_m_efiled_type_id == E_FILING_TYPE_MENTIONING){
            $params_url_segment='';
            $params_url_segment='/'.$application->registration_id;
            $redirect_url_prefix = 'case/mentioning';


            }
            else if($application->ref_m_efiled_type_id == E_FILING_TYPE_NEW_CASE){
            $redirect_url_prefix = 'case/crud';
            }
            //for caveat
            else if($application->ref_m_efiled_type_id == E_FILING_TYPE_CAVEAT){
            $redirect_url_prefix = 'case/caveat/crud';

            } //for CERTIFICATE
            else if($application->ref_m_efiled_type_id == E_FILING_TYPE_CERTIFICATE_REQUEST){
            $params_url_segment='';
            $params_url_segment='/'.$application->registration_id;
            $redirect_url_prefix = 'case/certificate';

            }
            //for CITATION
            else if($application->ref_m_efiled_type_id == E_FILING_TYPE_CITATION){
            $params_url_segment='';
            //$params_url_segment='/'.$application->diary_no.$application->diary_year;
            $params_url_segment='/'.$application->registration_id;
            $redirect_url_prefix = 'case/citation';

            }
            $orgid = '';
            $resorgid ='';
            if(isset($application->orgid) && !empty($application->orgid) && $application->orgid == 'D1'){
            $orgid ="State Department";
            }
            else if(isset($application->orgid) && !empty($application->orgid) && $application->orgid == 'D2'){
            $orgid ="Central Department";
            }
            else if(isset($application->orgid) && !empty($application->orgid) && $application->orgid == 'D3'){
            $orgid ="Other Organisation";
            }
            if(isset($application->resorgid) && !empty($application->resorgid) && $application->resorgid == 'D1'){
            $resorgid ="State Department";
            }
            else if(isset($application->resorgid) && !empty($application->resorgid) && $application->resorgid == 'D2'){
            $resorgid ="Central Department";
            }
            else if(isset($application->resorgid) && !empty($application->resorgid) && $application->resorgid == 'D3'){
            $resorgid ="Other Organisation";
            }

            $application->efiling_type=str_replace("_"," ",$application->efiling_type)
            @endphp
            @if(!empty($redirect_url_prefix))
            <tr onclick="javascript:window.location.href='{{base_url($redirect_url_prefix.$params_url_segment)}}'" style="cursor:pointer;">
                @else
            <tr>
                @endif
                <td>{{($index+1)}}</td>
                <td>
                    <div>
                        <span class="uk-text-uppercase md-bg-grey-700 md-color-grey-50 uk-text-small" style="padding:0.2rem;">{{$application->efiling_type}}</span>
                        <b class="uk-text-muted">{{$application->efiling_no}}</b>
                    </div>
                    @if(!empty($application->diary_no))
                    <div>{{$application->reg_no_display}} <span class="uk-text-muted">(D. No.: {{$application->diary_no}}/{{$application->diary_year}})</span></div>
                    @endif
                    @if(!empty($application->cause_title))
                    <div><b>P: </b>{{explode('Vs.', ucwords(strtolower($application->cause_title)))[0]}}</div>
                    <div><b>R: </b>{{explode('Vs.', ucwords(strtolower($application->cause_title)))[1]}}</div>
                    @elseif(!empty($application->pet_name))
                    <div><b>P: </b>{{ucfirst($application->pet_name)}}</div>
                    <div><b>R: </b>{{ !empty($application->res_name) ? ucfirst($application->res_name) : '---'}}</div>
                    @elseif(empty($application->pet_name) && empty($application->ecase_cause_title))
                    <div><b>P: </b>{{ucfirst($orgid)}}</div>
                    <div><b>R: </b>{{ucfirst($resorgid)}}</div>


                    @else
                    <div><b>P: </b>{{explode('Vs.', ucwords(strtolower($application->ecase_cause_title)))[0]}}</div>
                    <div><b>R: </b>{{explode('Vs.', ucwords(strtolower($application->ecase_cause_title)))[1]}}</div>

                    @endif
                    <!--@if(!empty($application->pendingstage))
                    <div> <b>Pending At: </b> <span class="md-bg-red-700 md-color-grey-50 uk-text-small" style="padding:0.2rem;">
                                        {{$application->pendingstage}}</span></div>
                    @endif-->
                </td>
                <td>{{$application->activated_on}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif