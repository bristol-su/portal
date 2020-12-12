<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\Filters\FilterInstance;
use BristolSU\Support\Logic\Contracts\LogicRepository;
use BristolSU\Support\Logic\Logic;
use Illuminate\Http\Request;

class LogicController extends Controller
{

    public function show(Logic $logic)
    {
        return $logic;
    }

    public function index()
    {
        return Logic::all();
    }

    public function store(Request $request, LogicRepository $repository, Authentication $authentication)
    {
        /** @var Logic $logic */
        $logic = $repository->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_id' => $authentication->getUser()->id()
        ]);

        // TODO Refactor below

        foreach ($request->input('all_true', []) as $filterId) {
            $filter = FilterInstance::findOrFail($filterId);
            $filter->logic_type = 'all_true';
            $filter->logic_id = $logic->id;
            $filter->save();
        }

        foreach ($request->input('all_false', []) as $filterId) {
            $filter = FilterInstance::findOrFail($filterId);
            $filter->logic_type = 'all_false';
            $filter->logic_id = $logic->id;
            $filter->save();
        }

        foreach ($request->input('any_true', []) as $filterId) {
            $filter = FilterInstance::findOrFail($filterId);
            $filter->logic_type = 'any_true';
            $filter->logic_id = $logic->id;
            $filter->save();
        }

        foreach ($request->input('any_false', []) as $filterId) {
            $filter = FilterInstance::findOrFail($filterId);
            $filter->logic_type = 'any_false';
            $filter->logic_id = $logic->id;
            $filter->save();
        }

        return $logic;
    }

    public function update(Logic $logic, Request $request, LogicRepository $repository)
    {
        return $repository->update($logic->id, $request->only(['name', 'description']));
    }

}
