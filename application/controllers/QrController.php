<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QrController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ciqrcode');
        $this->load->helper('url'); // Memuat URL helper
        $this->load->model('Qrcode_model');
    }

    public function index() {
        $this->load->view('generate_qrcode_form');
    }

    public function list() {
        $data['qrcodes'] = $this->Qrcode_model->get_all_qrcodes();
        $this->load->view('qrcode_list', $data);
    }

    public function download($filename) {
        $this->load->helper('download');
        $filepath = FCPATH . 'uploads/qrcodes/' . $filename;

        if (file_exists($filepath)) {
            force_download($filepath, NULL);
        } else {
            echo 'File not found!';
        }
    }

    public function generate_qrcode() {
        $data = $this->input->post('data');
        $use_logo = $this->input->post('use_logo') ? true : false;

        // Konfigurasi QR code
        $config['cacheable']    = true;
        $config['cachedir']     = './uploads/';
        $config['errorlog']     = './uploads/';
        $config['imagedir']     = './uploads/qrcodes/';
        $config['quality']      = true;
        $config['size']         = '1024';
        $config['black']        = array(224,255,255);
        $config['white']        = array(70,130,180);
        $this->ciqrcode->initialize($config);

        $image_name = 'qr_'.time().'.png'; //buat name dari qr code sesuai dengan waktu

        $params['data'] = $data; //data yang akan ditampilkan pada QR Code
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name;
        $this->ciqrcode->generate($params); // fungsi untuk generate QR Code

        // Menambahkan logo ke tengah QR code jika dipilih
        if ($use_logo) {
            $logo = FCPATH.'assets/images/logo.png'; // Path ke logo
            $this->add_logo(FCPATH.$config['imagedir'].$image_name, $logo);
        }

        // Simpan data ke database
        $this->Qrcode_model->save_qrcode($data, $image_name, $use_logo);

        echo '<h3>QR Code Generated Successfully</h3>';
        echo '<img src="'.base_url().'uploads/qrcodes/'.$image_name.'" />';
        echo '<br><a href="'.base_url('').'">Generate Another QR Code</a>';
        echo '<br><a href="'.base_url('index.php/generate_qrcode_list').'">View Generated QR Codes</a>';
    
    }

    private function add_logo($qr_image, $logo) {
        $QR = imagecreatefrompng($qr_image);
        $logo = imagecreatefrompng($logo);
    
        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);
    
        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);
    
        // Ubah nilai 5 menjadi nilai yang lebih kecil untuk memperbesar logo (misalnya, 3 atau 4)
        $logo_qr_width = $QR_width / 3; // Semakin kecil pembaginya, semakin besar logo
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;
    
        // Mengaktifkan blending warna dan memastikan transparansi disimpan
        imagealphablending($QR, true);
        imagesavealpha($QR, true);
        imagealphablending($logo, true);
        imagesavealpha($logo, true);
    
        // Menambahkan logo dengan transparansi ke QR code
        imagecopyresampled($QR, $logo, ($QR_width - $logo_qr_width) / 2, ($QR_height - $logo_qr_height) / 2, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
    
        // Menyimpan gambar QR yang sudah ditambahkan logo
        imagepng($QR, $qr_image);
        imagedestroy($QR);
        imagedestroy($logo);
    }
    
}
