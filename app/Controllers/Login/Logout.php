<?php
namespace App\Controllers\Login;
use App\Controllers\BaseController;
use App\Models\Login\LoginModel;

class Logout extends BaseController {
    protected $session;
    protected $Login_model;
    public function __construct() {
        parent::__construct();
        $this->Login_model = new LoginModel();
        $this->session = \Config\Services::session();
    }

    public function index() {
        $this->logUser($action = 'logout');
        log_message('info', 'User Logged out at ' . date('d-m-Y') . ' at ' . date("h:i:s A") .getClientIP() . '</b><br>User Agent: <b>' . $_SERVER['HTTP_USER_AGENT']);
        // Log the event
    // log_message(
    //     'info', 
    //     'User logged out at ' . date('d-m-Y') . ' at ' . date('h:i:s A') . 
    //     ' | IP Address: ' . $this->getClientIP() . 
    //     ' | User Agent: ' . service('request')->getUserAgent()
    // );

            // Destroy session
            session()->destroy();
        // unset($_SESSION);
        // $this->session->destroy();
        return response()->redirect(base_url('/'));
        exit(0);
    }

    private function logUser($action) {
        $data['log_id'] = !empty(getSessionData('login')) ? getSessionData('login')['log_id'] : '';
        $data['logout_time'] = date('Y-m-d H:i:s');
        $this->Login_model->logUser($action, $data);
    }

}

?>
