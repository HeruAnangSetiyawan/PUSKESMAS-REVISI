<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pasien extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_pasien_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/pasien/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/pasien/index/';
            $config['first_url'] = base_url() . 'index.php/pasien/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Tbl_pasien_model->total_rows($q);
        $pasien = $this->Tbl_pasien_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pasien_data' => $pasien,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','pasien/tbl_pasien_list', $data);
    }

    function cetak(){

    $no_rawat = substr($this->uri->uri_string(3), 27);
     
      $sql_data_resep = "SELECT * FROM tbl_pasien";

    $sql_rekamedis    = "SELECT tr.*,pd.no_rawat,pd.tanggal_daftar 
                        FROM tbl_riwayat_tindakan as tr, tbl_pendaftaran as pd
                        WHERE pd.no_rawat and tr.no_rawat='$no_rawat'";

        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', array(410,380));
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
        $pdf->Cell(30, 7, '', 0, 0, 'C');
        $pdf->Cell(300, 7, 'Jl. Kamal Raya No.18, RT.6/RW.3, Cengkareng Barat, Kecamatan Cengkareng, Kota Jakarta Barat', 0, 1, 'C');
        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(220, 7, 'Telepon : (1234) 4218872. E-mail: puskesnuri@gmail.com', 0, 1, 'C');
        $pdf->Line(10,35, 410-20, 35);
        $pdf->Line(10,35.5, 410-20, 35.5);
        
        $pdf->Cell(30, 7, '', 0, 1);

        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(220, 7, 'Laporan Data Pasien', 0, 1, 'C');




        //tabel hasil rekam medik
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'No. Rekam Medis  ', 1, 0, 'C');
        $pdf->Cell(45, 7, 'No. KTP  ', 1, 0, 'C');
        $pdf->Cell(75, 7, 'No. BPJS  ', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Nama Pasien  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Jenis Kelamin  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Tanggal Lahir  ', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Tempat Lahir  ', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Alamat  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Status Pasien  ', 1, 1, 'C');




        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, $r->no_rekamedis, 1, 0, 'C');
        $pdf->Cell(45, 7, $r->no_ktp, 1, 0, 'C');
        $pdf->Cell(75, 7, $r->no_bpjs, 1, 0, 'C');
        $pdf->Cell(40, 7, $r->nama_pasien, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->jenis_kelamin, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->tanggal_lahir, 1, 0, 'C');
        $pdf->Cell(40, 7, $r->tempat_lahir, 1, 0, 'C');
        $pdf->Cell(50, 7, $r->alamat, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->status_pasien, 1, 1, 'C');

        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(155, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }

    function cetakkartu($id){

        
        $sql_pasien = $this->Tbl_pasien_model->get_by_id($id);
        $this->load->library('pdf');
        $pdf = new FPDF();
        $pdf->AddPage('P','A4');

        $tgl=date('Y/m/d');
        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/latar-kartu.jpg',5,5,100,56);
        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/latar-kartu.jpg',106,5,100,56);
        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.jpg',10,9,10,10);
        $pdf->setFont('Arial','B',12);
        $pdf->Cell(90,5,'PUSKESMAS WADAS',0,0,'C');
        $pdf->Cell(10,5,'',0,0,'C');
        $pdf->setFont('Arial','B',10);
        $pdf->Cell(90,5,'KETENTUAN',0,1,'C');
        $pdf->setFont('Arial','B',8);
        $pdf->Cell(90,5,'Jl.Pintu Air, Sindangsari, Wadas No.17',0,0,'C');
        $pdf->Cell(10,5,'',0,0,'C');
        $pdf->setFont('Arial','',7);
        $pdf->Cell(90,5,'- Kartu ini hanya bisa digunakan untuk berobat di puskesmas wadas.',0,1,'L');
        $pdf->SetLineWidth(0.2);
        $pdf->Line(10,20,100,20);
        $pdf->setFont('Arial','B',10);
        $pdf->Cell(90,5,'KARTU BEROBAT',0,0,'C');
        $pdf->Cell(10,5,'',0,0,'C');
        $pdf->setFont('Arial','',7);
        $pdf->Cell(90,5,'- Apabila kartu ini hilang / rusak, maka segera digantikan dengan kartu yang baru',0,1,'L');
        $pdf->SetLineWidth(0.2);
        $pdf->Line(10,25,100,25);
        $pdf->Ln(6);
        
        $pdf->setFont('Arial','',9);
        $pdf->Cell(60, 4, '', 0, 1);
        $pdf->Cell(22,4,'No.RM',0,0,'L');
        $pdf->Cell(36,4,': '.$sql_pasien->no_rekamedis,0,0,'L');
        $pdf->Cell(10,4,'',0,1,'C');
        $pdf->setFont('Arial','',10);
        $pdf->Cell(22,4,'Nama Pasien',0,0,'L');
        $pdf->Cell(36,4,': '.$sql_pasien->nama_pasien,0,1,'L');
        $pdf->Cell(22,4,'Alamat',0,0,'L');
        $pdf->Cell(36,4,': '.$sql_pasien->alamat,0,1,'L');
        $pdf->Ln(2);

        $pdf->Output('cetak-kartu-berobat.pdf','I');

            
        }

    public function read($id) 
    {
        $row = $this->Tbl_pasien_model->get_by_id($id);
        if ($row) {
            $data = array(
		'no_rekamedis' => $row->no_rekamedis,
		'no_ktp' => $row->no_ktp,
		'no_bpjs' => $row->no_bpjs,
		'nama_pasien' => $row->nama_pasien,
		'jenis_kelamin' => $row->jenis_kelamin,
		'tempat_lahir' => $row->tempat_lahir,
		'tanggal_lahir' => $row->tanggal_lahir,
		'alamat' => $row->alamat,
	    );
            $this->template->load('template','pasien/tbl_pasien_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pasien'));
        }
    }

    function noRekammedisOtomatis(){
    $ci = get_instance();
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT max(no_rekamedis) as maxKode FROM tbl_pasien";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxKode'];
    $noUrut = (int) substr($kode, 0, 6);
    $noUrut++;
    $kodeBaru = sprintf("%06s", $noUrut);
    return $kodeBaru;
}

    public function create() 
    {

    $noRekammedisbaru = $this->noRekammedisOtomatis();
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('pasien/create_action'),
	    'no_rekamedis' => set_value('no_rekamedis', $noRekammedisbaru),
	    'no_ktp' => set_value('no_ktp'),
	    'no_bpjs' => set_value('no_bpjs'),
	    'nama_pasien' => set_value('nama_pasien'),
	    'jenis_kelamin' => set_value('jenis_kelamin'),
	    'tempat_lahir' => set_value('tempat_lahir'),
	    'tanggal_lahir' => set_value('tanggal_lahir'),
	    'alamat' => set_value('alamat'),
        'status_pasien' => set_value('status_pasien'),

	);
        $this->template->load('template','pasien/tbl_pasien_form', $data);
    }
    
    public function create_action() 
    {

        $ttl = $this->input->post('tanggal_lahir',TRUE);
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_ktp' => $this->input->post('no_ktp',TRUE),
		'no_bpjs' => $this->input->post('no_bpjs',TRUE),
        'no_rekamedis' => $this->input->post('no_rekamedis', TRUE),
		'nama_pasien' => $this->input->post('nama_pasien',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
		'tanggal_lahir' => date('d-m-Y', strtotime($ttl)),
		'alamat' => $this->input->post('alamat',TRUE),
        'status_pasien' => $this->input->post('status_pasien',TRUE),

	    );

            $this->Tbl_pasien_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');  
            redirect(site_url('pasien'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_pasien_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pasien/update_action'),
		'no_rekamedis' => set_value('no_rekamedis', $row->no_rekamedis),
		'no_ktp' => set_value('no_ktp', $row->no_ktp),
		'no_bpjs' => set_value('no_bpjs', $row->no_bpjs),
		'nama_pasien' => set_value('nama_pasien', $row->nama_pasien),
		'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
		'tempat_lahir' => set_value('tempat_lahir', $row->tempat_lahir),
		'tanggal_lahir' => set_value('tanggal_lahir', $row->tanggal_lahir),
		'alamat' => set_value('alamat', $row->alamat),
        'status_pasien' => set_value('status_pasien', $row->status_pasien),

	    );
            $this->template->load('template','pasien/tbl_pasien_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pasien'));
        }
    }
    
    public function update_action() 
    {
                
        $ttl = $this->input->post('tanggal_lahir',TRUE);

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('no_rekamedis', TRUE));
        } else {
            $data = array(
		'no_ktp' => $this->input->post('no_ktp',TRUE),
		'no_bpjs' => $this->input->post('no_bpjs',TRUE),
		'nama_pasien' => $this->input->post('nama_pasien',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
        'tanggal_lahir' => date('d-m-Y', strtotime($ttl)),
		'alamat' => $this->input->post('alamat',TRUE),
        'status_pasien' => $this->input->post('status_pasien',TRUE),

	    );

            $this->Tbl_pasien_model->update($this->input->post('no_rekamedis', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');              redirect(site_url('pasien'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_pasien_model->get_by_id($id);

        if ($row) {
            $this->Tbl_pasien_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');              redirect(site_url('pasien'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pasien'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_ktp', 'no ktp', 'trim|required');
	$this->form_validation->set_rules('nama_pasien', 'nama pasien', 'trim|required');
	$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
	$this->form_validation->set_rules('tempat_lahir', 'tempat lahir', 'trim|required');
	$this->form_validation->set_rules('tanggal_lahir', 'tanggal lahir', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');


	$this->form_validation->set_rules('no_rekamedis', 'no_rekamedis', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

