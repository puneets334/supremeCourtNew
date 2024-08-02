@if(count($documents))
<div class="ukcard uk-background-default" uk-drop="mode: click;pos:bottom-justify;boundary: {{$uk_drop_boundary ?: '.documents-widget'}};boundary-align: true;animation:uk-animation-slide-top-medium;" style="border:0.15rem dashed #ccc;border-top:0;">

    <table class="uk-table uk-table-striped uk-table-small">
        <thead class="{{empty($uk_drop_boundary) ? 'uk-background-primary' : 'md-bg-grey-500'}}">
            <tr>
                <th class="uk-text-bold text-white">#</th>
                <th class="uk-text-bold text-white">Diary/Case No.</th>
                @if(!empty($type) && $type=='adjournment_requests')
                    <th class="uk-text-bold text-white">Listing Details</th>
                @else
                    <th class="uk-text-bold text-white">Document</th>
                @endif
                <th class="uk-text-bold text-white">Filed By/On</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $index=>$document)
            @if(!empty($type) && $type=='adjournment_requests')
            <tr>
                <td>{{($index+1)}}</td>
                <td>{{substr($document->diary_number,0,-4)}}/{{substr($document->diary_number,-4)}}
                <br/> {{$document->case_number}}
                </td>
                <td class="uk-table-link">
                    <!--<a href="https://main.sci.gov.in/supremecourt/2018/27951/27951_2018_Order_05-Oct-2018.pdf" target="_blank">-->
                    <!--<span class="uk-text-uppercase md-bg-grey-700 md-color-grey-50 uk-text-small" style="padding:0.2rem;">{{$document->typeName}}</span>-->
                    <div>{{date_format(date_create($document->listed_date), 'D, jS M')}}<br/>
                        {{$document->item_number}} in {{$document->court_number}}</div>
                    <!--</a>-->
                </td>
                <td>
                    {{$document->first_name}}<br>
                    {{$document->created_at}}
                </td>
            </tr>
            @else
                <tr>
                    <td>{{($index+1)}}</td>
                    <td>{{substr($document->diaryId,0,-4)}}/{{substr($document->diaryId,-4)}}</td>
                    <td class="uk-table-link">
                        <!--<a href="https://main.sci.gov.in/supremecourt/2018/27951/27951_2018_Order_05-Oct-2018.pdf" target="_blank">-->
                            <span class="uk-text-uppercase md-bg-grey-700 md-color-grey-50 uk-text-small" style="padding:0.2rem;">{{$document->typeName}}</span>
                            <div>{{$document->title}}</div>
                        <!--</a>-->
                    </td>
                    <td>
                        {{$document->filedBy}}<br>
                        {{$document->filedAt}}
                    </td>
                </tr>
            @endif
            @endforeach
        </tbody>
    </table>

</div>
@endif