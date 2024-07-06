<?php
defined('BASEPATH') or exit('No direct script access allowed');
include('Super.php');

class Antrian_poli extends Super
{
    function __construct()
    {
        parent::__construct();
        $this->language = 'indonesian';
        $this->tema = "flexigrid";
        $this->tabel = "antrian_poli";
        $this->active_id_menu = "Antrian poli";
        $this->nama_view = "Antrian poli";
        $this->status = true;
        $this->field_tambah = array();
        $this->field_edit = array();
        $this->field_tampil = array('id_poli', 'id_pasien', 'tgl_antrian_poli', 'no_antrian_poli', 'status');
        $this->folder_upload = 'assets/uploads/files';
        $this->add = true;
        $this->edit = false;
        $this->delete = false;
        $this->crud;
    }

    function index()
    {
        $data = [];
        if ($this->crud->getState() == "add")
            redirect(base_url('admin/Antrian_poli/addAntrianPoli'));

        $this->crud->set_relation('id_pasien', 'pasien', 'nama');
        $this->crud->set_relation('id_poli', 'kategori_poli', 'nama_poli');
        $this->crud->display_as('id_poli', 'Poli');
        $this->crud->display_as('id_pasien', 'Nama Pasien');

        // Adding approve, reject, and print actions
        $this->crud->add_action('Approve', '', 'admin/Antrian_poli/approve', 'btn btn-success');
        $this->crud->add_action('Reject', '', 'admin/Antrian_poli/reject', 'btn btn-danger');
        $this->crud->add_action('Cetak', '', 'admin/Antrian_poli/cetak', 'btn btn-primary');

        $data = array_merge($data, $this->generateBreadcumbs());
        $data = array_merge($data, $this->generateData());
        $this->generate();
        $data['output'] = $this->crud->render();
        $this->load->view('admin/' . $this->session->userdata('theme') . '/v_index', $data);
    }

    public function approve($id_antrian_poli)
    {
        $this->db->where('id_antrian_poli', $id_antrian_poli);
        $this->db->update('antrian_poli', ['status' => 'approved']);
        redirect(base_url('admin/Antrian_poli'));
    }

    public function reject($id_antrian_poli)
    {
        $this->db->where('id_antrian_poli', $id_antrian_poli);
        $this->db->update('antrian_poli', ['status' => 'rejected', 'no_antrian_poli' => 0]);
        redirect(base_url('admin/Antrian_poli'));
    }

    public function cetak($id_antrian_poli = NULL)
    {
        // Ambil data antrian dengan join kategori_poli
        $this->db->select('antrian_poli.*, kategori_poli.nama_poli');
        $this->db->where('id_antrian_poli', $id_antrian_poli);
        $this->db->join('kategori_poli', 'kategori_poli.id_poli = antrian_poli.id_poli');
        $data['row'] = $this->db->get('antrian_poli')->row();

        if (!empty($data['row'])) {
            // Ambil nama dokter berdasarkan id_poli dari tabel dokter
            $this->db->select('nama_dokter');
            $this->db->where('id_poli', $data['row']->id_poli);
            $dokter = $this->db->get('dokter')->row();

            // Simpan nama dokter ke dalam data untuk ditampilkan di view
            $data['nama_dokter'] = !empty($dokter) ? $dokter->nama_dokter : 'Nama Dokter Tidak Tersedia';

            // Ambil data pasien berdasarkan id_pasien dari tabel antrian_poli
            $this->db->select('nama, no_identitas, tgl_lahir, alamat, no_telp');
            $this->db->where('id_pasien', $data['row']->id_pasien);
            $data_pasien = $this->db->get('pasien')->row();

            // Simpan data pasien ke dalam data untuk ditampilkan di view
            $data['nama_pasien'] = $data_pasien->nama;
            $data['no_identitas'] = $data_pasien->no_identitas;
            $data['tgl_lahir'] = $data_pasien->tgl_lahir;
            $data['alamat'] = $data_pasien->alamat;
            $data['no_hp'] = $data_pasien->no_telp;
        } else {
            // Handle jika data antrian tidak ditemukan
            $data['row'] = null;
            $data['nama_dokter'] = 'Nama Dokter Tidak Tersedia';
            $data['nama_pasien'] = 'Nama Pasien Tidak Ditemukan';
            $data['no_identitas'] = 'Nomor Identitas Tidak Ditemukan';
            $data['tgl_lahir'] = 'Tanggal Lahir Tidak Ditemukan';
            $data['alamat'] = 'Alamat Tidak Ditemukan';
            $data['no_hp'] = 'Nomor HP Tidak Ditemukan';
        }

        // Load view 'user/cetak' dengan data yang sudah disiapkan
        $this->load->view('admin/cetak', $data);
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

    public function addAntrianPoli()
    {
        $data = [];
        $data = array_merge($data, $this->generateBreadcumbs());
        $data = array_merge($data, $this->generateData());
        $this->generate();

        $rowPoli = $this->db->get('kategori_poli')->result();
        $data['getPoli'] = $rowPoli;

        $rowPasien = $this->db->get('pasien')->result();
        $data['getPasien'] = $rowPasien;

        // Get the last queue number for each poli
        $lastQueueNumbers = [];
        foreach ($rowPoli as $poli) {
            $this->db->select('no_antrian_poli');
            $this->db->from('antrian_poli');
            $this->db->where('id_poli', $poli->id_poli);
            $this->db->order_by('no_antrian_poli', 'DESC');
            $this->db->limit(1);
            $lastQueueNumber = $this->db->get()->row();
            $lastQueueNumbers[$poli->id_poli] = $lastQueueNumber ? $lastQueueNumber->no_antrian_poli : 'No entries';
        }
        $data['lastQueueNumbers'] = $lastQueueNumbers;

        $data['page'] = 'v_antrian_poli';
        $data['output'] = $this->crud->render();
        $this->load->view('admin/' . $this->session->userdata('theme') . '/v_index', $data);
    }

    public function getNoAntrian()
    {
        $id_poli = $this->input->post('id_poli');
        $tanggal = date("Y-m-d");

        $this->db->limit(1);
        $this->db->order_by('no_antrian_poli', 'DESC');
        $this->db->where('id_poli', $id_poli);
        $this->db->where('tgl_antrian_poli', $tanggal);
        $antrian = $this->db->get('antrian_poli')->row();

        $this->db->where('id_poli', $id_poli);
        $kategori_poli = $this->db->get('kategori_poli')->row();

        if ($antrian) {
            $no = $antrian->no_antrian_poli + 1;
        } else {
            $no = 1;
        }

        $kode = $kategori_poli->kode_poli;
        $maks = $kategori_poli->jumlah_maksimal;
        $noAntrian = $kode . $no;

        $hasil = array("no_hasil" => $noAntrian, "no" => $no, "maks" => $maks);
        echo json_encode($hasil);
    }

    public function save()
    {
        $id_poli = $this->input->post('id_poli');
        $no_antrian_poli = $this->input->post('no_antrian_poli');
        $id_pasien = $this->input->post('id_pasien');
        $tanggal = date("Y-m-d");

        $this->db->set('id_poli', $id_poli);
        $this->db->set('no_antrian_poli', $no_antrian_poli);
        $this->db->set('id_pasien', $id_pasien);
        $this->db->set('tgl_antrian_poli', $tanggal);
        $this->db->set('status', 'approved');
        $this->db->insert('antrian_poli');

        redirect(base_url('admin/Antrian_poli'));
    }
}
