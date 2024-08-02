<?php

$this->load->view('oldCaseRefiling/old_efiling_breadcrumb');


if ($this->uri->segment(1) == 'uploadDocuments' || $this->uri->segment(1) == 'documentIndex') {

    $this->load->view('documentIndex/documentIndex_view');
} elseif ($this->uri->segment(1) == 'documentIndex') {

    $this->load->view('documentIndex/documentIndex_view');
} elseif ($this->uri->segment(1) == 'affirmation') {

    $this->load->view('affirmation/affirmation_view');
} elseif ($this->uri->segment(2) == 'courtFee') {

    $this->load->view('oldCaseRefiling/courtFee_view');
} elseif ($this->uri->segment(2) == 'view') {

    $this->load->view('oldCaseRefiling/old_efiling_preview');
}
?>
</div>
</div>
</div>
</div>             
</div>
</div>
</div>