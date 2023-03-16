<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\blogModel;
use App\Model\cartModel;
use App\Model\FileModel;
use App\Model\productModel;
use App\Model\usersModel;
use Illuminate\Http\Request;
//use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; //use thư viện auth

class indexController extends Controller
{
    //
    private $user,$product,$cart,$blog;
    protected $fileOption;
    public function __construct()
    {
        $this->product=new productModel();
        $this->cart=new cartModel();
        $this->blog=new blogModel();
        $this->user=new usersModel();
        $this->fileOption = FileModel::query()->orderBy('id', 'desc')->get();
    }
    public function indexShow()
    {
        $data['countproduct']=count($this->product->listAll());
        $data['countcart']=count($this->cart->listAll());
        $data['countblog']=count($this->blog->listAll());
        $data['countuser']=count($this->user->listAll());
        return view('admin.index',$data);
    }
    public function showLogin()
    {
        return view('admin.login');
    }
    public function checkLogin(Request $request)
    {
        $arr = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        if ($request->remember == trans('remember.Remember Me')) {
            $remember = true;
        } else {
            $remember = false;
        }
        //kiểm tra trường remember có được chọn hay không

        if (Auth::attempt($arr)) {

            return redirect()->intended('admin');
        } else {

            return redirect()->intended('login');
        }
    }
    public function logout()
    {
        Auth::logout();
        Return redirect()->intended('login');
    }
    public function showRegister()
    {
        return view('front.register');
    }
    public function register(Request $request)
    {
        $this->user->addItem($request);
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        Auth::attempt($arr);
        if(Auth::user()->lever==1)
        {
            return redirect()->intended('/');
        }
        else{
            return redirect()->intended('admin');
        }

    }

    public function profileInfo(Request $request)
    {
        $data['groupUser'] = usersModel::GROUP_USER;
        $data['item'] = usersModel::find(\Illuminate\Support\Facades\Auth::user()->id);
        return view('admin.profile', $data);
    }

    public function profileUpdate(Request $request)
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

        $array['item'] = usersModel::find($request['id']);
        $array['groupUser'] = usersModel::GROUP_USER;
        $array['fileOption'] = $this->fileOption;
        return view('admin.profile', $array);
    }
}
