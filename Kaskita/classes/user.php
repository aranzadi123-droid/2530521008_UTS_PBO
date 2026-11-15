<?php

class User
{
    protected $id_user;
    protected $username;
    protected $password;
    protected $role;
    protected $nama;

    public function __construct($id_user, $username, $password, $role, $nama)
    {
        $this->id_user = $id_user;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->nama = $nama;
    }

    public function login()
    {
        return $this->username;
    }

    public function logout()
    {
        session_start();
        session_destroy();
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getUsername()
    {
        return $this->username;
    }
}