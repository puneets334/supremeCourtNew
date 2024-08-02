<?php
$segment = service('uri');
?>

@include('IA.ia_breadcrumb')

@if($segment->getSegment(2) == 'caseDetails')

    @include('IA.case_details_view')
@elseif ($segment->getSegment(2) == 'appearing_for')
  
    @include('IA.act_sections_view')
@elseif ($segment->getSegment(1) == 'uploadDocuments' || $segment->getSegment(1) == 'documentIndex')

    @include('documentIndex.documentIndex_view')
@elseif ($segment->getSegment(1) == 'documentIndex') 

    @include('documentIndex.documentIndex_view')
@elseif ($segment->getSegment(1) == 'affirmation') 
  
    @include('miscellaneous_docs.courtFee_view')
@elseif ($segment->getSegment(2) == 'courtFee') 
    @if(getSessionData('efiling_details')['doc_govt_filing']==1)
        @include('newcase.courtFee_view')
    @else
        @include('miscellaneous_docs.courtFee_view')
    @endif
@elseif ($segment->getSegment(1) == 'view')

    @include('miscellaneous_docs.misc_docs_preview')
@endif

</div>
</div>
</div>
</div>             
</div>
</div>
</div>