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
                if ($consol) {
                    $picklist = $this->package->getTotalPicklist($consol['ca_no']);
                    $koli = $this->package->getTotalKoli($consol['ca_no']);
                    if ($consol['status'] == 1) {
                        $status = 'Moved';
                        $zona = 'Tujuan : ' . $picklist['kota'] . ' | ' . $picklist['zona'];
                    } else {
                        $status = 'Consol Staging';
                        $zona = 'Staging : ' . $consol['palet_no'];
                    }
                    $reply = "Result : \nExternal No : " . $consol['ca_no'] . "\nTotal Kelengkapan Picklist : " . $picklist['consol'] . " dari " . $picklist['total'] . " Picklist \nTotal Koli : " . $koli['dry'] . " Dry & " . $koli['frozen'] . " Frozen \nStatus : " . $status . "\n" . $zona;
                } else {
                    $order = $this->db->get_where('tb_order', ['ca_no' => substr($message, 1)]);
                    $picklist = $this->package->getTotalPicklist($order['ca_no']);
                    $koli = $this->package->getTotalKoli($order['ca_no']);
                    $reply = "Result : \nExternal No : " . $order['ca_no'] . "\nTotal Kelengkapan Picklist : " . $picklist['consol'] . " dari " . $picklist['total'] . " Picklist";
                }
            }
        }
        file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . urlencode($reply) . "&parse_mode=HTML");
    }
}
