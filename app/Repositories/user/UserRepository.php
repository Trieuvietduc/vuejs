<?php

namespace App\Repositories\User;

use App\Http\Controllers\api\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Paginator;

class UserRepository extends BaseController implements UserInterface
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function getUser($request)
    {
        $userBuilder = $this->user;
        $newSizeLimit = $this->newListLimit($request);
        if (isset($request['search_input'])) {
            $userBuilder = $userBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('email', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('role_type', $request['search_input']));
            });
        }
        $user = $userBuilder->sortable(['created_at' => 'desc', 'status' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($user)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $user = $userBuilder->paginate($newSizeLimit);
        }
        return $user;
    }
    public function getById($id)
    {
        return $this->user->where('id', $id)->first();
    }
    public function checkEmail($request)
    {
        if ($request->fales) {
            return $this->user->where(function ($query) use ($request) {
                if (isset($request['id'])) {
                    $query->where('id', '!=', $request["id"]);
                }
                $query->where(['email' => $request["value"]]);
            })->exists();
        }
        return !$this->user->where(function ($query) use ($request) {
            if (isset($request['id'])) {
                $query->where('id', '!=', $request["id"]);
            }
            $query->where(['email' => $request["value"]]);
        })->exists();
    }
    public function update($request, $id)
    {
        $userInfo = $this->user->where('id', $id)->first();
        if (!$userInfo) {
            return false;
        }
        if ($request->role_id == 1) {
            $role = 'user';
        } elseif ($request->role_id == 2) {
            $role = 'admin';
        } else {
            $role = 'system_admin';
        }
        $userInfo->name = $request->name;
        $userInfo->email = $request->email;
        $userInfo->password = $request->password;
        $userInfo->role_id = $request->role_id;
        $userInfo->role_type = $role;
        if ($request->password) {
            $userInfo->password = Hash::make($request->password);
        }
        return $userInfo->save();
    }
    public function createUser($request){
        if ($request->role_id == 1) {
            $role = 'user';
        } elseif ($request->role_id == 2) {
            $role = 'admin';
        } else {
            $role = 'system_admin';
        }
        $mode = new User();
        $mode->fill([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'role_type' => $role
        ])->save();
        return $mode;
    }
}
