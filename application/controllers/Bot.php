<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bot extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Package_model', 'package');
        $this->load->model('Consol_model', 'consol');
    }
    public function index()
    {
        $token = "1828680774:AAHIebWcJiKBt0MxpzyWHZheb3ynqDsvFGI";
        $apiURL = "https://api.telegram.org/bot$token";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];

        if (strpos($message, "/start") === 0) {

            file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $chatID . "&parse_mode=HTML");
        }
    }
}
