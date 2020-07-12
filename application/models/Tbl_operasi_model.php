<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_operasi_model extends CI_Model
{

    public $table = 'tbl_operasi';
    public $id = 'kode_operasi';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('kode_operasi,nama_operasi,biaya,tindakan_oleh');
        $this->datatables->from('tbl_operasi');
        //add this line for join
        //$this->datatables->join('table2', 'tbl_operasi.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('operasi/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('operasi/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kode_operasi');
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
        $this->db->like('kode_operasi', $q);
	$this->db->or_like('nama_operasi', $q);
	$this->db->or_like('biaya', $q);
	$this->db->or_like('tindakan_oleh', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kode_operasi', $q);
	$this->db->or_like('nama_operasi', $q);
	$this->db->or_like('biaya', $q);
	$this->db->or_like('tindakan_oleh', $q);
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

