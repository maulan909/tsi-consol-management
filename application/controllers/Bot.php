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
        $this->load->model('Additional_model', 'additional');
    }
    public function index()
    {
        $setting = $this->additional->getDataSettings();
        $token = $setting['token_bot'];
        $apiURL = "https://api.telegram.org/bot$token";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];

        if (strpos($message, "/start") === 0) {
            $this->bot->insertChatId($chatID);
            $reply = "Bot Consol Siap digunakan!";
        } else if (strpos($message, "//") === 0) {
            if (count_chars($message) > 2) {
                $this->db->like('external_order', strtoupper(substr($message, 1)), 'before');
                $history = $this->db->get('tb_consol')->row_array();
                if ($history !== null) {
                    $reply = "Result : " . $history['external_order'] . "\nTotal Picklist : " . $history['total_picklist'] . " Picklist \nTotal Koli : " . $history['total_koli'] . " Koli \nStatus : Moved to history \nDate : " . date('H:m:s d/m/Y', $history['move_date']);
                } else {
                    $consol = $this->consol->searchItemConsol(strtoupper(substr($message, 1)));
                    if ($consol) {
                        $picklist = $this->package->getTotalPicklist($consol['ca_no']);
                        $koli = $this->package->getTotalKoli($consol['ca_no']);
                        if ($picklist != null) {
                            if ($consol['status'] == 1) {
                                $status = 'Moved';
                                $zona = 'Tujuan : ' . $picklist['kota'] . ' | ' . $picklist['zona'];
                            } else {
                                $status = 'Consol Staging';
                                $zona = 'Staging : ' . $consol['palet_no'];
                            }
                            $reply = "Result : \nExternal No : " . $consol['ca_no'] . "\nTotal Kelengkapan Picklist : " . $picklist['consol'] . " dari " . $picklist['total'] . " Picklist \nTotal Koli : " . $koli['dry'] . " Dry/Fresh & " . $koli['frozen'] . " Frozen/Chiller \nStatus : " . $status . "\n" . $zona;
                        } else {
                            $reply = "Result : \nExternal No : " . $consol['ca_no'] . "\nTotal Koli : " . $koli['dry'] . " Dry/Fresh & " . $koli['frozen'] . " Frozen/Chiller \nStatus : Undetected.";
                        }
                    } else {
                        $this->db->like('ca_no', strtoupper(substr($message, 1)), 'before');
                        $order = $this->db->get('tb_order')->row_array();
                        $picklist = $this->package->getTotalPicklist($order['ca_no']);
                        $koli = $this->package->getTotalKoli($order['ca_no']);
                        $reply = "Result : \nExternal No : " . $order['ca_no'] . "\nTotal Kelengkapan Picklist : " . $picklist['consol'] . " dari " . $picklist['total'] . " Picklist";
                    }
                }
            }
        }
        file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . urlencode($reply) . "&parse_mode=HTML");
    }
}
