<?php
class TransactionModel extends CI_Model {

    public function getUserByPhone($phone) {
        $this->db->where('cust_phone', $phone);
        $query = $this->db->get('transactions'); // Assuming phone numbers are stored in transactions table
        return $query->row(); // Return user if found
    }
}
?>
