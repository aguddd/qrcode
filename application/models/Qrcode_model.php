
<?php 
class Qrcode_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function save_qrcode($data, $qr_image, $use_logo) {
        $qrcode_data = array(
            'data' => $data,
            'qr_image' => $qr_image,
            'use_logo' => $use_logo
        );

        return $this->db->insert('qrcodes', $qrcode_data);
    }

    public function get_all_qrcodes() {
        $query = $this->db->get('qrcodes');
        return $query->result_array();
    }
}
