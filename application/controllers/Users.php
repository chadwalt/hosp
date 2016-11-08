<?php

/*
 * This controller will be used to controll all the user module functionality.
 */

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /* This function will be used to validate submited data. Eg through POST.
     * The function will return the validated data to the calling controller method.
     * ***************************************************************************** */

    public function validate_fields($data) {
        $data = stripslashes($data);
        $data = trim($data);
        $data = htmlentities($data);
        $data = html_escape($data);

        return $data;
    }

    /*
     * This will check if the user is loginned if not it will redirect the user to the login screen
     * ********************************************************************************************** */

    public function check_session() {
        if (!$this->session->user_id) {
            redirect('Main_controller/index');
        }
    }

    /* Load the header.
     * ********************************** */

    public function load_header() {
        $this->load->view('templates/header');
        $this->load->view('admin/navigation');
        $this->load->view('templates/noti-header');
    }

    /* This function will be used to call the page to register a user to the system.
     * View, edit add positions.
     * ****************************************************************************** */

    public function index() {
        $this->check_session();

        //Cache the view.
        $this->output->cache(3);

        $this->load_header();
        $this->load->view('admin/users');
    }

    /* This function will return all the registed users in the system.
     * ****************************************************************** */

    public function get_users() {
        $page = intval($this->validate_fields($this->input->post('page')));
        $rows = intval($this->validate_fields($this->input->post('rows')));

        $results = $this->Users_model->get_users($page, $rows);

        echo json_encode($results);
    }

    /* This function will be used to save user information to the database by calling the save_user_db method.
     * ******************************************************************************************************* */

    public function save_user() {
        $this->check_session();

        $save_info = array(
            'full_name' => $this->validate_fields($this->input->post('full_name')),
            'username' => $this->validate_fields($this->input->post('username')),
            'contact' => $this->validate_fields($this->input->post('phone')),
            'address' => $this->validate_fields($this->input->post('address')),
            'email' => $this->validate_fields($this->input->post('email')),
            'positions' => $this->validate_fields($this->input->post('positions')),
            'password' => $this->encryption->encrypt($this->validate_fields($this->input->post('password'))),
            'gender' => $this->validate_fields($this->input->post('gender')),
        );

        if (!empty($_FILES['upload_picture']['name'])) {
            $config['upload_path'] = './user_pictures/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['file_name'] = $save_info['full_name'];

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('upload_picture')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else {
                $save_info['picture'] = $this->upload->data('file_name');

                $password = $this->Users_model->save_user_db($save_info);
            }
        } else {
            $password = $this->Users_model->save_user_db($save_info);
            // This will be used to send the user his/her login creditials.
            //$this->send_login_details($save_info['username'], $save_info['email'], $password);
        }

        echo json_encode(array('success' => $password));
    }

    /* Send the added user his/her login details to their emails.
     * ********************************************************** */

    function send_login_details($username, $email_to, $password) {
        $this->check_session();
        include_once './libraries/sendgrid-php/vendor/autoload.php';

        $email_subject = 'Victory School. Password';
        $email_message = "This email contain your login details" . "<br> Username: " . $username . "<br> Password: " . $password;

        $sendgrid = new SendGrid('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 ');
        $email = new SendGrid\Email();
        $email->addTo($email_to)->setFrom('victoryschool@victory.co.ug')
                ->setSubject($email_subject)
                //->setText($email_message)
                ->setHtml($email_message);

        // Catch the error
        try {
            $sendgrid->send($email);
            $msg = '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Email Has Been Sent.
                          </div>';
            $this->session->set_flashdata('email_pass_send_success', $msg);
        } catch (\SendGrid\Exception $e) {
            $msg = '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Email Not Sent. Check your internet connection.
                          </div>';
            $this->session->set_flashdata('email_pass_send_error', $msg);


            //            echo $e->getCode();
            //            foreach ($e->getErrors() as $er) {
            //                echo $er;
            //            }
        } finally {
            // Return to the calling controller method.
            redirect('Users/index');
        }
    }

    /* This function will be used to show all the registered system users.
     * *********************************************************************** */

    function view_users() {
        $this->check_session();

        // Get all the users from the database.
        $data['users'] = $this->Users_model->get_users();

        // Load the view to display the frontend pages.
        $this->load->view('templates/header');
        $this->load->view('users/view_users', $data);
    }

    /* Delete the user from the system.
     * ********************************* */

    function delete_user() {
        $id = $this->validate_fields($this->input->get_post('id'));

        $result = $this->Users_model->delete_user_db($id);

        if ($result) {
            echo json_encode(array('success' => TRUE));
        } else {
            echo json_encode(array('success' => FALSE));
        }
    }

    /* This function return information about the user
     * *********************************************** */

    public function get_user_info() {
        $this->check_session();
        $id = html_escape($this->input->get('id'));

        $result = $this->Users_model->get_user_info_db($id);
        echo json_encode($result);
    }

    /* Search through the records to get this User.
     * ************************************************ */

    public function search_user() {
        $search_item = htmlentities(trim($this->input->get('search_name')));
        $page = intval($this->input->post('page'));
        $rows = intval($this->input->post('rows'));

        $results = $this->Users_model->search_user_db($search_item, $page, $rows);
        if ($results) {
            echo json_encode($results);
        } else {
            echo json_encode(array());
        }
    }

    /* Deactivate or activate user in the system
     * ********************************************** */

    public function active_status() {
        $active_status = intval($this->validate_fields($this->input->post('status')));
        $user_id = intval($this->validate_fields($this->input->post('user_id')));

        if ($active_status === 1) {
            $active_status = 0;
            $results = $this->Users_model->active_status_db($active_status, $user_id);
        } else {
            $active_status = 1;
            $results = $this->Users_model->active_status_db($active_status, $user_id);
        }


        if ($results) {
            echo json_encode(array('success' => TRUE));
        } else {
            echo json_encode(array('success' => FALSE));
        }
    }

    /* This function will be displaying the profile page.
     * *************************************************** */

    public function profile() {
        $this->check_session();
        $id = intval($this->session->id);

        $data['value'] = $this->Users_model->get_profile($id);

        $this->load->view('templates/header.php');
        $this->load->view('users/profile', $data);
    }

    /* Update the profile with new values.
     * *************************************** */

    public function update_profile() {
        $this->check_session();

        $update_info = array(
            'fullname' => ucwords(html_escape($this->input->post('fullname'))),
            'username' => html_escape($this->input->post('username')),
            'contact' => html_escape($this->input->post('contact')),
            'address' => html_escape($this->input->post('address')),
            'email_address' => html_escape($this->input->post('email_address')),
            'job_title' => html_escape($this->input->post('job_title')),
            'about_me' => html_escape($this->input->post('about_me'))
        );

        if (!empty($_FILES['profile_pic']['name'])) {

            //This will delete the old picture from the server.
            $id = $this->session->id;
            $this->Users_model->delete_picture($id);

            $config['upload_path'] = './user_pictures/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['file_name'] = $this->session->username . $this->session->id;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('profile_pic')) {
                $path = array('upload_path' => $this->upload->data('file_name'));

                $values = array_merge($update_info, $path);
                $results = $this->Users_model->update_profile_info($values);
            } else {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            }
        } else {
            $results = $this->Users_model->update_profile_info($update_info);
        }

        if ($results) {
            echo json_encode(array('success' => TRUE));
            //redirect('Users/profile');
        } else {
            echo json_encode(array('success' => FALSE));
        }
    }

    public function change_password() {
        $old_pass = $this->validate_fields($this->input->post('old_pass'));
        $new_pass = $this->validate_fields($this->input->post('new_pass'));

        $results = $this->Users_model->change_password_db($old_pass, $new_pass);
        if ($results) {
            echo json_encode(array('success' => TRUE));
        } else {
            echo json_encode(array('success' => FALSE));
        }
    }

    /* This function will check if the username already exists.
     * ********************************************************* */

    public function username_check() {
        $username = $this->validate_fields($this->input->post('username'));

        $result = $this->Users_model->username_check_db($username);
        echo json_encode(array('result' => $result));
    }

}
