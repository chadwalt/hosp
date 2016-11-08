<?php

/*
 * This model will control the operations of the admin user.
 */

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /* Get all the departments in the database.
     * ***************************************** */

    public function get_departments_db($page, $rows) {
        $offset = ($page - 1) * $rows;

        $this->db->limit($offset, $rows);
        $query = $this->db->get('department');

        return $query->result();
    }

    /* Save the departments to the database.
     * ************************************** */

    public function save_department_db($depart_array) {
        $this->db->insert('department', $depart_array);
    }

    /* Update the department in the database
     * ***************************************** */

    public function update_department_db($depart_array, $id) {
        $this->db->where('department_id', $id);
        $this->db->update('department', $depart_array);
    }

    /* Delete the department from the database
     * ****************************************** */

    public function delete_department_db($id) {
        $this->db->where('department_id', $id);
        $query = $this->db->delete('department');

        if ($query) {
            return array('success' => TRUE);
        } else {
            return array('success' => FALSE);
        }
    }

    /* Search through the database to get the specified department.
     * ************************************************************** */

    function search_department_db($search_item, $page, $rows) {
        $offset = ($page - 1) * $rows;

        if (!empty($search_item)) {
            $query = $this->db->query("SELECT * FROM department  WHERE (name LIKE '%$search_item%') OR (description LIKE '%$search_item%') LIMIT $offset, $rows");

            if ($query) {
                return $query->result_array();
            } else {
                return FALSE;
            }
        } else {
            return $this->get_departments_db($page, $rows);
        }
    }
    
    

}
