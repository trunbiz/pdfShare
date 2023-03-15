<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FileModel extends Model
{
    //
    protected $table = 'files';
    protected $fillable = [
        'id',
        'title',
        'code',
        'description',
        'file_name'
    ];

    public function listAll($params)
    {
        $query = FileModel::query();
        if (!empty($params['search'])) {
            $query->where('title', 'like', '%' . $params['search'] . '%')
                ->orWhere('code', 'like', '%' . $params['search'] . '%');
        }
        return $query->paginate();
    }
}
