<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_pegawai_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','pegawai/tbl_pegawai_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_pegawai_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_pegawai_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_pegawai' => $row->id_pegawai,
		'nama_pegawai' => $row->nama_pegawai,
		'jenis_kelamin' => $row->jenis_kelamin,
		'npwp' => $row->npwp,
		'tempat_lahir' => $row->tempat_lahir,
		'tanggal_lahir' => $row->tanggal_lahir,
		'id_jabatan' => $row->id_jabatan,
		'id_bidang' => $row->id_bidang,
	    );
            $this->template->load('template','pegawai/tbl_pegawai_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pegawai'));
        }
    }

    function cetak(){

     
      $sql_data_resep = "SELECT pg.id_pegawai,pg.nama_pegawai,pg.jenis_kelamin,pg.npwp,pg.tempat_lahir,pg.tanggal_lahir,jab.nama_jabatan, bdg.nama_bidang FROM tbl_pegawai as pg, tbl_jabatan as jab, tbl_bidang as bdg WHERE pg.id_jabatan = jab.id_jabatan and pg.id_bidang = bdg.id_bidang";

   
        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', array(380,380));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.png', 20, 10, 50);
        //$pdf->Image('', )
        // mencetak string 
        $pdf->Cell(45, 7, '', 0, 0, 'C');
        $pdf->Cell(260, 7, 'PUSKESMAS NUSAMANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 7, '', 0, 0, 'C');
        $pdf->Cell(275, 7, 'Jl. Kamal Raya No.18, RT.6/RW.3, Cengkareng Barat, Kecamatan Cengkareng, Kota Jakarta Barat', 0, 1, 'C');
        $pdf->Cell(80, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Telepon : (1234) 4218872. E-mail: puskesnuri@gmail.com', 0, 1, 'C');
        $pdf->Line(10,35, 390-20, 35);
        $pdf->Line(10,35.5, 390-20, 35.5);
        
        $pdf->Cell(30, 7, '', 0, 1);

        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Laporan Data Pegawai', 0, 1, 'C');




        //tabel hasil rekam medik
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'Id Pegawai  ', 1, 0, 'C');
        $pdf->Cell(75, 7, 'Nama Pegawai  ', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Jenis Kelamin  ', 1, 0, 'C');
        $pdf->Cell(40, 7, 'NPWP  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Tempat Lahir  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Tanggal Lahir  ', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Jabatan  ', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Bidang  ', 1, 1, 'C');



        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, $r->id_pegawai, 1, 0, 'C');
        $pdf->Cell(75, 7, $r->nama_pegawai, 1, 0, 'C');
        $pdf->Cell(45, 7, $r->jenis_kelamin, 1, 0, 'C');
        $pdf->Cell(40, 7, $r->npwp, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->tempat_lahir, 1, 0, 'C');
        $pdf->Cell(30, 7, date('d-m-Y', strtotime($r->tanggal_lahir)), 1, 0, 'C');
        $pdf->Cell(40, 7, $r->nama_jabatan, 1, 0, 'C');
        $pdf->Cell(50, 7, $r->nama_bidang, 1, 1, 'C');
        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(155, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }


    public function create() 
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('pegawai/create_action'),
	    'id_pegawai' => set_value('id_pegawai'),
	    'nama_pegawai' => set_value('nama_pegawai'),
	    'jenis_kelamin' => set_value('jenis_kelamin'),
	    'npwp' => set_value('npwp'),
	    'tempat_lahir' => set_value('tempat_lahir'),
	    'tanggal_lahir' => set_value('tanggal_lahir'),
	    'id_jabatan' => set_value('id_jabatan'),
	    'id_bidang' => set_value('id_bidang'),
	);
        $this->template->load('template','pegawai/tbl_pegawai_form', $data);
    }
    
    public function create_action() 
    {

        $ttl = $this->input->post('tanggal_lahir',TRUE);

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
        'id_pegawai' => $this->input->post('id_pegawai',TRUE),
		'nama_pegawai' => $this->input->post('nama_pegawai',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'npwp' => $this->input->post('npwp',TRUE),
		'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
        'tanggal_lahir' => date('d-m-Y', strtotime($ttl)),
		'id_jabatan' => $this->input->post('id_jabatan',TRUE),
		'id_bidang' => $this->input->post('id_bidang',TRUE),
	    );

            $this->Tbl_pegawai_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');              
            redirect(site_url('pegawai'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_pegawai_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pegawai/update_action'),
		'id_pegawai' => set_value('id_pegawai', $row->id_pegawai),
		'nama_pegawai' => set_value('nama_pegawai', $row->nama_pegawai),
		'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
		'npwp' => set_value('npwp', $row->npwp),
		'tempat_lahir' => set_value('tempat_lahir', $row->tempat_lahir),
		'tanggal_lahir' => set_value('tanggal_lahir', $row->tanggal_lahir),
		'id_jabatan' => set_value('id_jabatan', $row->id_jabatan),
		'id_bidang' => set_value('id_bidang', $row->id_bidang),
	    );
            $this->template->load('template','pegawai/tbl_pegawai_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pegawai'));
        }
    }
    
    public function update_action() 
    {

        $ttl = $this->input->post('tanggal_lahir',TRUE);

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_pegawai', TRUE));
        } else {

            $data = array(
		'nama_pegawai' => $this->input->post('nama_pegawai',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'npwp' => $this->input->post('npwp',TRUE),
		'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
        'tanggal_lahir' => date('d-m-Y', strtotime($ttl)),
		'id_jabatan' => $this->input->post('id_jabatan',TRUE),
		'id_bidang' => $this->input->post('id_bidang',TRUE),
	    );

            $this->Tbl_pegawai_model->update($this->input->post('id_pegawai', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');              redirect(site_url('pegawai'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_pegawai_model->get_by_id($id);

        if ($row) {
            $this->Tbl_pegawai_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');            redirect(site_url('pegawai'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pegawai'));
        }
    }

    public function _rules() 
    {
    $this->form_validation->set_rules('id_pegawai', 'id pegawai', 'trim|required');
	$this->form_validation->set_rules('nama_pegawai', 'nama pegawai', 'trim|required');
	$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
	$this->form_validation->set_rules('npwp', 'npwp', 'trim|required');
	$this->form_validation->set_rules('tempat_lahir', 'tempat lahir', 'trim|required');
	$this->form_validation->set_rules('tanggal_lahir', 'tanggal lahir', 'trim|required');
	$this->form_validation->set_rules('id_jabatan', 'id jabatan', 'trim|required');
	$this->form_validation->set_rules('id_bidang', 'id bidang', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');

	$this->form_validation->set_rules('nik', 'nik', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_pegawai.xls";
        $judul = "tbl_pegawai";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Pegawai");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Kelamin");
	xlsWriteLabel($tablehead, $kolomhead++, "Npwp");
	xlsWriteLabel($tablehead, $kolomhead++, "Tempat Lahir");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Lahir");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Jabatan");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Bidang");

	foreach ($this->Tbl_pegawai_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_pegawai);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_kelamin);
	    xlsWriteLabel($tablebody, $kolombody++, $data->npwp);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tempat_lahir);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_lahir);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_jabatan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_bidang);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_pegawai.doc");

        $data = array(
            'tbl_pegawai_data' => $this->Tbl_pegawai_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('pegawai/tbl_pegawai_doc',$data);
    }

}

