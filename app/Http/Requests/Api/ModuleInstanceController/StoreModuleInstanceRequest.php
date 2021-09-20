<?php

namespace App\Http\Requests\Api\ModuleInstanceController;

use BristolSU\Support\Activity\Contracts\Repository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreModuleInstanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alias' => ['modulealias', 'required'],
            'activity_id' => ['exists:activities,id'],
            'name' => 'required|string',
            'description' => 'required|string',
            'slug' => 'required|string',
            'active' => 'required|exists:logics,id',
            'visible' => 'required|exists:logics,id',
            'mandatory' => 'nullable|exists:logics,id'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->sometimes('completion_condition_instance_id', 'required|exists:completion_condition_instances,id', function($input) {
            return app(Repository::class)->getById($input->activity_id)->isCompletable();
        });
    }
}
