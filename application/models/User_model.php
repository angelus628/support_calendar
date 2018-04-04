<?php

class User_model extends CI_Model {

    public $id;
    public $name;
    public $lastname;
    public $phone;
    public $email;

    public function get_users()
    {
            $query = $this->db->get('support_calendar');
            return $query->result();
    }
}
