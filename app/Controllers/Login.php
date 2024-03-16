<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;

class Login extends BaseController
{
    protected $validation;
    protected $session;
    protected $loginModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = session();
        $this->loginModel = new LoginModel(); // Meletakkan model di dalam konstruktor
    }

    public function index()
    {
        return view('login', ['validation' => $this->validation]);
    }

    public function login_action()
    {
        $rules = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username harus diisi'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return view('login', ['validation' => $this->validator]);
        } else {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $user = $this->loginModel->where('username', $username)->first(); // Menggunakan model di dalam metode
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    switch ($user['role']) {
                        case 'Admin':
                            return redirect()->to('admin/home');
                        case 'Pegawai':
                            return redirect()->to('pegawai/home');
                        default:
                            $this->session->setFlashdata('pesan', 'Akun anda error.');
                            return redirect()->to('/');
                    }
                } else {
                    $this->session->setFlashdata('pesan', 'Password salah');
                    return redirect()->to('/');
                }
            } else {
                $this->session->setFlashdata('pesan', 'Akun tidak ditemukan, silahkan coba lagi.');
                return redirect()->to('/');
            }
        }
    }
}
