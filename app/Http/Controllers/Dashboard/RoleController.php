<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use Spatie\Permission\Models\Role;

class RoleController extends Controller {

    public function index()
    {
        return Role::all();
    }

    public function create(CreateRoleRequest $request)
    {

    }
}
