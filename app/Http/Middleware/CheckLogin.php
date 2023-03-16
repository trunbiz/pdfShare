<?php

namespace App\Http\Middleware;
use App\Model\FileModel;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->group_id != 1)
            {
                $file = FileModel::find(Auth::user()->file_id);
                if (empty($file))
                {
                    return abort(404);
                }
                return redirect('admin/files/viewFile');
            }
            return $next($request);
        } else {
            return redirect("login");
        }
    }
}
