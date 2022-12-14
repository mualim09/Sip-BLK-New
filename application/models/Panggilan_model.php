<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panggilan_model extends CI_Model
{

    public $table = 'panggilan';
    public $id = 'id_panggilan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
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
        $this->db->like('id_panggilan', $q);
	$this->db->or_like('header', $q);
	$this->db->or_like('tanggal', $q);
	$this->db->or_like('waktu_mulai', $q);
	$this->db->or_like('waktu_selesai', $q);
	$this->db->or_like('lokasi', $q);
	$this->db->or_like('jenis_tes', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_panggilan', $q);
	$this->db->or_like('header', $q);
	$this->db->or_like('tanggal', $q);
	$this->db->or_like('waktu_mulai', $q);
	$this->db->or_like('waktu_selesai', $q);
	$this->db->or_like('lokasi', $q);
	$this->db->or_like('jenis_tes', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }


    function update_lowongan($id, $id_lowongan){
        $this->db->set('id_panggilan', $id);
        $this->db->where('id_lowongan', $id_lowongan);
        $this->db->update('lowongan');
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

// ============================================================================================

    function get_id_member(){
        $this->db->select('id_member');
        $id_users = $this->session->userdata('id_users');
        $this->db->where('id_users', $id_users);
        return $this->db->get('member')->row();
    }

    function get_id_lowongan($limit, $start = 0, $q = NULL)
    {
        $id_member_data = $this->get_id_member();
        if ($id_member_data) {
        $id_member = $id_member_data->id_member;
        $this->db->join('lowongan', 'lowongan.id_lowongan = pelamar.id_lowongan', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = lowongan.id_perusahaan', 'left');
        $this->db->where('id_member', $id_member);
        $this->db->where('status', 'Diterima');
        $this->db->order_by($this->id, $this->order);
    $this->db->like('perusahaan.nama_perusahaan', $q);
    $this->db->like('lowongan.judul', $q);
    $this->db->limit($limit, $start);
        return $this->db->get('pelamar')->result();
        }else{
            
        }
    }


// ============================================================================================
}

/* End of file Panggilan_model.php */
/* Location: ./application/models/Panggilan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-11-10 08:21:32 */
/* http://harviacode.com */