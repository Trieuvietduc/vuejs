<?php

namespace App\Repositories\Company;

use App\Http\Controllers\api\BaseController;
use App\Models\Company;
use Nette\Utils\Paginator;

class CompanyRepository extends BaseController implements CompanyInterface
{
    private $company;
    public function __construct(Company $company)
    {
        $this->company = $company;
    }
    public function getCompany($request)
    {
        $companyBuilder = $this->company;
        $newSizeLimit = $this->newListLimit($request);
        if (isset($request['search_input'])) {
            $companyBuilder = $companyBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('code', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('telephone', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('address', $request['search_input']));
            });
        }
        $company = $companyBuilder->sortable(['created_at' => 'desc', 'status' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($company)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $company = $companyBuilder->paginate($newSizeLimit);
        }
        return $company;
    }
    public function getById($id)
    {
        return $this->company->where('id', $id)->first();
    }
    public function update($request, $id)
    {
        $companyInfo = $this->company->where('id', $id)->first();

        $companyInfo->code = $request->name;
        $companyInfo->name = $request->name;
        $companyInfo->telephone = $request->telephone;
        $companyInfo->address = $request->address;
        return $companyInfo->save();
    }
    public function createCompany($request)
    {
        $mode = new Company();
        $mode->fill([
            'code' => $request->code,
            'name' => $request->name,
            'telephone' => $request->telephone,
            'address' => $request->address
        ])->save();
        return $mode;
    }
}
