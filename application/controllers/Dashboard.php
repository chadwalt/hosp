<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /*
     * This will check if the user is loginned if not it will redirect the user to the login screen
     * ********************************************************************************************** */

    public function check_session() {
        if (!$this->session->id) {
            redirect('Main_controller/index');
        }
    }

    function index() {
        //$this->check_session();

        //$data['dashboard_summary'] = $this->dashboard_summary();
        
        //Cache the index page to load faster.
        //$this->output->cache(3);
        
        //$this->load->view('templates/header.php', $data);
        $this->load->view('templates/index.php');
        //$this->load->view('main_app/index');
    }

    function dashboard_summary() {
        $this->check_session();

        $values = $this->Dashboard_model->get_dashboard_summary();
        return $values;
        //echo json_encode($values);
    }

    //Get all the tasks saved.
    function get_todo_list() {
        $this->check_session();

        $results = $this->Dashboard_model->get_todo_list_db();
        echo json_encode($results);
    }

    //Add Tasks to the Database.
    public function add_task() {
        $this->check_session();
        $todo = $this->input->post('todo');
        $this->Dashboard_model->save_task_db($todo);
    }

    //This function will be used to Edit Taks 
    public function edit_task() {
        $this->check_session();
        $id = $this->input->post('id');
        $task = $this->input->post('task');
        $user_id = $this->input->post('user_id');

        $result = $this->Dashboard_model->edit_task_db($id, $task, $user_id);
        echo $result;
    }

    //This will delete the task from the database.
    public function delete_task() {
        $this->check_session();

        $id = $this->input->post('id');
        $user_id = $this->input->post('user_id');

        $result = $this->Dashboard_model->delete_task_db($id, $user_id);
        echo $result;
    }

    public function try_pagination() {
        $this->load->library('pagination');


        $config['base_url'] = 'http://localhost/passie/index.php/dashboard/get_todo_list';
        $config['total_rows'] = 6;
        $config['per_page'] = 1;

        $this->pagination->initialize($config);

        echo $this->pagination->create_links();
    }

    //Add / Save event the Calendar
    public function add_event() {
        $this->check_session();

        $title = htmlentities($this->input->post('title'));
        $description = htmlentities($this->input->post('description'));
        $event_start = $this->input->post('event_start');
        $event_end = $this->input->post('event_end');
        $event_color = $this->input->post('event_color');

        $result = $this->Dashboard_model->save_event($title, $description, $event_start, $event_end, $event_color);
        echo $result;
    }

    //Deletes all Events to the Calender
    public function clear_events() {
        $this->check_session();

        $result = $this->Dashboard_model->delete_events_db();
        echo $result;
    }

//    public function get_tasks(){
//        $tasks = $this->Dashboard_model->get_tasks_db();
//        //$this->session->set_userdata($tasks);                
//    }
    //This function will be used to send emails.
    public function send_mail() {
        $this->check_session();
        include_once ('libraries/sendgrid-php/vendor/autoload.php');

        $email_to = explode(',', $this->input->post('email_to'));
        $email_subject = $this->input->post('email_subject');
        $email_message = $this->input->post('email_message');

        $sendgrid = new SendGrid('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 ');
        $email = new SendGrid\Email();
        $email
                ->setTos($email_to)
                ->setFrom($this->session->vic_email)
                ->setSubject($email_subject)
                //->setText($email_message)
                ->setHtml($email_message)
        ;

// Catch the error
        try {
            $sendgrid->send($email);
            echo 'Email Has Been Sent';
        } catch (\SendGrid\Exception $e) {
            echo $e->getCode();
            foreach ($e->getErrors() as $er) {
                echo $er;
            }
        }
    }

    /* This will count the number of events form past, present, deleted and future
     * *************************************************************************** */

    public function event_nums() {
        $result = $this->Dashboard_model->event_nums_db();
        echo json_encode($result);
    }

    /* This will delete the events permanently from the database after they reach 1200 records
     * **************************************************************************************** */

    public function events_permanent_delete() {
        $this->Dashboard_model->events_permanent_delete_db();
    }

    /* Add scheduled meetings to the database 
     * **************************************** */

    public function add_meeting() {
        $meeting_details = array(
            'title' => htmlentities($this->input->post('title')),
            'description' => htmlentities($this->input->post('description')),
            'where' => htmlentities($this->input->post('location')),
            'from' => htmlentities($this->input->post('from')),
            'to' => htmlentities($this->input->post('to')),
            'user_id' => $this->session->id
        );

        if (empty($this->input->post('id'))) {
            $results = $this->Dashboard_model->add_meeting_db($meeting_details);
        } else {
            $id = $this->input->post('id');
            $results = $this->Dashboard_model->edit_meeting_db($meeting_details, $id);
        }
        echo $results;
    }

    /* This wil clear all the tasks of the logined/current user
     * ******************************************************** */

    public function clear_tasks() {
        $this->check_session();

        $result = $this->Dashboard_model->delete_tasks_db();
        echo $result;
    }

    /* Return all the percentages for the feedback info.
     * Direct walkings, friends, media and also the Goal completions.
     * *************************************************************** */

    public function feedback_info() {
        $results = $this->Dashboard_model->get_feeback_percentages();

        echo json_encode($results);
    }

}
