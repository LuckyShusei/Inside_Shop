<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseResourceRequest;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class UsersController extends BaseResourceController
{
    protected function _setData()
    {
        $this->Model = new User();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BaseResourceRequest $request
     * @return User|Model
     * @throws ValidationException
     */
    public function store(BaseResourceRequest $request) : Response
    {

        \Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => 'required|:password|min:8'
        ], $this->customMessage())->validate();

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => \Hash::make($request['password']),
            'role_id' => $request['role_id'],
            'organization_id' => $request['organization_id'],
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param BaseResourceRequest $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update(BaseResourceRequest $request, $id) : Response
    {
        \Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => 'required|same:password|min:8'
        ], $this->customMessage())->validate();

        $Data = $this->Model->find($id);
        $RequestData = $request->all();
        $old_password = $Data->password;
        if ($request['password'] == '********') {
            $RequestData['password'] = $old_password;
        } else {
            $RequestData['password'] = \Hash::make($request['password']);
        }
        if (isset($RequestData['_token'])) {
            unset($RequestData['_token']);
        }
        $Data->fill($RequestData);
        $Data->save();
        return response($Data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id) : Response
    {
        $Data = User::with(['role:id,name', 'organization:id,name'])->find($id);
        return response($Data);
    }

    public function me()
    {
        if (\Auth::check()) {
            $User = User::with(['role:id,name'])->find(\Auth::id());
            $Role = Role::with(['privileges:id,name'])->find($User->role_id);
            $Privileges = $Role->privileges;
            $Organization = Organization::find($User->organization_id);
            return response(array('user' => $User, 'roles' => [$Role], 'privileges' => $Privileges, 'organization' => $Organization));
        } else {
            return response();
        }
    }

    public function customMessage(): array
    {
        return [
            'email.unique' => 'このメールは既に使用されています。',
            'password.min' => '8 文字以上で入力してください。',
            'confirm_password.min' => '8 文字以上で入力してください。',
            'confirm_password.same' => 'パスワードと確認パスワードが異なっています。',
        ];
    }

}
