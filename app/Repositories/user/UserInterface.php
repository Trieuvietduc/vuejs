<?php
namespace App\Repositories\User;

interface UserInterface
{
    public function getUser($request);
    public function getById($id);
    public function checkEmail($request);
    public function createUser($request);
    public function update($request, $id);
   
  
}