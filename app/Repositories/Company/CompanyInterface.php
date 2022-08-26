<?php
namespace App\Repositories\Company;

interface CompanyInterface
{
    public function getCompany($request);
    public function getById($id);
    public function update($request,$id);
    public function createCompany($request);
  
}