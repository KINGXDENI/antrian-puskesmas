<?php
defined('BASEPATH') or exit('No direct script access allowed');
include('Super.php');

class LaporanPoliUmum extends Super
{
    private $poli_ids = array(
        1 => 'Poli Umum',
        2 => 'Poli Gigi',
        3 => 'Poli Anak',
        4 => 'Poli Tubercolosis',
        5 => 'Poli Konseling',
        6 => 'Poli KIA',
        7 => 'Poli Gizi'
    );

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('login_admin')) {
            redirect('admin/login');
        }

        $this->load->model('Menus'); // Pastikan model Menus sudah di-load
    }

    function index()
    {
        $data['active']     = 'LaporanPoliUmum';
        $data['judul_1']    = 'Laporan Poli Umum';
        $data['judul_2']    = 'Jumlah Pasien Mingguan dan Bulanan';
        $data['page']       = 'v_laporan_poli_umum';
        $data['menu']       = $this->Menus->generateMenu(); // Menambahkan variabel menu
        $data['breadcumbs'] = array(
            array(
                'nama' => 'Laporan Poli Umum',
                'icon' => 'fa fa-file',
                'url' => 'admin/LaporanPoliUmum'
            ),
        );

        $poli_id = $this->input->post('poli');
        $periode = $this->input->post('periode');

        if ($poli_id && $periode) {
            switch ($periode) {
                case 'weekly':
                    $data['data_view'] = $this->getWeeklyData($poli_id);
                    break;
                case 'monthly':
                    $data['data_view'] = $this->getMonthlyData($poli_id);
                    break;
                case 'yearly':
                    $data['data_view'] = $this->getYearlyData($poli_id);
                    break;
                default:
                    $data['data_view'] = array();
            }
            $data['poli_id'] = $poli_id;
            $data['periode'] = $periode;
        } else {
            $data['data_view'] = array();
        }

        $data['poli_names'] = $this->poli_ids;

        $this->load->view('admin/' . $this->session->userdata('theme') . '/v_index', $data);
    }

    private function getWeeklyData($poli_id)
    {
        $this->db->select('YEAR(tgl_antrian_poli) as year, WEEK(tgl_antrian_poli, 1) as week, COUNT(*) as total');
        $this->db->where('id_poli', $poli_id);
        $this->db->group_by(array('year', 'week'));
        $this->db->order_by('year', 'DESC');
        $this->db->order_by('week', 'DESC');
        $result = $this->db->get('antrian_poli')->result();

        return array_map(function ($item) {
            return (object) [
                'date' => $item->year . '-W' . $item->week,
                'total' => $item->total
            ];
        }, $result);
    }

    private function getMonthlyData($poli_id)
    {
        $this->db->select('DATE_FORMAT(tgl_antrian_poli, "%Y-%m") as month, COUNT(*) as total');
        $this->db->where('id_poli', $poli_id);
        $this->db->group_by('month');
        $this->db->order_by('month', 'DESC');
        $result = $this->db->get('antrian_poli')->result();

        return array_map(function ($item) {
            return (object) [
                'date' => $item->month,
                'total' => $item->total
            ];
        }, $result);
    }

    private function getYearlyData($poli_id)
    {
        $this->db->select('YEAR(tgl_antrian_poli) as year, COUNT(*) as total');
        $this->db->where('id_poli', $poli_id);
        $this->db->group_by('year');
        $this->db->order_by('year', 'DESC');
        $result = $this->db->get('antrian_poli')->result();

        return array_map(function ($item) {
            return (object) [
                'date' => $item->year,
                'total' => $item->total
            ];
        }, $result);
    }
}