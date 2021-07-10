<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bot extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Package_model', 'package');
        $this->load->model('Consol_model', 'consol');
        $this->load->model('Bot_model', 'bot');
    }
    public function index()
    {
        $token = "1828680774:AAHIebWcJiKBt0MxpzyWHZheb3ynqDsvFGI";
        $apiURL = "https://api.telegram.org/bot$token";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];

        if (strpos($message, "/start") === 0) {
            $this->bot->insertChatId($chatID);
            $reply = "Bot Consol Siap digunakan!";
        } else if (strpos($message, "//") === 0) {
            if (count_chars($message) > 2) {
                $consol = $this->consol->searchItemConsol(substr($message, 1));
                $status = $consol === 1 ? 'Moved' : 'Consol Staging';
                $picklist = $this->package->getTotalPicklist($consol['ca_no']);
                $koli = $this->package->getTotalKoli($consol['ca_no']);
                $reply = "Result : \n
                            External No : " . $consol['ca_no'] . "\n
                            Total Kelengkapan Picklist : " . $picklist['consol'] . " dari " . $picklist['total'] . " Picklist \n
                            Total Koli : " . $koli['dry'] . " Dry & " . $koli['frozen'] . " Frozen \n
                            Status : " . $status;
            }
        }
        file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $reply . "&parse_mode=HTML");
    }
}
