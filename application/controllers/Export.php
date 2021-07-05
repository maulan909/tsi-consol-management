<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Export extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Package_model', 'package');
    }

    public function moved($act = null)
    {
        if ($act == 'download'){
            header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment;filename=Moved Package " . date('H:m:s d-m-Y', time()) . ".xls");
        }
        $data['title'] = 'Moved Package';
        $data['orders'] = $this->package->getAllMoved();
        $this->load->view('export/moved', $data);
    }
    
     public function backup()
    {
        $this->package->backup();
    }
}
