<?php
defined('BASEPATH') or exit('No direct script access allowed');
include('Super.php');

class Dokter extends Super
{

    function __construct()
    {
        parent::__construct();
        $this->language       = 'indonesian';
        $this->tema           = "flexigrid";
        $this->tabel          = "dokter";
        $this->active_id_menu = "Dokter";
        $this->nama_view      = "Dokter";
        $this->status         = true;
        $this->field_tambah   = array();
        $this->field_edit     = array();
        $this->field_tampil   = array();
        $this->folder_upload  = 'assets/uploads/files';
        $this->add            = true;
        $this->edit           = true;
        $this->delete         = true;
        $this->crud;

        // Setup relasi dengan kategori_poli
        $this->crud->set_relation('id_poli', 'kategori_poli', 'nama_poli');
    }

    function index()
    {
        $data = [];
        $data = array_merge($data, $this->generateBreadcrumbs()); // Ubah "Breadcumbs" menjadi "Breadcrumbs"
        $data = array_merge($data, $this->generateData());
        $this->generate();

        // Customize add data fields display
        $this->crud->callback_add_field('id_poli', function () {
            // Load data from 'kategori_poli' table
            $kategori_poli = $this->db->get('kategori_poli')->result_array();

            // Build select options
            $options = '<select name="id_poli" class="form-control">';
            foreach ($kategori_poli as $poli) {
                $options .= '<option value="' . $poli['id_poli'] . '">' . $poli['nama_poli'] . '</option>';
            }
            $options .= '</select>';

            return $options;
        });

        $data['output'] = $this->crud->render();
        $this->load->view('admin/' . $this->session->userdata('theme') . '/v_index', $data);
    }

    private function generateBreadcrumbs()
    {
        $data['breadcrumbs'] = array(
            array(
                'nama' => 'Dashboard',
                'icon' => 'fa fa-dashboard',
                'url' => 'admin/dashboard'
            ),
            array(
                'nama' => 'Admin',
                'icon' => 'fa fa-users',
                'url' => 'admin/useradmin'
            ),
        );
        return $data;
    }
}
