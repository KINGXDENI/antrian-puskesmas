<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Super extends CI_Controller
{
    protected $language;
    protected $tema;
    protected $tabel;
    protected $active_id_menu;
    protected $nama_view;
    protected $status;
    protected $field_tambah;
    protected $field_edit;
    protected $field_tampil;
    protected $folder_upload;
    protected $add;
    protected $edit;
    protected $delete;
    protected $crud;

    function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->crud = new grocery_CRUD();
        if (!$this->session->userdata('login_admin')) {
            redirect('admin/login');
        }
    }

    protected function generateData()
    {
        $data['active'] = $this->active_id_menu;
        $data['title'] = 'Admin - ' . $this->nama_view;
        $data['judul_1'] = 'Admin - ' . $this->nama_view;
        $data['judul_2'] = '';
        $data['page'] = 'v_crud';
        $data['menu'] = $this->Menus->generateMenu();
        return $data;
    }

    // protected function generate()
    // {
    //     try {
    //         $this->crud->set_theme($this->tema);
    //         $this->crud->set_table($this->tabel);
    //         $this->crud->set_subject($this->nama_view);
    //         $this->crud->set_language($this->language);
    //         $this->crud->add_fields($this->field_tambah);
    //         $this->crud->edit_fields($this->field_edit);
    //         $this->crud->columns($this->field_tampil);
    //         if ($this->status) {
    //             $this->crud->field_type(
    //                 'status',
    //                 'dropdown',
    //                 array('pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected')
    //             );
    //         }

    //         if (!$this->add)
    //             $this->crud->unset_add();
    //         if (!$this->edit)
    //             $this->crud->unset_edit();

    //         if (!$this->delete)
    //             $this->crud->unset_delete();
    //     } catch (Exception $e) {
    //         show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
    //     }
    // }

    protected function generate()
    {
        try {
            $this->crud->set_theme($this->tema);
            $this->crud->set_table($this->tabel);
            $this->crud->set_subject($this->nama_view);
            $this->crud->set_language($this->language);
            $this->crud->add_fields($this->field_tambah);
            $this->crud->edit_fields($this->field_edit);
            $this->crud->columns($this->field_tampil);

            if ($this->status) {
                $this->crud->field_type(
                    'status',
                    'dropdown',
                    array('pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected')
                );
            }

            if (!$this->add)
                $this->crud->unset_add();
            if (!$this->edit)
                $this->crud->unset_edit();
            if (!$this->delete)
                $this->crud->unset_delete();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
}
