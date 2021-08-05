<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdfview extends CI_Controller
{
    public function index($title)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');
        $this->data['detail'] = json_decode(urldecode($this->input->get('data')), true);
        $paper = [0, 0, 198.333, 421];
        // title dari pdf
        $this->data['title_pdf'] = $title;
        $title = explode(' ', $title);
        $title = implode('_', $title);
        // filename dari pdf ketika didownload
        $file_pdf = $title;
        // setting paper
        // $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "landscape";

        $html = $this->load->view('pdf/view_pdf', $this->data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }
}
