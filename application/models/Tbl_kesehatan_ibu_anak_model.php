<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_kesehatan_ibu_anak_model extends CI_Model
{

    public $table = 'tbl_kesehatan_ibu_anak';
    public $id = 'id_kia';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_kia,nama_pasien,status_pasien,nama_operasi,biaya,ditangani_oleh,tgl_tindakan');
        $this->datatables->from('tbl_kesehatan_ibu_anak');
        //add this line for join
        //$this->datatables->join('table2', 'tbl_kesehatan_ibu_anak.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('polikia/cetakid/$1'),'<i class="fa fa-print" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
            ".anchor(site_url('polikia/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_kia');
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
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_kia', $q);
	$this->db->or_like('nama_pasien', $q);
    $this->db->or_like('asuransi', $q);
	$this->db->or_like('nama_operasi', $q);
	$this->db->or_like('biaya', $q);
	$this->db->or_like('ditangani_oleh', $q);
	$this->db->or_like('dibayar', $q);
	$this->db->or_like('kembalian', $q);
	$this->db->or_like('tgl_tindakan', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_kia', $q);
	$this->db->or_like('nama_pasien', $q);
	$this->db->or_like('nama_operasi', $q);
    $this->db->or_like('asuransi', $q);
	$this->db->or_like('biaya', $q);
	$this->db->or_like('ditangani_oleh', $q);
	$this->db->or_like('dibayar', $q);
	$this->db->or_like('kembalian', $q);
	$this->db->or_like('tgl_tindakan', $q);
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

