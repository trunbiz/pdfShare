<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\FileModel;
use App\Model\usersModel;
use Illuminate\Http\Request;

class FileController extends Controller
{
    //
    protected $fileModel;
    public function __construct()
    {
        $this->fileModel = new FileModel();
    }

    public function index(Request $request)
    {
        $request = $request->all();
        $data['items'] = $this->fileModel->listAll($request);
        return view('admin.files', $data);
    }

    public function showStore(Request $request)
    {
        return view('admin.storeFile');
    }

    public function store(Request $request)
    {
        $request = $request->all();
        $data = [
            'title' => $request['title'] ?? null,
            'code' => $request['code'] ?? Str::random(6),
            'description' => $request['description'] ?? null,
        ];

        if (!empty($request['file_name'])) {
            $filename = $request['file_name']->getClientOriginalName();
            $data['file_name'] = $filename;
            $request['file_name']->move('public/media', $filename);
        }

        FileModel::create($data);
        return redirect('admin/files');
    }
    public function showEdit(Request $request)
    {
        $request = $request->all();
        $data['item'] = FileModel::find($request['id']);
        return view('admin.storeFile', $data);
    }
    public function update(Request $request)
    {
        $request = $request->all();

        $data = [
            'title' => $request['title'] ?? null,
            'code' => $request['code'] ?? Str::random(6),
            'description' => $request['description'] ?? null,
        ];

        if (!empty($request['file_name'])) {
            $filename = $request['file_name']->getClientOriginalName();
            $data['file_name'] = $filename;
            $request['file_name']->move('public/media', $filename);
        }

        FileModel::find($request['id'])->update($data);
        return redirect('admin/files');
    }
    public function deleteItem(Request $request)
    {
        $request = $request->all();
        FileModel::find($request['id'])->delete();
        usersModel::where('file_id', $request['id'])->delete();
        return redirect('admin/files');
    }

    public function viewFile(Request $request)
    {
        $request = $request->all();
        $item = FileModel::find($request['id']);
        if (empty($item))
        {
            return abort(404);
        }
        return redirect('public/media/' . $item->file_name);
    }
}
