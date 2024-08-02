<?php

namespace App\Controllers\Vacation;

use App\Controllers\BaseController;
use App\Models\Vacation\VacationAdvanceModel;

class Advance extends BaseController
{
    protected $Vacation_advance_model;
    protected $session;
    protected $slice;
    protected $agent;
    protected $request;
    protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->Vacation_advance_model = new VacationAdvanceModel();
        $this->session = \Config\Services::session();
        $this->agent = \Config\Services::request()->getUserAgent();
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
        // $this->slice = new Slice();
        helper(['form', 'file']);
    }

    public function index()
    {
        $data['tab'] = 'vacation/advance/alllist';
        $aor_code = $this->session->get('login')['aor_code'];
        $userIDValue = $this->session->get('login')['id'];
        $data = null;
        $data['vacation_advance_list'] = $this->Vacation_advance_model->get_vacation_advance_list($aor_code);
        $data['matters_declined_by_counter'] = $this->Vacation_advance_model->get_matters_declined_by_counter_list($aor_code);
        $data['userIDValue'] = $userIDValue;

        return $this->render('vacation.index', $data);
    }

    public function declinelist()
    {
        $data['tab'] = 'vacation/advance/declinelist';
        return $this->render('vacation.index', $data);
        // $this->slice->view('vacation.index', compact('tab'));
    }

    public function alllist()
    {
        $aor_code = $this->session->get('login')['aor_code'];
        $data = null;
        $data['vacation_advance_list'] = $this->Vacation_advance_model->get_vacation_advance_list($aor_code);
        $data['matters_declined_by_counter'] = $this->Vacation_advance_model->get_matters_declined_by_counter_list($aor_code);
        return $this->render('vacation.getVacationAdvanceListAOR', $data);
    }

    public function get_declinelist()
    {
        $aor_code = $this->session->get('login')['aor_code'];
        $data = null;
        $data['vacation_advance_list'] = $this->Vacation_advance_model->get_vacation_advance_list($aor_code, 'D');
        $data['matters_declined_by_counter'] = $this->Vacation_advance_model->get_matters_declined_by_counter_list($aor_code);
        //echo '<pre>';print_r($data['matters_declined_by_counter']);exit();
        //echo '<pre>';print_r($data);exit();
        $this->load->view('templates/header');
        //$this->load->view('responsive_variant/layouts/master/uikit_scutum_2/index');
        $this->load->view('vacation/getVacationAdvanceListAOR_decline', $data);
        $this->load->view('templates/footer');
    }

    public function declineVacationListCasesAOR()
    {

        $aor_code = $this->session->get('login')['aor_code'];
        $userID = $this->session->get('login')['id'];
        $dairyNos = $_POST['diary_no'];
        $userIP = getClientIP();
        if (empty($dairyNos)) {
            echo '1@@@' . htmlentities("Please select atleast one Case which need to be Decline", ENT_QUOTES);
            exit(0);
        }
        $vacation_advance_list_advocate = $this->Vacation_advance_model->get_vacation_advance_list_advocate($dairyNos, $aor_code);
        if (!empty($vacation_advance_list_advocate)) {
            $this->db->transStart();
            $is_insert_vacation_advance_list_advocate_log = $this->Vacation_advance_model->insert_vacation_advance_list_advocate_log('icmis.vacation_advance_list_advocate_log', $vacation_advance_list_advocate);

            if ($is_insert_vacation_advance_list_advocate_log) {
                $curr_dt_time = date('Y-m-d H:i:s');
                $data = array(
                    'updated_on' => $curr_dt_time,
                    'updated_by' => $userID,
                    'is_deleted' => 't',
                    'updated_from_ip' => getClientIP()
                );
   //             pr($data);
                $builder = $this->db->table('icmis.vacation_advance_list_advocate');
                $builder->whereIn('diary_no', $dairyNos);
                $builder->where('is_deleted', 'f');
                $builder->where('aor_code', $aor_code);
                if ($builder->UPDATE($data)) {
                    echo "2@@@Selected Case Successfully Listed";
                } else {
                    echo "1@@@Selected Case Fail Please check try again";
                }
            }

            $this->db->transComplete();
        }
        /*  } else {
            echo '1@@@' . htmlentities("Accepted Only Request Method Post", ENT_QUOTES);
            exit(0);
        } */
    }

    public function restoreVacationAdvanceListAOR()
    {

        /* $request = \Config\Services::request();
        if ($request->getMethod() === 'post') { */

        $aor_code = $this->session->get('login')['aor_code'];
        $userID = $this->session->get('login')['id'];

        // pr($aor_code);
        $diary_no = $_POST['diary_no'];
        if (empty($diary_no)) {
            echo '1@@@' . htmlentities("Please select atleast one Case which need to be Decline", ENT_QUOTES);
            exit(0);
        }

        $userIP = getClientIP();

        $vacation_advance_list_advocate = $this->Vacation_advance_model->get_vacation_advance_list_advocate_restore($diary_no, $aor_code);
        //echo '<pre>';print_r($vacation_advance_list_advocate);exit();


        if (!empty($vacation_advance_list_advocate)) {
            $sdata = array(
                'id' => $vacation_advance_list_advocate[0]->id,
                'diary_no' => $vacation_advance_list_advocate[0]->diary_no,
                'conn_key' => $vacation_advance_list_advocate[0]->conn_key,
                'is_fixed' => $vacation_advance_list_advocate[0]->is_fixed,
                'aor_code' => $vacation_advance_list_advocate[0]->aor_code,
                'is_deleted' => $vacation_advance_list_advocate[0]->is_deleted,
                'updated_by' => $vacation_advance_list_advocate[0]->updated_by,
                'updated_on' => $vacation_advance_list_advocate[0]->updated_on,
                'updated_from_ip' => $vacation_advance_list_advocate[0]->updated_from_ip,
                'vacation_list_year' => $vacation_advance_list_advocate[0]->vacation_list_year,
            );
            $this->db->transStart();
            $is_insert_vacation_advance_list_advocate_log = $this->Vacation_advance_model->insert_vacation_advance_list_advocate_log('icmis.vacation_advance_list_advocate_log', $sdata);

            // pr($is_insert_vacation_advance_list_advocate_log);
            if ($is_insert_vacation_advance_list_advocate_log) {
                $curr_dt_time = date('Y-m-d H:i:s');
                $data = array(
                    'updated_on' => $curr_dt_time,
                    'updated_by' => $userID,
                    'is_deleted' => 'f',
                    'updated_from_ip' => getClientIP()
                );

                // pr($data);
                $builder = $this->db->table('icmis.vacation_advance_list_advocate');
                $builder->WHERE('diary_no', $diary_no);
                $builder->WHERE('is_deleted', 't');
                $builder->WHERE('aor_code', $aor_code);

                if ($builder->UPDATE($data)) {
                    echo "2@@@Selected Case Successfully Listed";
                } else {
                    echo "1@@@Selected Case Fail Please check try again";
                }
            }
            $this->db->transComplete();
        }
        /*  } else {
            echo '1@@@' . htmlentities("Accepted Only Request Method Post", ENT_QUOTES);
            exit(0);
        } */
    }
}
