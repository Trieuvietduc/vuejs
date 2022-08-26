<?php

namespace App\Http\Controllers;

use App\Components\SearchQueryComponent;
use App\Http\Controllers\api\BaseController;
use App\Models\User;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use App\Enums\StatusCode;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $UserInterface;
    public function __construct(UserInterface $UserInterface)
    {
        $this->UserInterface = $UserInterface;
    }
    public function index(Request $request)
    {
        $list = SearchQueryComponent::alterQuery($request);
        $user = $this->UserInterface->getUser($request);
        $i = 1;
        return view('user.list', compact('user', 'list', 'i', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        $this->UserInterface->createUser($request);
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->role_id == 1) {
            return redirect()->route('user.index')->with('error', 'không có thẩm quyền');
        }
        $user = $this->UserInterface->getById($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $this->UserInterface->update($request, $id);
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = User::where('id', $id)->first();
        if ($check == null) {
            User::withTrashed()->where('id', $id)->forceDelete();
            return back();
        }
        User::where('id', $id)->delete();
        return back();
    }
    public function UseronlyTrashed(Request $request)
    {
        $user = User::onlyTrashed()->paginate(5);
        $list = SearchQueryComponent::alterQuery($request);
        return view('user.list', compact('user', 'list', 'request'));
    }
    public function Userrestore(Request $request)
    {
        $check = User::where('id', $request->id)->first();
        if ($check == null) {
            User::withTrashed()->where('id', $request->id)->restore();
            return redirect()->route('user.index');
        }
    }
    public function checkEmail(Request $request)
    {
        return response()->json([
            'valid' => $this->UserInterface->checkEmail($request),
        ], StatusCode::OK);
    }
}
