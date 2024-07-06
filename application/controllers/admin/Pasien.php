<?php
defined('BASEPATH') or exit('No direct script access allowed');
include('Super.php');

class Pasien extends Super
{
    function __construct()
    {
        parent::__construct();
        $this->language       = 'indonesian';
        $this->tema           = "flexigrid";
        $this->tabel          = "pasien";
        $this->active_id_menu = "Pasien";
        $this->nama_view      = "Pasien";
        $this->status         = true;
        $this->field_tambah   = array('no_identitas', 'nama', 'jenis_kelamin', 'tgl_lahir', 'alamat', 'no_telp', 'pengguna_bpjs', 'no_bpjs', 'jenis_pendaftaran');
        $this->field_edit     = array();
        $this->field_tampil   = array('no_identitas', 'nama', 'jenis_kelamin', 'tgl_lahir', 'alamat', 'no_telp', 'pengguna_bpjs', 'no_bpjs', 'jenis_pendaftaran');
        $this->folder_upload  = 'assets/uploads/files';
        $this->add            = true;
        $this->edit           = false;
        $this->delete         = false;
        $this->crud;

        // Ensure callbacks are properly set
        $this->crud->callback_before_insert(array($this, 'set_jenis_pendaftaran_offline'));
        $this->crud->callback_before_insert(array($this, 'encrypt_password_callback'));
    }

    function index()
    {
        $data = [];
        if ($this->crud->getState() == "save")
            redirect(base_url('admin/Pasien/save_data'));

        /** Bagian GROCERY CRUD USER**/
        // Add custom action
        $this->crud->add_action('Print', '', '', 'fa fa-print', array($this, 'print_data'));

        /** Relasi Antar Tabel 
         * @parameter (nama_field_ditabel_ini, tabel_relasi, field_dari_tabel_relasinya)
         **/
        // $this->crud->set_relation('id_kategori','kategori','nama_kategori');
        // $this->crud->set_relation_n_n('warna','relasi_warna','warna','id_produk','id_warna','warna');

        /** Upload **/
        // $this->crud->set_field_upload('nama_field_upload',$this->folder_upload);  
        // $this->crud->set_field_upload('gambar',$this->folder_upload);  

        /** Ubah Nama yang akan ditampilkan**/
        // $this->crud->display_as('nama','Nama Setelah di Edit')
        //     ->display_as('email','Email Setelah di Edit'); 

        /** Akhir Bagian GROCERY CRUD Edit Oleh User**/
        $data = array_merge($data, $this->generateBreadcumbs());
        $data = array_merge($data, $this->generateData());

        // Set field type for jenis_kelamin as dropdown
        $this->crud->field_type('jenis_kelamin', 'dropdown', array('Laki-Laki' => 'Laki-Laki', 'Perempuan' => 'Perempuan'));

        $this->generate();
        $data['output'] = $this->crud->render();
        $data['print_url'] = base_url('admin/Pasien/print_all'); // Pass the print URL to the view
        $data['active_id_menu'] = $this->active_id_menu; // Pass active_id_menu to the view
        $this->load->view('admin/' . $this->session->userdata('theme') . '/v_index', $data);
    }

    public function print_data($primary_key, $row)
    {
        return site_url('admin/Pasien/print_data_view/' . $primary_key);
    }

    public function print_data_view($id)
    {
        // Load the data for the specific patient
        $data['pasien'] = $this->db->get_where('pasien', ['id_pasien' => $id])->row();

        // Load the view for printing
        $this->load->view('admin/print_pasien', $data);
    }

    public function print_all()
    {
        // Load all patients' data
        $data['pasien'] = $this->db->get('pasien')->result();

        // Load the view for printing
        $this->load->view('admin/print_all', $data);
    }

    private function generateBreadcumbs()
    {
        $data['breadcumbs'] = array(
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

    function encrypt_password_callback($post_array)
    {
        $post_array['password'] = md5($post_array['password']);
        return $post_array;
    }

    function set_jenis_pendaftaran_offline($post_array)
    {
        $post_array['jenis_pendaftaran'] = 'Offline';
        return $post_array;
    }
}
