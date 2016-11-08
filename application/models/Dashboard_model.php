<?php

class Dashboard_model extends CI_Model {

//This function will be used to return information about the the number of new children, registered children, parents and users.
    function get_dashboard_summary() {
        $results = array();
        $info = array('new_students', 'registered_students', 'courses', 'registered_users');

        $sql = "SELECT COUNT(*) AS data FROM students WHERE DATE(students.reg_date) BETWEEN DATE_SUB(CURDATE(), INTERVAL 5 DAY) AND DATE_SUB(CURDATE(), INTERVAL 0 DAY)" 
                . "UNION ALL " 
                . "SELECT COUNT(*) AS registered_students FROM students " 
                . "UNION ALL " 
                . "SELECT COUNT(*) AS recored_courses FROM courses " 
                . "UNION ALL " 
                . "SELECT COUNT(*) AS registered_users FROM users";
        
        $query = $this->db->query($sql);
        $new_students_row = $query->row(0); //Will hold the new students.
        $new_students_data = $new_students_row->data;

        $registered_students = $query->row(1);
        $registered_students_data = $registered_students->data; //Will hold the Registered students.

        //Getting the number of recorded parents.
        $recored_courses = $query->row(2);
        $recored_courses_data = $recored_courses->data;

        //Getting the number of registered users.
        $registered_users = $query->row(3);
        $registered_users_data = $registered_users->data;

        $values = array($new_students_data, $registered_students_data, $recored_courses_data, $registered_users_data);

        //Combining the $info array and $values array.
        $overall_data = array_combine($info, $values);

        //array_push($results, $overall_data);

        return $overall_data;
    }

    /*     * *********************************************************************************************************** */

    //Get all tasks from the database.
    public function get_todo_list_db() {
        $user_id = $this->session->id;
        //$this->db->where('user_id', $user_id);
        //$query = $this->db->get('task');
        $query = $this->db->query("SELECT *, IFNULL(title, description) AS description2 FROM  task WHERE user_id = '$user_id'");
        return $query->result();
    }

    //Save the task to the database
    public function save_task_db($task) {
        $task_details = array(
            'description' => $task,
            'user_id' => $this->session->id
        );

        $this->db->insert('task', $task_details);
    }

    //This will save the edited task to the database
    public function edit_task_db($id, $task, $user_id) {
        $query = $this->db->query("UPDATE task SET description = '$task' WHERE id='$id' AND user_id='$user_id'");
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //This will delete the task to the database
    public function delete_task_db($id, $user_id) {
        $query = $this->db->query("DELETE FROM  task WHERE id='$id' AND user_id='$user_id'");
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //Save Event to the database.
    public function save_event($title, $description, $event_start, $event_end, $event_color) {
        $id = $this->session->id;
        $event_details = array(
            'title' => $title,
            'description' => $description,
            'event_start' => $event_start,
            'event_end' => $event_end,
            'user_id' => $id,
            'color' => $event_color
        );

        $result = $this->db->insert('events', $event_details);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //Delete all events in the events table attached to this user.
    public function delete_events_db() {
        $id = $this->session->id;

        $result = $this->db->query("UPDATE events SET delete_status = 1 WHERE user_id = '$id'");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /* This will return the nums of events to the calling method. 
     * *********************************************************** */

    public function event_nums_db() {
        $sql = "SELECT 'todays_events' AS description, COUNT(*) AS num_of_events, 0 AS newly_created FROM events WHERE CAST(events.event_start AS DATE) = CURDATE()

                UNION ALL 

                SELECT 'upcoming_events' AS description, COUNT(*) AS num_of_events, IFNULL((CASE DATE (create_date) WHEN (CURDATE()) THEN COUNT(create_date) END),0) AS newly_created FROM events WHERE CAST(events.event_start AS DATE) > CURDATE()

                UNION ALL   

                SELECT 'finished_events' AS description, COUNT(*) AS num_of_events, 0 AS newly_created FROM events WHERE CAST(events.event_start AS DATE) < CURDATE()

                UNION ALL 

                SELECT 'deleted_events' AS description, COUNT(*) AS num_of_events, 0 AS newly_created FROM events WHERE events.delete_status = 1;
        ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    /* This call to the database will deleted all the deleted events permanent from the db.
     * ************************************************************************************** */

    public function events_permanent_delete_db() {
        $this->db->query("DELETE FROM events");
    }

    /* Add meetings to the database
     * Return TRUE on success and FALSE on failure.
     * ********************************************** */

    public function add_meeting_db($meeting_detials) {
        $query = $this->db->insert('task', $meeting_detials);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* This will be used to update a meetig on edit.
     * *********************************************** */

    public function edit_meeting_db($meeting_detials, $id) {
        $this->db->where('id', $id);
        $query = $this->db->update('task', $meeting_detials);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* Delete all the tasks from the database --> CURRENT USER
     * ******************************************************** */

    public function delete_tasks_db() {
        $this->db->where('user_id', $this->session->id);
        $query = $this->db->delete('task');

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* Return all the percentages for the feedback info.
     * Direct walkings, friends, media and also the Goal completions.
     * *************************************************************** */

    public function get_feeback_percentages() {
        $sql = "SELECT 'media' AS Media,  COUNT(media) AS num FROM feedback WHERE media !=''
                UNION ALL 
                SELECT 'friend' AS Friend,  COUNT(friend) AS num FROM feedback WHERE friend !=''
                UNION ALL 
                SELECT 'direct_walkins' AS direct_walkins,  COUNT(media) AS num FROM feedback WHERE direct_walkin !=0";

        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {
            return $this->db->error();
        }
    }

}
