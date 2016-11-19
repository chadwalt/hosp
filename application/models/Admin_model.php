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
        $department_id = $this->db->insert_id();

        $depart_array['department_id'] = $department_id;
        return $depart_array;
    }

    /* Update the department in the database
     * ***************************************** */

    public function update_department_db($depart_array, $id) {
        $this->db->where('department_id', $id);
        $this->db->update('department', $depart_array);

        $depart_array['department_id'] = $id;
        return $depart_array;
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

    /* Get all the categories in the database.
     * ***************************************** */

    public function get_med_categories_db($page, $rows) {
        $offset = ($page - 1) * $rows;

        $this->db->limit($offset, $rows);
        $query = $this->db->get('medicine_categorys');

        return $query->result();
    }
    
    
    /* Save the category to the database.
     * ************************************** */

    public function save_category_db($cat_array) {
        $this->db->insert('medicine_categorys', $cat_array);
        $id = $this->db->insert_id();

        $cat_array['id'] = $id;
        return $cat_array;
    }

    /* Update the category in the database
     * ***************************************** */

    public function update_category_db($cat_array, $id) {
        $this->db->where('id', $id);
        $this->db->update('medicine_categorys', $cat_array);

        $cat_array['id'] = $id;
        return $cat_array;
    }

    /* Delete the category from the database
     * ****************************************** */

    public function delete_category_db($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('medicine_categorys');

        if ($query) {
            return array('success' => TRUE);
        } else {
            return array('success' => FALSE);
        }
    }

    /* Search through the database to get the specified category.
     * ************************************************************** */

    function search_category_db($search_item, $page, $rows) {
        $offset = ($page - 1) * $rows;

        if (!empty($search_item)) {
            $query = $this->db->query("SELECT * FROM medicine_categorys  WHERE (name LIKE '%$search_item%') OR (description LIKE '%$search_item%') LIMIT $offset, $rows");

            if ($query) {
                return $query->result_array();
            } else {
                return FALSE;
            }
        } else {
            return $this->get_med_categories_db($page, $rows);
        }
    }
    
    
    /* Get all the suppliers in the database.
     * ***************************************** */

    public function get_med_suppliers_db($page, $rows) {
        $offset = ($page - 1) * $rows;

        $this->db->limit($offset, $rows);
        $query = $this->db->get('medicine_suppliers');

        return $query->result();
    }
    
    
    /* Save the supplier to the database.
     * ************************************** */

    public function save_supplier_db($supp_array) {
        $this->db->insert('medicine_suppliers', $supp_array);
        $id = $this->db->insert_id();

        $supp_array['id'] = $id;
        return $supp_array;
    }

    /* Update the supplier in the database
     * ***************************************** */

    public function update_supplier_db($supp_array, $id) {
        $this->db->where('id', $id);
        $this->db->update('medicine_suppliers', $supp_array);

        $supp_array['id'] = $id;
        return $supp_array;
    }

    /* Delete the supplier from the database
     * ****************************************** */

    public function delete_supplier_db($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('medicine_suppliers');

        if ($query) {
            return array('success' => TRUE);
        } else {
            return array('success' => FALSE);
        }
    }

    /* Search through the database to get the specified category.
     * ************************************************************** */

    function search_supplier_db($search_item, $page, $rows) {
        $offset = ($page - 1) * $rows;

        if (!empty($search_item)) {
            $query = $this->db->query("SELECT * FROM medicine_suppliers  WHERE (name LIKE '%$search_item%')  OR (address LIKE '%$search_item%') OR (email LIKE '%$search_item%') LIMIT $offset, $rows");

            if ($query) {
                return $query->result_array();
            } else {
                return FALSE;
            }
        } else {
            return $this->get_med_suppliers_db($page, $rows);
        }
    }

}
