<?php

require_once 'User.php';

class Mahasiswa extends User
{
    private $id_mahasiswa;
    private $nim;
    private $nama_mahasiswa;
    private $no_hp;
    private $status;

    public function __construct(
        $id_user,
        $username,
        $password,
        $role,
        $nama,
        $id_mahasiswa,
        $nim,
        $nama_mahasiswa,
        $no_hp,
        $status
    ) {
        parent::__construct(
            $id_user,
            $username,
            $password,
            $role,
            $nama
        );

        $this->id_mahasiswa = $id_mahasiswa;
        $this->nim = $nim;
        $this->nama_mahasiswa = $nama_mahasiswa;
        $this->no_hp = $no_hp;
        $this->status = $status;
    }

    public function getNim()
    {
        return $this->nim;
    }

    public function getNamaMahasiswa()
    {
        return $this->nama_mahasiswa;
    }

    public function getNoHp()
    {
        return $this->no_hp;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function tampilkanData()
    {
        return [
            'id_mahasiswa' => $this->id_mahasiswa,
            'nim' => $this->nim,
            'nama' => $this->nama_mahasiswa,
            'no_hp' => $this->no_hp,
            'status' => $this->status
        ];
    }
}