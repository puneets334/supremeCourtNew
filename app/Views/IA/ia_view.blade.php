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


<script>
            $('#disapprove_me').click(function() {

var temp = $('.disapprovedText').text();
temp = $.trim(temp);
var efiling_type_id = '<?php echo $_SESSION['efiling_details']['ref_m_efiled_type_id']; ?>';


if (efiling_type_id != "") {
    $('#disapprove_alerts').show();

    if (temp.length > 500) {
        $('#disapprove_alerts').show();
        $('#disapprove_alerts').html("<p class='message invalid' id='msgdiv'>Maximum length 500 allowed. <span class='close' onclick=hideMessageDiv()>X</span></p>");
    } else {
        if ($('#objection_value').html() != '') {
            $('#obj_remarks').val($('#objection_value').html());
        }
        $('#descr').val($('#editor-one').html());
        $('#disapp_case').submit();
    }


}
});

</script>