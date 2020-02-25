<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use BristolSU\Support\ModuleInstance\Contracts\ModuleInstanceRepository;
use BristolSU\Support\User\Contracts\UserAuthentication;
use Illuminate\Http\Request;

class ModuleInstanceController extends Controller
{

    public function store(Request $request, ModuleInstanceRepository $moduleInstanceRepo)
    {
        return $moduleInstanceRepo->create(array_merge($request->only([
            'alias', 'activity_id', 'name', 'description', 'slug', 'active', 'visible', 'mandatory', 'complete',
            'completion_condition_instance_id'
        ]), ['user_id' => app(UserAuthentication::class)->getUser()->controlId()]));
    }

}
