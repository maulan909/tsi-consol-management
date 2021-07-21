<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tester extends CI_Controller
{
    public function index()
    {
        senderBot("CA/JK/21070219442200/ISLF");
    }
}
