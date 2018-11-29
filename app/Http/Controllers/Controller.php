<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\ApplicationModels\Role;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    static $errors = [];
    
    public function __construct()
    {
        View::share([
            'roles' => Role::orderBy("pos")->get(),
            'roles_by_name' => Role::get()->keyBy("name")
        ]);
    }

    public function message($text, $type = 'error')
	{
		self::$errors[] = ['type' => $type, 'text' => $text];
		return $type != 'danger';
    }
}
