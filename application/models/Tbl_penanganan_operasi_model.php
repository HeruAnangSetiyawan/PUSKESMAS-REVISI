<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_penanganan_operasi_model extends CI_Model
{

    public $table = 'tbl_penanganan_operasi';
    public $id = 'id_penanganan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_penanganan,nama_pasien,status_pasien,nama_operasi,biaya,ditangani_oleh,tgl_operasi');
        $this->datatables->from('tbl_penanganan_operasi');
        //add this line for join
        //$this->datatables->join('table2', 'tbl_penanganan_operasi.field = table2.field');
        $this->datatables->add_column('action',anchor(site_url('penangananoperasi/cetakid/$1'),'<i class="fa fa-print" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ". anchor(site_url('penangananoperasi/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_penanganan');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
     function get_by_nama_pasien($id)
    {
        $this->db->where('nama_pasien', $id);
        return $this->db->get($this->table)->result();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_penanganan', $q);
	$this->db->or_like('nama_pasien', $q);
    $this->db->or_like('status_pasien', $q);
	$this->db->or_like('nama_operasi', $q);
	$this->db->or_like('biaya', $q);
	$this->db->or_like('ditangani_oleh', $q);
	$this->db->or_like('dibayar', $q);
	$this->db->or_like('kembalian', $q);
	$this->db->or_like('tgl_operasi', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_penanganan', $q);
	$this->db->or_like('nama_pasien', $q);
    $this->db->or_like('status_pasien', $q);
	$this->db->or_like('nama_operasi', $q);
	$this->db->or_like('biaya', $q);
	$this->db->or_like('ditangani_oleh', $q);
	$this->db->or_like('dibayar', $q);
	$this->db->or_like('kembalian', $q);
	$this->db->or_like('tgl_operasi', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

