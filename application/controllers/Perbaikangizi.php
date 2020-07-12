<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Perbaikangizi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_perbaikan_gizi_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','perbaikangizi/tbl_perbaikan_gizi_list');
    } 
    
    function anakauto() {
       autocomplate_json('tbl_pasien', 'nama_pasien');

        }

    function tindakanauto() {
       autocomplate_json('tbl_tindakan', 'nama_tindakan');

        }

    function obatauto() {
       autocomplate_json('tbl_obat', 'nama_obat');

        }
    
    function autofill(){

    $nama_obat = $_GET['nama_obat'];

    $this->db->where('nama_obat',$nama_obat);

    $obat= $this->db->get('tbl_obat')->row_array();
    $data = array(
        'satuan' => $obat['satuan'],
        );

    echo json_encode($data);
   }


    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_perbaikan_gizi_model->json();
    }

     function cetak(){

    $no_rawat = substr($this->uri->uri_string(3), 27);
     
      $sql_data_resep = "SELECT * FROM tbl_perbaikan_gizi ";

    $sql_rekamedis    = "SELECT tr.*,pd.no_rawat,pd.tanggal_daftar 
                        FROM tbl_riwayat_tindakan as tr, tbl_pendaftaran as pd
                        WHERE pd.no_rawat and tr.no_rawat='$no_rawat'";

        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', array(360,360));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.png', 50, 5, 30);
        //$pdf->Image('', )
        // mencetak string 
        $pdf->Cell(45, 7, '', 0, 0, 'C');
        $pdf->Cell(230, 7, 'PUSKESMAS NUSAMANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 7, '', 0, 0, 'C');
        $pdf->Cell(270, 7, 'Jl. Kamal Raya No.18, RT.6/RW.3, Cengkareng Barat, Kecamatan Cengkareng, Kota Jakarta Barat', 0, 1, 'C');
        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Telepon : (1234) 4218872. E-mail: puskesnuri@gmail.com', 0, 1, 'C');
        $pdf->Line(10,35, 370-20, 35);
        $pdf->Line(10,35.5, 370-20, 35.5);
        
        $pdf->Cell(30, 7, '', 0, 1);

        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Laporan Data Perbaikan Gizi', 0, 1, 'C');




        //tabel hasil rekam medik
        $pdf->Cell(30,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'Nama Anak  ', 1, 0, 'C');
        $pdf->Cell(65, 7, 'Nama Tindakan  ', 1, 0, 'C');
        $pdf->Cell(55, 7, 'Nama Obat  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Jumlah  ', 1, 0, 'C');
        $pdf->Cell(47, 7, 'Satuan  ', 1, 0, 'C');
        $pdf->Cell(55, 7, 'Tanggal  ', 1, 1, 'C');

        



        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(30,7, '',0,0,'C');
        $pdf->Cell(40, 7, $r->nama_anak, 1, 0, 'C');
        $pdf->Cell(65, 7, $r->nama_tindakan, 1, 0, 'C');
        $pdf->Cell(55, 7, $r->nama_obat, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->jumlah, 1, 0, 'C');
        $pdf->Cell(47, 7, $r->satuan, 1, 0, 'C');
        $pdf->Cell(55, 7, $r->tanggal, 1, 1, 'C');
        
        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(155, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }


    public function read($id) 
    {
        $row = $this->Tbl_perbaikan_gizi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_gizi' => $row->id_gizi,
		'nama_anak' => $row->nama_anak,
		'nama_tindakan' => $row->nama_tindakan,
		'nama_obat' => $row->nama_obat,
		'jumlah' => $row->jumlah,
		'satuan' => $row->satuan,
		'tanggal' => $row->tanggal,
	    );
            $this->template->load('template','perbaikangizi/tbl_perbaikan_gizi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('perbaikangizi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('perbaikangizi/create_action'),
	    'id_gizi' => set_value('id_gizi'),
	    'nama_anak' => set_value('nama_anak'),
	    'nama_tindakan' => set_value('nama_tindakan'),
	    'nama_obat' => set_value('nama_obat'),
	    'jumlah' => set_value('jumlah'),
	    'satuan' => set_value('satuan'),
	    'tanggal' => set_value('tanggal'),
	);
        $this->template->load('template','perbaikangizi/tbl_perbaikan_gizi_form', $data);
    }
    
    public function create_action() 
    {

        $tanggal = $this->input->post('tanggal');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_anak' => $this->input->post('nama_anak',TRUE),
		'nama_tindakan' => $this->input->post('nama_tindakan',TRUE),
		'nama_obat' => $this->input->post('nama_obat',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'tanggal' => date('d-m-Y', strtotime($tanggal)),
	    );

            $this->Tbl_perbaikan_gizi_model->insert($data);
           $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');  
            redirect(site_url('perbaikangizi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_perbaikan_gizi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('perbaikangizi/update_action'),
		'id_gizi' => set_value('id_gizi', $row->id_gizi),
		'nama_anak' => set_value('nama_anak', $row->nama_anak),
		'nama_tindakan' => set_value('nama_tindakan', $row->nama_tindakan),
		'nama_obat' => set_value('nama_obat', $row->nama_obat),
		'jumlah' => set_value('jumlah', $row->jumlah),
		'satuan' => set_value('satuan', $row->satuan),
		'tanggal' => set_value('tanggal', $row->tanggal),
	    );
            $this->template->load('template','perbaikangizi/tbl_perbaikan_gizi_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('perbaikangizi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        $tgl = $this->input->post('tanggal',TRUE);


        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_gizi', TRUE));
        } else {
            $data = array(
		'nama_anak' => $this->input->post('nama_anak',TRUE),
		'nama_tindakan' => $this->input->post('nama_tindakan',TRUE),
		'nama_obat' => $this->input->post('nama_obat',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'tanggal' => date('d-m-Y', strtotime($tgl)),
	    );

            $this->Tbl_perbaikan_gizi_model->update($this->input->post('id_gizi', TRUE), $data);
             $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');  
            redirect(site_url('perbaikangizi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_perbaikan_gizi_model->get_by_id($id);

        if ($row) {
            $this->Tbl_perbaikan_gizi_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');              
            redirect(site_url('perbaikangizi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('perbaikangizi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_anak', 'nama anak', 'trim|required');
	$this->form_validation->set_rules('nama_tindakan', 'nama tindakan', 'trim|required');
	$this->form_validation->set_rules('nama_obat', 'nama obat', 'trim|required');
	$this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required');
	$this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');


	$this->form_validation->set_rules('id_gizi', 'id_gizi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Perbaikangizi.php */
/* Location: ./application/controllers/Perbaikangizi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-07-03 18:26:41 */
/* http://harviacode.com */