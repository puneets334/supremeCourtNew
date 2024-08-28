<?php
namespace App\Controllers\OnlineCopying;

use App\Controllers\BaseController;
use App\Models\OnlineCopying\CommonModel;

class DefaultController extends BaseController
{

    protected $session;
    protected $Common_model;

    public function __construct()
    {
        parent::__construct();
        $this->session = \Config\Services::session();
        if (empty($this->session->get('login'))) {
            return response()->redirect(base_url('/'));
        } else {
            is_user_status();
        }

        $this->Common_model = new CommonModel();
    }

    public function copySearch()
    {
        $category = $this->Common_model->getCategory();
        return $this->render('onlineCopying.copy_search', compact('category'));
    }
    
}
