<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Poli extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_poli_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','poli/tbl_poli_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_poli_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_poli_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_poli' => $row->id_poli,
		'nama_poli' => $row->nama_poli,
		'ruang_poli' => $row->ruang_poli,
	    );
            $this->template->load('template','poli/tbl_poli_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('poli'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('poli/create_action'),
	    'id_poli' => set_value('id_poli'),
	    'nama_poli' => set_value('nama_poli'),
	    'ruang_poli' => set_value('ruang_poli'),
	);
        $this->template->load('template','poli/tbl_poli_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_poli' => $this->input->post('nama_poli',TRUE),
		'ruang_poli' => $this->input->post('ruang_poli',TRUE),
	    );

            $this->Tbl_poli_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');  

            redirect(site_url('poli'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_poli_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('poli/update_action'),
		'id_poli' => set_value('id_poli', $row->id_poli),
		'nama_poli' => set_value('nama_poli', $row->nama_poli),
		'ruang_poli' => set_value('ruang_poli', $row->ruang_poli),
	    );
            $this->template->load('template','poli/tbl_poli_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('poli'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_poli', TRUE));
        } else {
            $data = array(
		'nama_poli' => $this->input->post('nama_poli',TRUE),
		'ruang_poli' => $this->input->post('ruang_poli',TRUE),
	    );

            $this->Tbl_poli_model->update($this->input->post('id_poli', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');  
            redirect(site_url('poli'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_poli_model->get_by_id($id);

        if ($row) {
            $this->Tbl_poli_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');             
            redirect(site_url('poli'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('poli'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_poli', 'nama poli', 'trim|required');
	$this->form_validation->set_rules('ruang_poli', 'ruang poli', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');


	$this->form_validation->set_rules('id_poli', 'id_poli', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_poli.xls";
        $judul = "tbl_poli";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Poli");
	xlsWriteLabel($tablehead, $kolomhead++, "Ruang Poli");

	foreach ($this->Tbl_poli_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_poli);
	    xlsWriteLabel($tablebody, $kolombody++, $data->ruang_poli);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_poli.doc");

        $data = array(
            'tbl_poli_data' => $this->Tbl_poli_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('poli/tbl_poli_doc',$data);
    }

}

