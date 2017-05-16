<?php

class Employee_Model extends CI_Model{

	public function get_all_employee_data(){
		$sql = "SELECT employees.emp_no,
					   employees.birth_date,
					   employees.first_name,
					   employees.last_name,
					   employees.gender,
					   employees.hire_date,
					   salaries.salary
				FROM employees 
				LEFT JOIN salaries ON salaries.emp_no = employees.emp_no
				LIMIT 50";

		$rs  = $this->db->query($sql); //equal mysqli_query($sql);
		return $rs->result(); //equal mysqli_fetch_array($rs);
	}

	public function get_employee_by_emp_no($emp_no){
		$sql = "SELECT employees.emp_no,
					   employees.birth_date,
					   employees.first_name,
					   employees.last_name,
					   employees.gender,
					   employees.hire_date,
					   salaries.salary
				FROM employees 
				LEFT JOIN salaries ON salaries.emp_no = employees.emp_no
				WHERE employees.emp_no = ?";

		$rs = $this->db->query($sql, array($emp_no)); 
		return $rs->result();
	}

	public function insert_employee($data){
		$sql = "INSERT INTO employees(emp_no, birth_date, first_name, last_name, gender, hire_date)
				VALUES(?, ?, ?, ?, ?, ?)";

		$rs = $this->db->query($sql, $data);
		return $rs;
	}

	public function update_employee($data){
		$sql = "UPDATE employees SET birth_date = ?,
									 first_name = ?,
									 last_name = ?,
									 gender = ?,
									 hire_date = ? 
				WHERE emp_no = ?";

		$rs = $this->db->query($sql, $data);
		return $rs;
	}

	public function delete_employee_by_emp_no($emp_no){
		$sql = "DELETE FROM employees 
				WHERE emp_no = ?";

		$rs = $this->db->query($sql, $emp_no);
		return $rs;
	}
}