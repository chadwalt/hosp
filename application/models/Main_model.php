<?php

/*
 * To file will control the main database operations
 */

class Main_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* This function will used to get the school logo and store it a session
     * ********************************************************************** */

    function get_logo() {
        $query = $this->db->get('general_settings');
        $this->session->set_userdata('vic_email', $query->row()->email);
//        $data =  $query->row();
        return $query->row();

//        $this->session->set_userdata('logo', $data->logo);
    }

    /* Vaildate user logins. Check if the username matches the password.
     * ***************************************************************** */

    public function get_valid_login($username, $password) {
        $results = $this->db->query("SELECT id, username, password, picture, positions FROM users WHERE username = '$username' AND active_status =0 LIMIT 1 ");

        if (empty($results->row())) {
            return FALSE;
        }

        $row = $results->row();
        $db_pass = $this->encryption->decrypt($row->password);

        if ($password == $db_pass) {
            $info = array(
                'user_id' => $row->id,
                'username' => $row->username,
                'login_type' => $row->positions,
                'picture' => $row->picture
            );

            $this->session->set_userdata($info);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* This function is used to check if the password matches a user in the database
     * This function is used when the user has suspended the account. 
     * Called from the suspend_pass_check() method
     * ***************************************************************************** */

    public function suspend_pass_check_db($password) {
        $username = $this->session->username;
        $fullname = $this->session->fullname;

        $query = $this->db->query("SELECT * FROM login JOIN users ON login.user_id = users.id AND login.username ='$username' AND users.full_name = '$fullname'");

        if ($query) {
            $result = $query->row();
            $db_pass = $this->encryption->decrypt($result->password);
            $pass = trim($password);

            if ($password == $db_pass) {
                $this->session->set_userdata('id', $result->user_id);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return $this->db->error();
        }
    }

    /* This will be used to get the general Information about the school from the database.
     * ************************************************************************************** */

    function get_general_info() {
        $query = $this->db->get('general_settings');
        return $query->row();
    }

    /* Save user details to the database. It takes two parameters.
     * @param user_info -> Array. This will hold the user's information.
     * @param account_info -> Array. This will hold the user's account information.
     * @param table -> String. This will hold the table that will be inserted into.
     * ************************************* *************************************** */

    public function save_user_detials($user_info) {
        //Check if the username already exists.        
        if ($this->username_check($user_info['username'], 'users') === TRUE) {
            $this->db->insert('users', $user_info);

            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* Checks if the username already exists in a given table.
     * @param username -> String. The user's username
     * @param table -> String. The database table to look into.
     * ****************************************************** */

    public function username_check($username, $table) {
        $query = $this->db->query("SELECT EXISTS (SELECT 1 FROM $table WHERE username = '$username' LIMIT 1) AS available");

        if (intval($query->row()->available) === 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* This function will save the general settings in the database.
     * **************************************************************************** */

    function save_general_settings_db($update_array) {
        $query = $this->db->insert('general_settings', $update_array);

        if ($query) {
            if (array_key_exists('logo', $update_array)) {
                $this->session->set_userdata('logo', $update_array['logo']);
            }
            $msg = '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Data saved successfully.
                          </div>';
            $this->session->set_flashdata('general_settings_success', $msg);
        } else {
            $msg = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Data not saved successfully. Please try again
                          </div>';
            $this->session->set_flashdata('general_settings_error', $msg);
        }
    }

    /* This function will update the general settings in the database.
     * **************************************************************************** */

    function update_general_settings_db($update_array) {
        $query = $this->db->update('general_settings', $update_array);

        if ($query) {
            if (array_key_exists('logo', $update_array)) {
                $this->session->set_userdata('logo', $update_array['logo']);
            }
            $msg = '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Data saved successfully.
                          </div>';
            $this->session->set_flashdata('general_settings_success', $msg);
        } else {
            $msg = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Data not saved successfully. Please try again
                          </div>';
            $this->session->set_flashdata('general_settings_error', $msg);
        }
    }

    /* Reset the users password in the database
     * ******************************************8 */

    public function reset_password_db($username) {
        ## First check if the user exists in the database.
        if ($this->username_check($username, 'users')) {
            return array('success' => FALSE, 'msg'=> 'Username does not exist');
        }
        
        ## Encrypt the username.
        $password = $this->encryption->encrypt($username);
        
        ## Then deactivate the user in the database and also reset the password.
        $update_query = $this->db->query("UPDATE users SET active_status = 1, password='$password' WHERE username = '$username'");
        
        if ($update_query){
            return array('success' => TRUE, 'msg'=> 'Password reset successful. Please contact Admin to activate your account.');
        } else {
            return array('success' => TRUE, 'msg'=> 'Error while processing the request. Please try again later.');
        }
    }

}
