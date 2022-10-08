<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;



class User extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    // hidden from json output
    protected $hidden = ['password', 'deleted_at'];
    


    public function setPassword(string $password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setPasswordHash(string $password)
    {
        $this->attributes['password'] = $password;
    }

    public function setUsername(string $username)
    {
        $this->attributes['username'] = strtolower($username);
    }

    public function getPasswordHash()
    {
        return $this->attributes['password'];
    }

    public function verifyPassword(string $password)
    {
        return password_verify($password, $this->attributes['password']);
    }

    public function getCreatedAt(string $format = 'Y-m-d H:i:s')
    {
       return $this->attributes['created_at'];
    }

    public function getUpdatedAt(string $format = 'Y-m-d H:i:s')
    {
         return $this->attributes['updated_at'];
    }

    public function getDeletedAt(string $format = 'Y-m-d H:i:s')
    {
            return $this->attributes['deleted_at'];
    }

    public function getUsername()
    {
        return strtolower($this->attributes['username']);
    }

}
