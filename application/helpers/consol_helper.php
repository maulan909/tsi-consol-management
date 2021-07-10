<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];
        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();
    $access = $ci->db->get_where('user_access_menu', [
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ]);

    if ($access->num_rows() > 0) {
        return 'checked="checked"';
    }
}

function completeCheck($ext)
{
    $ci = get_instance();
    $ci->load->model('Package_model', 'package');
    $picklist = $ci->package->getTotalPicklist($ext);
    $hasil = false;
    if ($picklist['total'] - $picklist['consol'] === 0) {
        $hasil = true;
    }
    return $hasil;
}

function senderBot($data)
{
    $ci = get_instance();
    $ci->load->model('Package_model', 'package');
    $ci->load->model('Bot_model', 'bot');
    $token = "1828680774:AAHIebWcJiKBt0MxpzyWHZheb3ynqDsvFGI";
    $apiURL = "https://api.telegram.org/bot$token";
    $reply = "";
    $picklist = $ci->package->getTotalPicklist($data);
    $koli = $ci->package->getTotalKoli($data);
    $reply .= "Complete Package : \nExternal No : " . $data . "\nKelengkapan Picklist : " . $picklist['consol'] . 'dari ' . $picklist['total'] . " Picklist\nTotal Koli : " . $koli['dry'] . " Dry & " . $koli['frozen'] . " Frozen\nStaging : " . $ci->package->getLocation($data) . "\nTujuan : " . $picklist['kota'] . " | " . $picklist['zona'];
    $target = $ci->bot->getAllChatId();
    foreach ($target as $to) {
        file_get_contents($apiURL . "/sendmessage?chat_id=" . $to['chat_id'] . "&text=" . urlencode($reply) . "&parse_mode=HTML");
    }
}

function escapeString($val)
{
    $db = get_instance()->db->conn_id;
    $val = mysqli_real_escape_string($db, $val);
    return $val;
}

function array_push_indexes($array1, $array2)
{
    $lastKey = array_key_last($array1);
    for ($i = 0; $i < count($array2); $i++) {
        $KeyPosition = 1 + $i;
        $array1[$lastKey + $KeyPosition] = $array2[$i];
    }
    return $array1;
}
