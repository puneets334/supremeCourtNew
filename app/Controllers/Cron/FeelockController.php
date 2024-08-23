<?php
namespace App\Controllers;
require_once APPPATH.'controllers/Shilclient_Controller.php';
class FeelockController extends Shilclient_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('cron/Default_model');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper('functions'); // loading custom functions
        $this->load->database();
    }

    public function index()
    {
        $data = $this->Default_model->pending_court_fee();
        if ($data) {
            $fee_chunks=array_chunk($data, 100);
            foreach($fee_chunks as $index=>$chunk) {
                echo "<br/> Chunk No. " . ($index + 1) . " and Chunk size: " . sizeof($chunk);
                foreach ($chunk as $fee){
                    if(!empty($fee['sc_diary_num']) && !empty($fee['sc_diary_year'])){
                        echo '<br/>'.$fee['transaction_num'].'<br/>';
                        $result = $this->getStatus($fee['transaction_num']);
                        if($result === 0) continue;
                        $result = $this->lockCertificate($fee['sc_diary_num'],$fee['transaction_num'],$fee['sc_diary_year']);
                        var_dump($result);
                    }
                }
            }
        }
        else {
        echo "No Records Found";
        }

    }

}
?>
