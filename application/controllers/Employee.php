<?php

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Employee extends REST_Controller{
	public function __construct($config = 'rest') {
        parent::__construct($config);

        //load the employee model
        $this->load->model('employee_model');
    }

    //this is the function for showing the employee data with their salaries
    //the salaries will be more than one record from one emp_no
    public function index_get(){
        //take the request emp_no from the user
        $emp_no = $this->get('emp_no'); //equal $emp_no = $_GET['emp_no'];

        if($emp_no == ''){
            //call the get_all_employee_data function on employee model
            $row_employee = $this->employee_model->get_all_employee_data();
            $this->response($row_employee, 200);
        } else{
            //call the get_employee_by_emp_no function on employee model when the emp_no is not null
            $row_employee = $this->employee_model->get_employee_by_emp_no($emp_no);
            $this->response($row_employee, 200);

            //is the row_employee result set empty?
            if(empty($row_employee)){
                $this->response(null, 502);
            }
        }
    }

    //this is the function for inserting data to the employees table
    public function index_post(){
        //this is the array to collect the request from the user
        $data = array('emp_no'     => $this->post('emp_no'),
                      'birth_date' => $this->post('birth_date'),
                      'first_name' => $this->post('first_name'),
                      'last_name'  => $this->post('last_name'),
                      'gender'     => $this->post('gender'),
                      'hire_date'  => $this->post('hire_date'));

        //call the insert employee function on employee model with the array data parameter     
        $insert = $this->employee_model->insert_employee($data);

        //is the employee data insert to the employees table?
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }	
    }

    //this is the function for updating the employee data 
    public function index_put(){
        //this is the array to collect the request from the user
        $data = array('birth_date' => $this->put('birth_date'),
                      'first_name' => $this->put('first_name'),
                      'last_name'  => $this->put('last_name'),
                      'gender'     => $this->put('gender'),
                      'hire_date'  => $this->put('hire_date'),
                      'emp_no'     => $this->put('emp_no'));

        //call the update employee function on employee model with the array data parameter     
        $update = $this->employee_model->update_employee($data);

        //is the employee data update to the employees table?
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }   
    }

    //this is the function for deleting one record of the employee data by the emp_no
    public function index_delete(){
        //take the request from emp_no
        // $emp_no = $this->uri->segment(2);
        $emp_no = $this->delete('emp_no');

        //call the delete employee function on employee model with the array data parameter     
        $delete = $this->employee_model->delete_employee_by_emp_no($emp_no);

        //is the employee data delete from the employees table?
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }   
    }
}