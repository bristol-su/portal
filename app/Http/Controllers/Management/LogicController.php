<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use BristolSU\Support\Logic\Contracts\LogicRepository;
use BristolSU\Support\Logic\Logic;
use Illuminate\Http\Request;

class LogicController extends Controller
{
    public function index(LogicRepository $logicRepository)
    {
        return view('management.logic.index')->with([
            'logics' => $logicRepository->all()
        ]);
    }

    public function create()
    {
        return view('management.logic.create');
    }

    public function show(Logic $logic)
    {
        return view('management.logic.show')->with(['logic' => $logic]);
    }

}
