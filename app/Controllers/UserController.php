<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;


class UserController extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';

    /**
     * Display a listing of the resource.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function index()
    {
        $users = $this->model->orderBy('id', 'DESC')->findAll();
        return $this->respond([
            'status' => true,
            'message' => 'Users retrieved successfully',
            'data' => $users
        ],  200);
    }

    /**
     * Show resource
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function show($id = null)
    {
        $user = $this->model->find($id);
        if ($user) {
            return $this->respond([
                'status' => true,
                'message' => 'User retrieved successfully',
                'data' => $user
            ],  200);
        } else {
            return $this->failNotFound('User not found1');
        }
    }

    /**
     * Create resource
     * 
     * @return \CodeIgniter\HTTP\Response
     */

    public function create()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'password' => 'required|min_length[6]|max_length[255]',
            'password_confirm' => 'matches[password]'
        ];

        $messages = [
            'username' => [
                'required' => 'Username tidak boleh kosong',
                'min_length' => 'Username minimal 3 karakter',
                'max_length' => 'Username maksimal 20 karakter',
                'is_unique' => 'Username sudah terdaftar'
            ],
            'password' => [
                'required' => 'Password tidak boleh kosong',
                'min_length' => 'Password minimal 6 karakter',
                'max_length' => 'Password maksimal 255 karakter'
            ],
            'password_confirm' => [
                'matches' => 'Password tidak sama'
            ]
        ];

        $validation = $this->validate($rules, $messages);

        if (!$validation) {
            return $this->respond([
                'status' => false,
                'message' => 'Validation error',
                'data' => $this->validator->getErrors()
            ],  422);
        } else {
            $data = [
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];

            $user = $this->model->insert($data);
            if ($user) {
                return $this->respondCreated([
                    'status' => true,
                    'message' => 'User created successfully',
                    'data' => $data
                ],  201);
            } else {
                return $this->failServerError('User creation failed');
            }
        }
    }

    /**
     * Update resource
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */

    public function update($id = null)
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]',
            'password' => 'required|min_length[6]|max_length[255]',
            'password_confirm' => 'matches[password]'
        ];

        $messages = [
            'username' => [
                'required' => 'Username tidak boleh kosong',
                'min_length' => 'Username minimal 3 karakter',
                'max_length' => 'Username maksimal 20 karakter'
            ],
            'password' => [
                'required' => 'Password tidak boleh kosong',
                'min_length' => 'Password minimal 6 karakter',
                'max_length' => 'Password maksimal 255 karakter'
            ],
            'password_confirm' => [
                'matches' => 'Password tidak sama'
            ]
        ];

        $validation = $this->validate($rules, $messages);

        if (!$validation) {
            return $this->respond([
                'status' => false,
                'message' => 'Validation error',
                'data' => $this->validator->getErrors()
            ],  422);
        } else {
         $user = $this->model->find($id);
   
            if ($user) {
               if($this->request->getJSON()) {
                    $input = $this->request->getJSON();
                } else {
                    $input = $this->request->getRawInput();
                }
         

                $data = [
                    'username' => $input['username'],
                    'password' => password_hash($input['password'], PASSWORD_DEFAULT)
                ];

                $user = $this->model->update($id, $data);
                if ($user) {
                    return $this->respond([
                        'status' => true,
                        'message' => 'User updated successfully',
                        'data' => $data
                    ],  200);
                } else {
                    return $this->failServerError('User update failed');
                }
            } else {
                return $this->failNotFound('User not found1');
            }
        }
    }

    /**
     * Delete resource
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function delete($id = null)
    {
        $user = $this->model->find($id);
        if ($user) {
            $this->model->delete($id);
            return $this->respondDeleted([
                'status' => true,
                'message' => 'User deleted successfully',
                'data' => $user
            ],  200);
        } else {
            return $this->failNotFound('User not found1');
        }
    }

    /** 
     *  restore resource
     *  @param int $id
     *  @method POST
     */
    public function restore($id = null)
    {
      
        $user = $this->model->onlyDeleted()->find($id);
        if ($user) {
            // $this->model->protect(false)->restore($id);
            $this->model->update($id, ['deleted_at' => null]);
            return $this->respond([
                'status' => true,
                'message' => 'User restored successfully',
                'data' => $user
            ],  200);
        } else {
            return $this->failNotFound('User not found');
        }
    }
}
