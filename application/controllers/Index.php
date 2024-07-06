<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Index extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		// $this->load->library('fpdf');
	}
	public function getPasienLama()
	{
		$id_pasien = $this->session->userdata('id_pasien');
		$data = $this->Pasien_model->getPasienById($id_pasien);
		echo json_encode($data);
	}


	public function index()
	{
		$nowDate = date('Y-m-d');

		$this->db->limit('1');
		$this->db->where('tgl_antrian', $nowDate);
		$this->db->order_by('no_antrian', 'DESC');
		$antrian = $this->db->get('antrian')->row();
		if ($antrian) {
			$data['no_antrian'] = $antrian->no_antrian;
		} else {
			$data['no_antrian'] = 0;
		}

		$id_pasienNew = $this->session->userdata('id_pasienNew');
		$id_pasien = $this->session->userdata('id_pasien');
		$id_to_use = !empty($id_pasienNew) ? $id_pasienNew : $id_pasien;

		if (!empty($id_to_use)) {
			$this->db->limit(1);
			$this->db->order_by('id_antrian_poli', 'DESC');
			$this->db->where('id_pasien', $id_to_use);
			$this->db->where('tgl_antrian_poli', $nowDate);
			$this->db->join('kategori_poli', 'kategori_poli.id_poli=antrian_poli.id_poli');
			$rowdata = $this->db->get('antrian_poli')->row();
			if ($rowdata) {
				$data['antrian_pasien'] = preg_replace('/[^0-9]/', '', $rowdata->no_antrian_poli); // Extract numeric part
				$data['nama_poli'] = $rowdata->nama_poli;
				$data['id_antrian_poli'] = $rowdata->id_antrian_poli;
				$data['status_antrian'] = 'approved'; // Add status to data
			} else {
				$data['antrian_pasien'] = '-';
				$data['nama_poli'] = '-';
				$data['id_antrian_poli'] = "";
				$data['status_antrian'] = ''; // Default status if no antrian found
			}

			$rowPoli = $this->db->get('kategori_poli')->result();
			$data['getPoli'] = $rowPoli;

			// Mapping ID Poli to Poli Names
			$poli_names = [
				1 => 'poli_umum',
				2 => 'poli_gigi',
				3 => 'poli_anak',
				4 => 'poli_tb',
				5 => 'poli_konseling',
				6 => 'poli_kia',
				7 => 'poli_gizi'
			];

			$getPoli = $this->db->get('kategori_poli')->result();
			foreach ($getPoli as $key) {
				$this->db->limit('1');
				$this->db->where('id_poli', $key->id_poli);
				$this->db->where('tgl_antrian_poli', $nowDate);
				$this->db->order_by('no_antrian_poli', 'DESC');
				$antrianpoli = $this->db->get('antrian_poli')->row();

				if (isset($poli_names[$key->id_poli])) {
					$data[$poli_names[$key->id_poli]] = $antrianpoli ? preg_replace('/[^0-9]/', '', $antrianpoli->no_antrian_poli) : 0; // Extract numeric part
				}
			}
		} else {
			$data['antrian_pasien'] = '-';
			$data['nama_poli'] = '-';
			$data['id_antrian_poli'] = "";
			$data['status_antrian'] = '';
			$data['getPoli'] = $this->db->get('kategori_poli')->result();
			$poli_names = [
				1 => 'poli_umum',
				2 => 'poli_gigi',
				3 => 'poli_anak',
				4 => 'poli_tb',
				5 => 'poli_konseling',
				6 => 'poli_kia',
				7 => 'poli_gizi'
			];
			foreach ($poli_names as $key => $poli_name) {
				$data[$poli_name] = 0;
			}
		}
		$this->load->view('user/home', $data);
	}



	public function regis()
	{

		$this->load->view('user/registrasi');
	}

	public function registrasi()
	{
		// $no_identitas = $this->input->post('no_identitas');
		// $nama = $this->input->post('nama');
		// $jenis_kelamin = $this->input->post('jenis_kelamin');
		// $tgl_lahir = $this->input->post('tgl_lahir');
		// $alamat = $this->input->post('alamat');
		$no_telp = $this->input->post('no_telp');
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));

		// Tambahkan input untuk pengguna BPJS dan nomor BPJS
		$pengguna_bpjs = $this->input->post('pengguna_bpjs');
		$no_bpjs = $pengguna_bpjs == 'Ya' ? $this->input->post('nomor_bpjs') : null;

		// $this->db->set('no_identitas', $no_identitas);
		// $this->db->set('nama', $nama);
		// $this->db->set('jenis_kelamin', $jenis_kelamin);
		// $this->db->set('tgl_lahir', $tgl_lahir);
		// $this->db->set('alamat', $alamat);
		$this->db->set('no_telp', $no_telp);
		$this->db->set('username', $username);
		$this->db->set('password', $password);
		// $this->db->set('pengguna_bpjs', $pengguna_bpjs);
		// $this->db->set('no_bpjs', $no_bpjs);
		$this->db->set('jenis_pendaftaran', 'Online');

		$this->db->insert('pasien');

		$this->session->set_flashdata("notif", true);
		$this->session->set_flashdata("pesan", 'Registrasi Berhasil');
		$this->session->set_flashdata("type", 'success');

		redirect(base_url());
	}


	// public function new_registration()
	// {
	// 	$this->load->library('session');
	// 	$this->load->database();

	// 	$id_pasien = $this->session->userdata('id_pasien');
	// 	$query_pasien = $this->db->query("SELECT * FROM pasien WHERE id_pasien = '$id_pasien'");
	// 	$data_pasien = $query_pasien->row();

	// 	// Ambil data baru dari form modal
	// 	$new_username = $this->input->post('new_username');
	// 	$new_password = md5($this->input->post('new_password'));
	// 	$new_no_hp = $this->input->post('new_no_hp');

	// 	// Buat array data baru
	// 	$new_data = array(
	// 		'username' => $new_username,
	// 		'password' => $new_password,
	// 		'no_telp' => $new_no_hp,
	// 		'no_identitas' => $data_pasien->no_identitas,
	// 		'nama' => $data_pasien->nama,
	// 		'jenis_kelamin' => $data_pasien->jenis_kelamin,
	// 		'tgl_lahir' => $data_pasien->tgl_lahir,
	// 		'alamat' => $data_pasien->alamat,
	// 		'pengguna_bpjs' => $data_pasien->pengguna_bpjs,
	// 		'no_bpjs' => $data_pasien->no_bpjs,
	// 		'jenis_pendaftaran' => 'Online'
	// 	);

	// 	// Simpan data baru ke database
	// 	$this->db->insert('pasien', $new_data);

	// 	// Redirect atau tampilkan pesan sukses
	// 	$this->session->set_flashdata("notif", true);
	// 	$this->session->set_flashdata("pesan", 'Registrasi baru berhasil!');
	// 	$this->session->set_flashdata("type", 'success');

	// 	redirect(base_url());
	// }
	public function cariPasienByNIK()
	{
		$nik = $this->input->post('nik');

		$this->db->select('*');
		$this->db->from('pasien');
		$this->db->where('no_identitas', $nik);
		$data_pasien = $this->db->get()->row();

		if ($data_pasien) {
			$id_pasien = $data_pasien->id_pasien;

			$this->db->select('k.nama_poli');
			$this->db->from('antrian_poli ap');
			$this->db->join('kategori_poli k', 'ap.id_poli = k.id_poli');
			$this->db->where('ap.id_pasien', $id_pasien);
			$data_poli = $this->db->get()->result();

			$response = [
				'data_pasien' => $data_pasien,
				'data_poli' => $data_poli
			];
		} else {
			$response = [
				'data_pasien' => null,
				'data_poli' => []
			];
		}

		echo json_encode($response);
	}


	public function new_registration()
	{
		$this->load->library('session');
		$this->load->database();

		// Get the current patient ID from session
		$id_pasien = $this->session->userdata('id_pasien');
		$query_pasien = $this->db->query("SELECT * FROM pasien WHERE id_pasien = '$id_pasien'");
		$data_pasien = $query_pasien->row();

		// Get new data from the form
		$new_no_identitas = $this->input->post('no_identitas');
		$new_nama = $this->input->post('nama');
		$new_jenis_kelamin = $this->input->post('jenis_kelamin');
		$new_tgl_lahir = $this->input->post('tgl_lahir');
		$new_alamat = $this->input->post('alamat');
		$new_pengguna_bpjs = $this->input->post('pengguna_bpjs');
		$new_no_bpjs = $this->input->post('nomor_bpjs');

		// Check if necessary fields are null in existing data
		if (
			is_null($data_pasien->no_identitas) || is_null($data_pasien->nama) ||
			is_null($data_pasien->jenis_kelamin) || is_null($data_pasien->tgl_lahir) ||
			is_null($data_pasien->alamat) || is_null($data_pasien->pengguna_bpjs) ||
			is_null($data_pasien->no_bpjs)
		) {
			// Update existing data except username, password, and no_telp
			$update_data = array(
				'no_identitas' => $new_no_identitas,
				'nama' => $new_nama,
				'jenis_kelamin' => $new_jenis_kelamin,
				'tgl_lahir' => $new_tgl_lahir,
				'alamat' => $new_alamat,
				'pengguna_bpjs' => $new_pengguna_bpjs,
				'no_bpjs' => $new_no_bpjs,
				'jenis_pendaftaran' => 'Online'
			);

			// Update data in the database
			$this->db->where('id_pasien', $id_pasien);
			$this->db->update('pasien', $update_data);
		} else {
			// Insert new data
			$username = $this->session->userdata('username');
			$password = $this->session->userdata('password');
			$no_telp = $this->session->userdata('no_telp');

			// Ensure username, password, and no_telp are not null
			if ($username === null) {
				$username = ''; // or handle appropriately
			}
			if ($password === null) {
				$password = ''; // or handle appropriately
			}
			if ($no_telp === null) {
				$no_telp = ''; // or handle appropriately
			}

			$new_data = array(
				'no_identitas' => $new_no_identitas,
				'nama' => $new_nama,
				'jenis_kelamin' => $new_jenis_kelamin,
				'tgl_lahir' => $new_tgl_lahir,
				'alamat' => $new_alamat,
				'pengguna_bpjs' => $new_pengguna_bpjs,
				'no_bpjs' => $new_no_bpjs,
				'jenis_pendaftaran' => 'Online',
				'username' => $username,
				'password' => $password,
				'no_telp' => $no_telp
			);

			// Insert new data into the database
			$this->db->insert('pasien', $new_data);

			// Get the ID of the newly inserted patient
			$new_id_pasien = $this->db->insert_id();

			// Set the new patient ID in session
			$this->session->set_userdata('id_pasienNew', $new_id_pasien);
		}

		// Redirect or display success message
		$this->session->set_flashdata("notif", true);
		$this->session->set_flashdata("pesan", 'Registrasi baru berhasil!');
		$this->session->set_flashdata("type", 'success');
		redirect(base_url());
	}


	// public function new_registration()
	// {
	// 	$this->load->library('session');
	// 	$this->load->database();

	// 	$id_pasien = $this->session->userdata('id_pasien');
	// 	$query_pasien = $this->db->query("SELECT * FROM pasien WHERE id_pasien = '$id_pasien'");
	// 	$data_pasien = $query_pasien->row();

	// 	// Get new data from the form
	// 	$new_no_identitas = $this->input->post('no_identitas');
	// 	$new_nama = $this->input->post('nama');
	// 	$new_jenis_kelamin = $this->input->post('jenis_kelamin');
	// 	$new_tgl_lahir = $this->input->post('tgl_lahir');
	// 	$new_alamat = $this->input->post('alamat');
	// 	$new_pengguna_bpjs = $this->input->post('pengguna_bpjs');
	// 	$new_no_bpjs = $this->input->post('nomor_bpjs');

	// 	// Check if all fields are null
	// 	if (
	// 		is_null($data_pasien->no_identitas) && is_null($data_pasien->nama) &&
	// 		is_null($data_pasien->jenis_kelamin) && is_null($data_pasien->tgl_lahir) &&
	// 		is_null($data_pasien->alamat) && is_null($data_pasien->pengguna_bpjs) &&
	// 		is_null($data_pasien->no_bpjs)
	// 	) {

	// 		// Insert new data
	// 		$new_data = array(
	// 			'no_identitas' => $new_no_identitas,
	// 			'nama' => $new_nama,
	// 			'jenis_kelamin' => $new_jenis_kelamin,
	// 			'tgl_lahir' => $new_tgl_lahir,
	// 			'alamat' => $new_alamat,
	// 			'pengguna_bpjs' => $new_pengguna_bpjs,
	// 			'no_bpjs' => $new_no_bpjs,
	// 			'jenis_pendaftaran' => 'Online',
	// 			// Add username, password, and no_telp from the session
	// 			'username' => $this->session->userdata('username'),
	// 			'password' => $this->session->userdata('password'),
	// 			'no_telp' => $this->session->userdata('no_telp')
	// 		);

	// 		// Insert new data into the database
	// 		$this->db->insert('pasien', $new_data);
	// 	} else {
	// 		// Update existing data except username, password, and no_telp
	// 		$update_data = array(
	// 			'no_identitas' => $new_no_identitas,
	// 			'nama' => $new_nama,
	// 			'jenis_kelamin' => $new_jenis_kelamin,
	// 			'tgl_lahir' => $new_tgl_lahir,
	// 			'alamat' => $new_alamat,
	// 			'pengguna_bpjs' => $new_pengguna_bpjs,
	// 			'no_bpjs' => $new_no_bpjs,
	// 			'jenis_pendaftaran' => 'Online'
	// 		);

	// 		// Update data in the database
	// 		$this->db->where('id_pasien', $id_pasien);
	// 		$this->db->update('pasien', $update_data);
	// 	}

	// 	// Redirect or display success message
	// 	$this->session->set_flashdata("notif", true);
	// 	$this->session->set_flashdata("pesan", 'Registrasi baru berhasil!');
	// 	$this->session->set_flashdata("type", 'success');

	// 	redirect(base_url());
	// }


	public function proses_login()
	{
		print_r($_POST);
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));

		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$getpasien = $this->db->get('pasien')->row();

		if ($getpasien) {
			$this->session->set_userdata('id_pasien', $getpasien->id_pasien);
			$this->session->set_userdata('nama', $getpasien->nama);

			$this->session->set_flashdata("notif", true);
			$this->session->set_flashdata("pesan", 'Login Berhasil');
			$this->session->set_flashdata("type", 'success');
			redirect(base_url());
		} else {
			$this->session->set_flashdata("notif", true);
			$this->session->set_flashdata("pesan", 'Username atau Password Salah');
			$this->session->set_flashdata("type", 'warning');
			redirect(base_url());
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
	// public function getNoAntrian()
	// {
	// 	$id_poli = $this->input->post('id_poli');
	// 	$tanggal = date("Y-m-d");

	// 	$this->db->where('antrian_poli.id_poli', $id_poli);
	// 	$this->db->where('antrian_poli.tgl_antrian_poli', $tanggal);
	// 	$sql = $this->db->get('antrian_poli');
	// 	$getPoli = $sql->num_rows(); // Check number of rows

	// 	if ($getPoli == 0) { // If no one has registered for the day
	// 		$this->db->where('id_poli', $id_poli);
	// 		$sql2 = $this->db->get('kategori_poli');
	// 		$rowPoli = $sql2->row();
	// 		$no = 1;
	// 		$kode = $rowPoli->kode_poli;
	// 		$noAntrian = $kode . $no;
	// 		$maks = $rowPoli->jumlah_maksimal;
	// 	} else {
	// 		// If there is data for the day
	// 		$this->db->limit(1);
	// 		$this->db->order_by('no_antrian_poli', "DESC");
	// 		$this->db->where('antrian_poli.id_poli', $id_poli);
	// 		$this->db->where('antrian_poli.tgl_antrian_poli', $tanggal);
	// 		$sql = $this->db->get('antrian_poli');
	// 		$rowNo = $sql->row();

	// 		$this->db->where('id_poli', $id_poli);
	// 		$sql2 = $this->db->get('kategori_poli');
	// 		$rowPoli = $sql2->row();
	// 		$kode = $rowPoli->kode_poli;
	// 		$no = intval($rowNo->no_antrian_poli) + 1; // Ensure $no_antrian_poli is numeric
	// 		$maks = $rowPoli->jumlah_maksimal;

	// 		$noAntrian = $kode . $no;
	// 	}

	// 	$hasil = array("no_hasil" => $noAntrian, "no" => $no, "maks" => $maks);
	// 	echo json_encode($hasil);
	// }


	public function getNoAntrian()
	{
		$id_poli = $this->input->post('id_poli');
		$tanggal = date("Y-m-d");

		// Check if there are any registrations for the current day
		$this->db->where('antrian_poli.id_poli', $id_poli);
		$this->db->where('antrian_poli.tgl_antrian_poli', $tanggal);
		$sql = $this->db->get('antrian_poli');
		$getPoli = $sql->num_rows(); // Check number of rows

		if ($getPoli == 0) { // If no one has registered for the day
			$this->db->where('id_poli', $id_poli);
			$sql2 = $this->db->get('kategori_poli');
			$rowPoli = $sql2->row();
			$no = 1; // Start from 1
			$kode = $rowPoli->kode_poli;
			$noAntrian = $kode . $no;
			$maks = $rowPoli->jumlah_maksimal;
		} else {
			// If there is data for the day
			$this->db->limit(1);
			$this->db->order_by('no_antrian_poli', "DESC");
			$this->db->where('antrian_poli.id_poli', $id_poli);
			$this->db->where('antrian_poli.tgl_antrian_poli', $tanggal);
			$sql = $this->db->get('antrian_poli');
			$rowNo = $sql->row();

			$this->db->where('id_poli', $id_poli);
			$sql2 = $this->db->get('kategori_poli');
			$rowPoli = $sql2->row();
			$kode = $rowPoli->kode_poli;
			$no = intval($rowNo->no_antrian_poli) + 1; // Ensure $no_antrian_poli is numeric
			$maks = $rowPoli->jumlah_maksimal;

			$noAntrian = $kode . $no;
		}

		$hasil = array("no_hasil" => $noAntrian, "no" => $no, "maks" => $maks);
		echo json_encode($hasil);
	}


	// public function saveAntrian()
	// {
	// 	$id_poli = $this->input->post('id_poli');
	// 	$no_antrian_poli = substr($this->input->post('no_antrian_poli'), 4);
	// 	$id_pasien = $this->session->userdata('id_pasien');
	// 	$tanggal = date("Y-m-d");

	// 	// Setting the status to "pending"
	// 	$status = 'pending';

	// 	$this->db->set('id_poli', $id_poli);
	// 	$this->db->set('no_antrian_poli', $no_antrian_poli);
	// 	$this->db->set('id_pasien', $id_pasien);
	// 	$this->db->set('tgl_antrian_poli', $tanggal);
	// 	$this->db->set('status', $status); // Setting the status to "pending"
	// 	$this->db->insert('antrian_poli');

	// 	$no_antrian = $this->input->post('no_antrian');
	// 	$this->db->set('no_antrian', $no_antrian + 1);
	// 	$this->db->set('tgl_antrian', $tanggal);
	// 	$this->db->insert('antrian');

	// 	redirect(base_url());
	// }

	public function saveAntrian()
	{
		$id_poli = $this->input->post('id_poli');
		$no_antrian_poli = $this->input->post('no_antrian_poli');
		$numeric_no_antrian_poli = preg_replace('/[^0-9]/', '', $no_antrian_poli); // Extract numeric part
		$id_pasien = $this->session->userdata('id_pasienNew');
		$tanggal = date("Y-m-d");

		// Setting the status to "pending"
		$status = 'pending';

		// Insert into antrian_poli
		$this->db->set('id_poli', $id_poli);
		$this->db->set('no_antrian_poli', $numeric_no_antrian_poli);
		$this->db->set('id_pasien', $id_pasien);
		$this->db->set('tgl_antrian_poli', $tanggal);
		$this->db->set('status', $status); // Setting the status to "pending"
		$this->db->insert('antrian_poli');

		// Update no_antrian in antrian table
		$no_antrian = $this->input->post('no_antrian');
		$this->db->set('no_antrian', $no_antrian + 1);
		$this->db->set('tgl_antrian', $tanggal);
		$this->db->insert('antrian');

		redirect(base_url());
	}

	public function cetak($id_antrian_poli = NULL)
	{
		// Ambil data antrian dengan join kategori_poli
		$this->db->select('antrian_poli.*, kategori_poli.nama_poli');
		$this->db->where('id_antrian_poli', $id_antrian_poli);
		$this->db->join('kategori_poli', 'kategori_poli.id_poli = antrian_poli.id_poli');
		$data['row'] = $this->db->get('antrian_poli')->row();

		if (!empty($data['row'])) {
			// Ambil daftar dokter berdasarkan id_poli dari tabel dokter
			$this->db->select('nama_dokter');
			$this->db->where('id_poli', $data['row']->id_poli);
			$dokters = $this->db->get('dokter')->result();

			// Pilih nama dokter secara acak
			if (!empty($dokters)) {
				$random_dokter = $dokters[array_rand($dokters)];
				$data['nama_dokter'] = $random_dokter->nama_dokter;
			} else {
				$data['nama_dokter'] = 'Nama Dokter Tidak Tersedia';
			}

			// Ambil data pasien berdasarkan id_pasien dari tabel antrian_poli
			$this->db->select('nama, no_identitas, jenis_kelamin, tgl_lahir, alamat, no_telp');
			$this->db->where('id_pasien', $data['row']->id_pasien);
			$data_pasien = $this->db->get('pasien')->row();

			// Simpan data pasien ke dalam data untuk ditampilkan di view
			$data['nama_pasien'] = $data_pasien->nama;
			$data['no_identitas'] = $data_pasien->no_identitas;
			$data['jenis_kelamin'] = $data_pasien->jenis_kelamin;
			$data['tgl_lahir'] = $data_pasien->tgl_lahir;
			$data['alamat'] = $data_pasien->alamat;
			$data['no_hp'] = $data_pasien->no_telp;
		} else {
			// Handle jika data antrian tidak ditemukan
			$data['row'] = null;
			$data['nama_dokter'] = 'Nama Dokter Tidak Tersedia';
			$data['nama_pasien'] = 'Nama Pasien Tidak Ditemukan';
			$data['no_identitas'] = 'Nomor Identitas Tidak Ditemukan';
			$data['jenis_kelamin'] = 'Jenis Kelamin Tidak Ditemukan';
			$data['tgl_lahir'] = 'Tanggal Lahir Tidak Ditemukan';
			$data['alamat'] = 'Alamat Tidak Ditemukan';
			$data['no_hp'] = 'Nomor HP Tidak Ditemukan';
		}

		// Load view 'user/cetak' dengan data yang sudah disiapkan
		$this->load->view('user/cetak', $data);
	}




	public function cetak2()
	{
		require(APPPATH . "/libraries/fpdf.php");
		// print_r(dirname(__FILE__) . '/./tcpdf/tcpdf.php'); die();
		try {
			$pdf = new FPDF('l', 'mm', 'A5');
			// Menambah halaman baru
			$pdf->AddPage();
			// Setting jenis font
			$pdf->SetFont('Arial', 'B', 16);
			// Membuat string
			$pdf->Cell(190, 7, 'Daftar Harga Motor Dealer Maju Motor', 0, 1, 'C');
			// $pdf->SetFont('Arial','B',9);
			$pdf->Cell(190, 7, 'Jl. Abece No. 80 Kodamar, jakarta Utara.', 0, 1, 'C');

			// print_r($pdf); die();
			$path = './assets/pdf/' . date('YmdHis') . ".pdf";
			$pdf->Output('F', $path);
			http_response_code(200);
			header('Content-Length: ' . filesize($path));
			header("Content-Type: application/pdf");
			header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
			readfile($path);

			exit;
			// redirect(base_url($path));
			//     		$filename = 'pdf.pdf';
			//     		header('Content-type:application/pdf');
			// header('Content-disposition: inline; filename="'.$filename.'"');
			// header('content-Transfer-Encoding:binary');
			// header('Accept-Ranges:bytes');
			// $pdf->Output('I',$filename);
		} catch (Exception $e) {
			print_r($e->getMessage());
		}
	}
}
