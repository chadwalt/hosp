<?php

/*
 * To file will control the main database operations
 */

class Users_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* Save user information to the database from the calling controller.
     * *********************************************************************** */

    function save_user_db($save_info) {
        // Save the user details to the database.
        $query = $this->db->insert('users', $save_info);

        if ($query) {
            // Create a random alphanumeric password and then encrypt it.
            //$pass = random_string('alnum', 10);
            //$enc_pass = $this->encryption->encrypt($pass);
            $enc_pass = $this->encryption->encrypt($save_info['password']);

            // Return the password to the calling controller.
            //return $enc_pass;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* This will return the users to the calling method.
     * **************************************************** */

    function get_users($page, $rows) {
        $offset = ($page - 1) * $rows;

        $query = $this->db->query("SELECT * FROM users LIMIT $offset, $rows");

        if ($query) {
            return $query->result();
        } else {
            return $this->db->error();
        }
    }

    /*  This function will return user information
     * ************************************************* */

    function get_user_info_db($id) {
        $query = $this->db->query("SELECT login.username, users.* FROM login JOIN users ON login.user_id = users.id AND user_id  ='$id'");
        return $query->row();
    }

    /*  This function will update the user information
     * ************************************************* */

    function update_user() {
        
    }

    /* This function will be used to delete users from the system.
     * ************************************************************ */

    function delete_user_db($id) {
        $sql = "DELETE FROM users WHERE users.id = '$id'";
        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* Search through the database to the user details.
     * *************************************************** */

    function search_user_db($search_item, $page, $rows) {
        $offset = ($page - 1) * $rows;
        if (!empty($search_item)) {
            $query = $this->db->query("SELECT * FROM users  WHERE full_name LIKE '%$search_item%' OR positions LIKE '%$search_item%' OR address LIKE '%$search_item%' LIMIT $offset, $rows");
            
            if ($query) {
                return $query->result_array();
            } else {
                return FALSE;
            }
        } else {
            return $this->get_users($page, $rows);
        }
    }

    /* this will change the users active/deactivated status in the database.
     * ********************************************************************** */

    function active_status_db($status, $user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->update('users', array('active_status' => $status));

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* Retreive all the information about this current user.
     * ***************************************************** */

    public function get_profile($id) {
        $query = $this->db->query("SELECT login.username, users.* FROM login JOIN users ON login.user_id = users.id AND users.id  = $id");
        return $query->row();
    }

    /* Save updated user profile information to the Database
     * ******************************************************* */

    function update_profile_info($update_info) {
        if (array_key_exists('upload_path', $update_info)) {
            $profile = array(
                'full_name' => $update_info['fullname'],
                'contact' => $update_info['contact'],
                'position' => $update_info['job_title'],
                'address' => $update_info['address'],
                'email' => $update_info['email_address'],
                'about_me' => $update_info['about_me'],
                'picture' => $update_info['upload_path']
            );
            $this->session->set_userdata('picture', $update_info['upload_path']);
        } else {
            $profile = array(
                'full_name' => $update_info['fullname'],
                'contact' => $update_info['contact'],
                'position' => $update_info['job_title'],
                'address' => $update_info['address'],
                'email' => $update_info['email_address'],
                'about_me' => $update_info['about_me'],
            );
        }
        $this->session->set_userdata('fullname', $update_info['fullname']);
        $this->session->set_userdata('username', $update_info['username']);

        $profile2 = array(
            'username' => $update_info['username'],
        );

        $id = $this->session->id;

        $this->db->where('id', $id);
        $results = $this->db->update('users', $profile);
        $this->db->where('user_id', $id);
        $results = $this->db->update('login', $profile2);

        if ($results) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* This will delete user pictures when the the profile has been update.
     * @param id -> String. It will take the user id and search through the table to the picture.
     * ******************************************************************************************* */

    public function delete_picture($id) {
        $id = intval($id);
        $pic_path = $this->db->query("SELECT picture FROM users WHERE id = $id");
        $pic_result = $pic_path->row();
        if (!empty($pic_result) && file_exists("./user_pictures/$pic_result->picture")) {
            unlink("./user_pictures/$pic_result->picture");
        }
    }

    public function change_password_db($old_pass, $new_pass) {
        $query = $this->db->get_where('login', array('user_id' => $this->session->id));
        $result = $query->row();
        $db_pass = $this->encryption->decrypt($result->password);

//        $db_pass = $result->password;
        if ($old_pass === $db_pass) {
            $user_id = $this->session->id;
            $encrypt_pass = $this->encryption->encrypt($new_pass);
            $this->db->query("UPDATE login SET password='$encrypt_pass' WHERE user_id='$user_id'");
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* Check if the username already exists in the database.
     * ****************************************************** */

    public function username_check_db($username) {
        $query = $this->db->query("SELECT EXISTS (SELECT 1 FROM users WHERE users.username = '$username') AS existence");
        if ($query) {
            //$exists = $query->row();
            return intval($query->row()->existence);
        }
    }

}
