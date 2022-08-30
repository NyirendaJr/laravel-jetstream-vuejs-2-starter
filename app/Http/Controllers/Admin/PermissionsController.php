<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class PermissionsController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/Permission/Index');
    }
}
