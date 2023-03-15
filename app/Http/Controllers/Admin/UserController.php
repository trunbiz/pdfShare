<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\FileModel;
use App\Model\usersModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    protected $userModel;
    protected $fileModel;
    protected $fileOption;

    public function __construct()
    {
        $this->userModel = new usersModel();
        $this->fileModel = new FileModel();
        $this->fileOption = FileModel::query()->orderBy('id', 'desc')->get();
    }

    public function index(Request $request)
    {
        $request = $request->all();
        $data['items'] = $this->userModel->getListAll($request);
        return view('admin.users', $data);
    }

    public function showStore(Request $request)
    {
        $request = $request->all();
        $data['groupUser'] = usersModel::GROUP_USER;
        $data['fileOption'] = $this->fileOption;
        return view('admin.storeUser', $data);
    }

    public function store(Request $request)
    {
        $request = $request->all();
        $data = [
            'group_id' => $request['group_id'] ?? null,
            'username' => $request['username'] ?? null,
            'email' => $request['email'] ?? null,
            'phone' => $request['phone'] ?? null,
            'city' => $request['city'] ?? null,
            'address' => $request['address'] ?? null,
            'password' => bcrypt($request['password']) ?? null,
            'status' => $request['status'] ?? null,
            'file_id' => $request['file_id'] ?? null,
        ];
        if (!empty($request['password'])) {
            $data['password'] = bcrypt($request['password']) ?? null;
        }
        if (!empty($request['img'])) {
            $filename = $request['img']->getClientOriginalName();
            $data['avatar'] = $filename;
            $request['img']->move('public/media', $filename);
        }
        usersModel::create($data);
        return redirect('admin/users');
    }

    public function showEdit(Request $request)
    {
        $request = $request->all();
        $data['item'] = usersModel::find($request['id']);
        $data['groupUser'] = usersModel::GROUP_USER;
        $data['fileOption'] = $this->fileOption;
        return view('admin.storeUser', $data);
    }

    public function update(Request $request)
    {
        $request = $request->all();
        $data = [
            'group_id' => !empty($request['group_id']) ? $request['group_id']: null,
            'email' => !empty($request['email']) ? $request['email'] : null,
            'phone' => !empty($request['phone']) ? $request['phone'] : null,
            'city' => !empty($request['city']) ? $request['city'] : null,
            'address' => !empty($request['address']) ? $request['address'] : null,
            'password' => !empty($request['password'])? bcrypt($request['password']) : null,
            'status' => !empty($request['status'])? $request['status'] : null,
            'file_id' => !empty($request['file_id']) ? $request['file_id'] : null,
        ];
        if (!empty($request['password'])) {
            $data['password'] = bcrypt($request['password']) ?? null;
        }
        if (!empty($request['img'])) {
            $filename = $request['img']->getClientOriginalName();
            $data['avatar'] = $filename;
            $request['img']->move('public/media', $filename);
        }
        usersModel::find($request['id'])->update($data);
        return redirect('admin/users');
    }

    public function deleteItem(Request $request)
    {
        $request = $request->all();
        usersModel::find($request['id'])->delete();
        return redirect('admin/users');
    }
}
