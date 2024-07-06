<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('login_admin')) {
            redirect('admin/login');
        }
    }

    function index()
    {
        $data['active']     = 'dash';
        $data['judul_1']    = 'Dashboard';
        $data['judul_2']    = 'Selamat Datang | Admin';

        $data['page']       = 'v_dashboard';
        $data['menu']       = $this->Menus->generateMenu();
        $data['breadcumbs'] = array(
            array(
                'nama' => 'Dashboard',
                'icon' => 'fa fa-dashboard',
                'url' => 'admin/dashboard'
            ),
        );

        $nowDate = date('Y-m-d');
        $getPoli = $this->db->get('kategori_poli')->result();

        // Initialize variables
        $data['poli_umum'] = 0;
        $data['poli_gigi'] = 0;
        $data['poli_anak'] = 0;
        $data['poli_tb'] = 0;
        $data['poli_konseling'] = 0;
        $data['poli_kia'] = 0;
        $data['poli_gizi'] = 0;
        $data['poli_im'] = 0; // Added initialization for poli_im

        foreach ($getPoli as $key) {
            $this->db->limit('1');
            $this->db->where('id_poli', $key->id_poli);
            $this->db->where('tgl_antrian_poli', $nowDate);
            $this->db->order_by('no_antrian_poli', 'DESC');
            $antrianpoli = $this->db->get('antrian_poli')->row();

            if ($key->id_poli == 1) {
                $data['poli_umum'] = $antrianpoli ? $antrianpoli->no_antrian_poli : 0;
            } elseif ($key->id_poli == 2) {
                $data['poli_gigi'] = $antrianpoli ? $antrianpoli->no_antrian_poli : 0;
            } elseif ($key->id_poli == 3) {
                $data['poli_anak'] = $antrianpoli ? $antrianpoli->no_antrian_poli : 0;
            } elseif ($key->id_poli == 4) {
                $data['poli_tb'] = $antrianpoli ? $antrianpoli->no_antrian_poli : 0;
            } elseif ($key->id_poli == 5) {
                $data['poli_konseling'] = $antrianpoli ? $antrianpoli->no_antrian_poli : 0;
            } elseif ($key->id_poli == 6) {
                $data['poli_kia'] = $antrianpoli ? $antrianpoli->no_antrian_poli : 0;
            } elseif ($key->id_poli == 7) {
                $data['poli_gizi'] = $antrianpoli ? $antrianpoli->no_antrian_poli : 0;
            }
        }

        $this->load->view('admin/' . $this->session->userdata('theme') . '/v_index', $data);
    }
}
