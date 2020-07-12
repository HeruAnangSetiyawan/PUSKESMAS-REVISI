<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Polikia extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_kesehatan_ibu_anak_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','polikia/tbl_kesehatan_ibu_anak_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_kesehatan_ibu_anak_model->json();
    }

    

    function pasienauto() {
       autocomplate_json('tbl_pasien', 'nama_pasien');

        }

    function tindakanauto() {
       autocomplate_json('tbl_operasi', 'nama_operasi');

        }

     function autofill(){

    $nama_operasi = $_GET['nama_operasi'];

    $this->db->where('nama_operasi',$nama_operasi);

    $operasi= $this->db->get('tbl_operasi')->row_array();
    $data = array(
        'biaya' => $operasi['biaya'],
        );

    echo json_encode($data);
   }

   function autoisi(){

    $nama_pasien= $_GET['nama_pasien'];

    $this->db->where('nama_pasien',$nama_pasien);

    $pasien= $this->db->get('tbl_pasien')->row_array();
    $data = array(
        'no_bpjs' => $pasien['no_bpjs'],
        );

    echo json_encode($data);
   }

   function cetak(){

     
      $sql_data_kia= "SELECT * FROM tbl_kesehatan_ibu_anak";

   
        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', array(380,380));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.png', 20, 10, 50);
        //$pdf->Image('', )
        // mencetak string 
        $pdf->Cell(56, 7, '', 0, 0, 'C');
        $pdf->Cell(230, 7, 'PUSKESMAS NUSAMANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(44, 7, '', 0, 0, 'C');
        $pdf->Cell(270, 7, 'Jl. Kamal Raya No.18, RT.6/RW.3, Cengkareng Barat, Kecamatan Cengkareng, Kota Jakarta Barat', 0, 1, 'C');
        $pdf->Cell(79, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Telepon : (1234) 4218872. E-mail: puskesnuri@gmail.com', 0, 1, 'C');
        $pdf->Line(10,35, 385-20, 35);
        $pdf->Line(10,35.5, 385-20, 35.5);
        
        $pdf->Cell(30, 7, '', 0, 1);

        $pdf->Cell(73, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Laporan Data Poli KIA', 0, 1, 'C');


        //tabel hasil rekam medik
        $pdf->Cell(34,7, '',0,0,'C');
        $pdf->Cell(50, 7, 'Nama Pasien  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Status Pasien  ', 1, 0, 'C');
        $pdf->Cell(65, 7, 'Nama Operasi  ', 1, 0, 'C');
        $pdf->Cell(55, 7, 'Biaya  ', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Ditangani Oleh ', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Tgl Tindakan  ', 1, 1, 'C');
        



        $resep = $this->db->query($sql_data_kia)->result();
        foreach ($resep as $r) {
        $pdf->Cell(34,7, '',0,0,'C');
        $pdf->Cell(50, 7, $r->nama_pasien, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->status_pasien, 1, 0, 'C');
        $pdf->Cell(65, 7, $r->nama_operasi, 1, 0, 'C');
        $pdf->Cell(55, 7, $r->biaya, 1, 0, 'C');
        $pdf->Cell(50, 7, $r->ditangani_oleh, 1, 0, 'C');
        $pdf->Cell(40, 7, $r->tgl_tindakan, 1, 1, 'C');
        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);

        $pdf->Cell(135, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }


   function cetakid($id){

        $no_rawat = substr($this->uri->uri_string(3), 25);
        $poperasi = $this->Tbl_kesehatan_ibu_anak_model->get_by_id($id);
     

        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', 'A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.png', 4, 5, 30);
        //$pdf->Image('', a)
        // mencetak string 
        $pdf->Cell(190, 7, 'PUSKESMAS NUSAMANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 7, '          Jl. Kamal Raya No.18, RT.6/RW.3, Cengkareng Barat, Kecamatan Cengkareng, Kota Jakarta Barat', 0, 1, 'C');
        $pdf->Cell(190, 7, 'Telepon : (1234) 4218872. E-mail: puskesnuri@gmail.com', 0, 1, 'C');
        $pdf->Line(5,35, 224-20, 35);
        $pdf->Line(5,35.5, 224-20, 35.5);
        $pdf->Cell(7, 7, '', 0, 1);
        $pdf->Cell(190, 7, 'Laporan Pembayaran Operasi KIA', 0, 1, 'C');


        //data rekam medik
      


        //tabel hasil rekam medik
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'Nama Pasien', 1, 0, 'C');
        $pdf->Cell(28, 7, 'Status Pasien', 1, 0, 'C');
        $pdf->Cell(58, 7, 'Nama Tindakan', 1, 0, 'C');
        $pdf->Cell(23, 7, 'Biaya', 1, 0, 'C');
        $pdf->Cell(23, 7, 'Dibayar', 1, 0, 'C');
        $pdf->Cell(23, 7, 'Kembalian', 1, 1, 'C');



        //1,(1) => (1) digunakan agar textnya bisa dilanjutkan ke bawah 
       
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, $poperasi->nama_pasien, 1, 0, 'C');
        $pdf->Cell(28, 7, $poperasi->status_pasien, 1, 0, 'C');
        $pdf->Cell(58, 7, $poperasi->nama_operasi, 1, 0, 'C');
        $pdf->Cell(23, 7, $poperasi->biaya, 1, 0, 'C');
        $pdf->Cell(23, 7, $poperasi->dibayar, 1, 0, 'C');
        $pdf->Cell(23, 7, $poperasi->kembalian, 1, 1, 'C');

        
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(155, 10, 'Tanggal Tindakan', 0, 0, 'R');
        $pdf->Cell(35, 10, ': '.$poperasi->tgl_tindakan, 0, 0, 'R');


        $pdf->Cell(130, 14, '', 0, 1);
        $pdf->Cell(130, 14, '', 0, 1);
        $pdf->Cell(145, 14, 'Waktu Cetak', 0, 0, 'R');
        $pdf->Cell(43, 14, ': '.date('d-m-Y'), 0, 0, 'R');


        $pdf->Output();

        }
            
    public function read($id) 
    {
        $row = $this->Tbl_kesehatan_ibu_anak_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_kia' => $row->id_kia,
		'nama_pasien' => $row->nama_pasien,
		'nama_operasi' => $row->nama_operasi,
		'biaya' => $row->biaya,
		'ditangani_oleh' => $row->ditangani_oleh,
		'dibayar' => $row->dibayar,
		'kembalian' => $row->kembalian,
		'tgl_tindakan' => $row->tgl_tindakan,
	    );
            $this->template->load('template','polikia/tbl_kesehatan_ibu_anak_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('polikia'));
        }
    }

    public function create() 
    {

      $no_rawat = substr($this->uri->uri_string(3), 16);

      $sql_daftar = "SELECT pd.no_rekamedis, pd.no_rawat,ps.nama_pasien FROM tbl_pendaftaran as pd, tbl_pasien as ps WHERE pd.no_rekamedis = ps.no_rekamedis and pd.no_rawat = '$no_rawat'";

        $data = array(
            'button' => 'Tambah',
            'action' => site_url('polikia/create_action'),
	    'id_kia' => set_value('id_kia'),
	    'nama_pasien' => set_value('nama_pasien'),
        'no_bpjs' => set_value('no_bpjs'),
        'status_pasien' => set_value('status_pasien'),
	    'nama_operasi' => set_value('nama_operasi'),
	    'biaya' => set_value('biaya'),
	    'ditangani_oleh' => set_value('ditangani_oleh'),
	    'dibayar' => set_value('dibayar'),
	    'kembalian' => set_value('kembalian'),
        'keterangan' => set_value('keterangan'),
	    'tgl_tindakan' => set_value('tgl_tindakan'),
	);

        $data['pendaftaran'] = $this->db->query($sql_daftar)->row_array();

        $this->template->load('template','polikia/tbl_kesehatan_ibu_anak_form', $data);
    }
    
    public function create_action() 
    {

        $tgl_tindakan = $this->input->post('tgl_tindakan');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_pasien' => $this->input->post('nama_pasien',TRUE),
        'no_bpjs' => $this->input->post('no_bpjs',TRUE),
        'status_pasien' => $this->input->post('status_pasien',TRUE),
		'nama_operasi' => $this->input->post('nama_operasi',TRUE),
		'biaya' => $this->input->post('biaya',TRUE),
		'ditangani_oleh' => $this->input->post('ditangani_oleh',TRUE),
		'dibayar' => $this->input->post('dibayar',TRUE),
		'kembalian' => $this->input->post('kembalian',TRUE),
                'keterangan' => $this->input->post('keterangan',TRUE),
		'tgl_tindakan' => date('d-m-Y', strtotime($tgl_tindakan)),
	    );

            $this->Tbl_kesehatan_ibu_anak_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');  
            redirect(site_url('polikia'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_kesehatan_ibu_anak_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('polikia/update_action'),
		'id_kia' => set_value('id_kia', $row->id_kia),
		'nama_pasien' => set_value('nama_pasien', $row->nama_pasien),
        'no_bpjs' => set_value('no_bpjs', $row->nama_pasien),
        'status_pasien' => set_value('nama_pasien', $row->status_pasien),
		'nama_operasi' => set_value('nama_operasi', $row->nama_operasi),
		'biaya' => set_value('biaya', $row->biaya),
		'ditangani_oleh' => set_value('ditangani_oleh', $row->ditangani_oleh),
		'dibayar' => set_value('dibayar', $row->dibayar),
		'kembalian' => set_value('kembalian', $row->kembalian),
        'keterangan' => set_value('keterangan', $row->keterangan),
		'tgl_tindakan' => set_value('tgl_tindakan', $row->tgl_tindakan),
	    );
            $this->template->load('template','polikia/tbl_kesehatan_ibu_anak_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('polikia'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        $tg = $this->input->post('tgl_tindakan',TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kia', TRUE));
        } else {
            $data = array(
		'nama_pasien' => $this->input->post('nama_pasien',TRUE),
        'no_bpjs' => $this->input->post('no_bpjs',TRUE),
        'status_pasien' => $this->input->post('status_pasien',TRUE),
		'nama_operasi' => $this->input->post('nama_operasi',TRUE),
		'biaya' => $this->input->post('biaya',TRUE),
		'ditangani_oleh' => $this->input->post('ditangani_oleh',TRUE),
		'dibayar' => $this->input->post('dibayar',TRUE),
		'kembalian' => $this->input->post('kembalian',TRUE),
		'tgl_tindakan' => date('d-m-Y', strtotime($tg)),
	    );

            $this->Tbl_kesehatan_ibu_anak_model->update($this->input->post('id_kia', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');                redirect(site_url('polikia'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_kesehatan_ibu_anak_model->get_by_id($id);

        if ($row) {
            $this->Tbl_kesehatan_ibu_anak_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');            redirect(site_url('polikia'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('polikia'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_pasien', 'nama pasien', 'trim|required');
	$this->form_validation->set_rules('nama_operasi', 'nama tindakan', 'trim|required');
        $this->form_validation->set_rules('status_pasien', 'status_pasien', 'trim|required');
	$this->form_validation->set_rules('biaya', 'biaya', 'trim|required');
	$this->form_validation->set_rules('ditangani_oleh', 'ditangani oleh', 'trim|required');
	$this->form_validation->set_rules('dibayar', 'dibayar', 'trim|required');
	$this->form_validation->set_rules('kembalian', 'kembalian', 'trim|required')
    ;
    $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

	$this->form_validation->set_rules('tgl_tindakan', 'tgl tindakan', 'trim|required');

	$this->form_validation->set_rules('id_kia', 'id_kia', 'trim');
    $this->form_validation->set_message('required', '{field} wajib diisi');

	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_kesehatan_ibu_anak.doc");

        $data = array(
            'tbl_kesehatan_ibu_anak_data' => $this->Tbl_kesehatan_ibu_anak_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('polikia/tbl_kesehatan_ibu_anak_doc',$data);
    }

}

