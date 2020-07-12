<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stokobat extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_stok_obat_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/stokobat/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/stokobat/index/';
            $config['first_url'] = base_url() . 'index.php/stokobat/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Tbl_stok_obat_model->total_rows($q);
        $stokobat = $this->Tbl_stok_obat_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'stokobat_data' => $stokobat,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'data_stok' => $this->Tbl_stok_obat_model->get_all()

        );
        $this->template->load('template','stokobat/tbl_stok_obat_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Tbl_stok_obat_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kode_obat' => $row->kode_obat,
		'jumlah' => $row->jumlah,
        'satuan' => $row->satuan,

	    );
            $this->template->load('template','stokobat/tbl_stok_obat_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('stokobat'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('stokobat/create_action'),
	    'kode_obat' => set_value('kode_obat'),
	    'jumlah' => set_value('jumlah'),
        'satuan' => set_value('satuan'),

	);
        $this->template->load('template','stokobat/tbl_stok_obat_form', $data);
    }

    function cetak(){

    $no_rawat = substr($this->uri->uri_string(3), 27);
     
      $sql_data_resep = "SELECT o.nama_obat, so.kode_obat, so.jumlah, so.satuan FROM tbl_obat as o, tbl_stok_obat as so WHERE o.kode_obat = so.kode_obat";

    $sql_rekamedis    = "SELECT tr.*,pd.no_rawat,pd.tanggal_daftar 
                        FROM tbl_riwayat_tindakan as tr, tbl_pendaftaran as pd
                        WHERE pd.no_rawat and tr.no_rawat='$no_rawat'";

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
        $pdf->Cell(230, 7, 'PUSKESMAS NUSAMANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 7, '', 0, 0, 'C');
        $pdf->Cell(270, 7, 'Jl. Kamal Raya No.18, RT.6/RW.3, Cengkareng Barat, Kecamatan Cengkareng, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta', 0, 1, 'C');
        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Telepon : (1234) 567890. E-mail: puskesnuri@gmail.com', 0, 1, 'C');
        $pdf->Line(10,35, 370-20, 35);
        $pdf->Line(10,35.5, 370-20, 35.5);
        
        $pdf->Cell(30, 7, '', 0, 1);

        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Laporan Data Stok Obat', 0, 1, 'C');




        //tabel hasil rekam medik
        $pdf->Cell(70,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'Kode Obat  ', 1, 0, 'C');
        $pdf->Cell(65, 7, 'Nama Obat', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Jumlah ', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Satuan ', 1, 1, 'C');
        


        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(70,7, '',0,0,'C');
        $pdf->Cell(40, 7, $r->kode_obat, 1, 0, 'C');
        $pdf->Cell(65, 7, $r->nama_obat, 1, 0, 'C');
        $pdf->Cell(40, 7, $r->jumlah, 1, 0, 'C');
        $pdf->Cell(45, 7, $r->satuan, 1, 1, 'C');
        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(155, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }

    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'jumlah' => $this->input->post('jumlah',TRUE),
        'satuan' => $this->input->post('satuan',TRUE),

	    );

            $this->Tbl_stok_obat_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('stokobat'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_stok_obat_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('stokobat/update_action'),
		'kode_obat' => set_value('kode_obat', $row->kode_obat),
		'jumlah' => set_value('jumlah', $row->jumlah),
        'satuan' => set_value('satuan', $row->satuan),

	    );
            $this->template->load('template','stokobat/tbl_stok_obat_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('stokobat'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_obat', TRUE));
        } else {
            $data = array(
		'jumlah' => $this->input->post('jumlah',TRUE),
        'satuan' => $this->input->post('satuan',TRUE),

	    );

            $this->Tbl_stok_obat_model->update($this->input->post('kode_obat', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('stokobat'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_stok_obat_model->get_by_id($id);

        if ($row) {
            $this->Tbl_stok_obat_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('stokobat'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('stokobat'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required');
    $this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');


	$this->form_validation->set_rules('kode_obat', 'kode_obat', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_stok_obat.xls";
        $judul = "tbl_stok_obat";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Jumlah");

	foreach ($this->Tbl_stok_obat_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->jumlah);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_stok_obat.doc");

        $data = array(
            'tbl_stok_obat_data' => $this->Tbl_stok_obat_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('stokobat/tbl_stok_obat_doc',$data);
    }

}

