<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manufacturer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Count only non-deleted manufacturers
    public function countAll()
    {
        $this->db->where('isDeleted', 0);
        return $this->db->count_all_results('manufacturers');
    }

    // Get all non-deleted manufacturers
    public function getAll($orderBy = 'mnf_name', $orderFormat = 'ASC', $start = 0, $limit = '')
    {
        $this->db->where('isDeleted', 0);

        if ($limit) {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by($orderBy, $orderFormat);
        $query = $this->db->get('manufacturers');

        return $query->result() ?: false;
    }


    // Add a new manufacturer
    public function add($data)
    {
        return $this->db->insert('manufacturers', $data) ? $this->db->insert_id() : false;
    }

    // Search manufacturer by name, email, or address-related fields
    public function search($value)
    {
        $this->db->group_start()
            ->like('mnf_name', $value)
            ->or_like('mnf_address', $value)
            ->or_like('town', $value)
            ->or_like('tal', $value)
            ->or_like('dist', $value)
            ->or_like('contact', $value)
            ->or_like('email', $value)
            ->group_end();

        $this->db->where('isDeleted', 0); // Ensures deleted manufacturers are excluded

        $query = $this->db->get('manufacturers');
        return $query->result();
    }



    // Update manufacturer details
    public function edit($id, $data)
    {
        $this->db->where('id', $id)->update('manufacturers', $data);
        return $this->db->affected_rows() > 0;
    }

    // Soft delete a manufacturer
    public function delete($id)
    {
        $this->db->where('id', $id)->set('isDeleted', 1)->update('manufacturers');
        return $this->db->affected_rows() > 0;
    }

    // Get manufacturer details by ID
    public function getById($id)
    {
        $query = $this->db->where('id', $id)->get('manufacturers');
        return $query->row() ?: false;
    }

    // Get active manufacturers
    public function getActiveManufacturers()
    {
        $query = $this->db->where('isActive', 1)->get('manufacturers');
        return $query->result() ?: false;
    }
}
