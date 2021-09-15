<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EmployeeModel;

class Employee extends ResourceController
{
	use ResponseTrait;

	public function index()
	{
		$model = new EmployeeModel();
		$data['employees'] = $model->orderBy('id', 'DESC')->findAll();
		return $this->respond($data);
	}


	public function create()
	{
		$model = new EmployeeModel();
		$data = 
		[
			'name'	=>	$this->request->getVar('name'),
			'email'	=>	$this->request->getVar('email'),
		];

		$model->insert($data);
		$response =
		[
			'status'	=>	201,
			'error'		=>	null,
			'messages'	=>	[
				'success'	=>	'New data added!'
			]
		];
		return $this->respondCreated($response);

	}


	public function show($id= null)
	{
		$model = new EmployeeModel();
		$data = $model->where('id', $id)->first();

		if($data) {
			return $this->respond($data);
		}else{
			return $this->failNotFound('No employee found with id ' .$id);
		}
	}


	public function delete($id=null)
	{
		$model = new EmployeeModel();
		$row = $model->find($id);

		if($row) {
			$model->delete($id);
			$response = [
				'status'	=> 200,
				'error'		=> null,
				'messages'	=> [
					'success' => 'Employee successfully deleted!'
				]	
			];
			return $this->respondDeleted($response);

		}

		else{
			return $this->failNotFound('No employee found with id ' .$id);
		}	
	}


	public function update($id=null)
	{
		$model = new EmployeeModel();
		$row = $model->find($id);

		if(!$row) {
			return $this->failNotFound('No employee found with id ' .$id);
		}

		$input = $this->request->getRawInput();
		$data = 
		[
			'name'	=> $input['name'],
			'email'	=>	$input['email'],
		];


	 	$model->update($id, $data);

	 		$response = [
				'status'	=> 200,
				'error'		=> null,
				'messages'	=> [
					'success' => 'Employee successfully updated!'
				]	
			];
			return $this->respond($response);

	 	}
		
		
		

		// $model->set($data);
		// $model->where('id', $id)->insert('employees');
		

	}

