<?php
$this->load->view('miscellaneous_docs/misc_docs_breadcrumb');

if ($this->uri->segment(1) == 'uploadDocuments' || $this->uri->segment(1) == 'documentIndex') {

    //$this->load->view('uploadDocuments/upload_document');
    $this->load->view('documentIndex/documentIndex_view');
} elseif ($this->uri->segment(1) == 'documentIndex') {

    $this->load->view('documentIndex/documentIndex_view');
} elseif ($this->uri->segment(1) == 'affirmation') {

    $this->load->view('affirmation/affirmation_view');
} elseif ($this->uri->segment(2) == 'courtFee') {
    if($this->session->efiling_details['doc_govt_filing']==1)
        $this->load->view('newcase/courtFee_govt_view');
    else
        $this->load->view('miscellaneous_docs/courtFee_view');

} elseif ($this->uri->segment(2) == 'view') {

    $this->load->view('miscellaneous_docs/misc_docs_preview');
}
?>
</div>
</div>
</div>
</div>             
</div>
</div>
</div>