<?php

namespace App\Http\Requests\Api\ModuleInstanceController;

use BristolSU\Support\Activity\Contracts\Repository;
use BristolSU\Support\Completion\CompletionConditionInstance;
use BristolSU\Support\Completion\Contracts\CompletionCondition;
use BristolSU\Support\Completion\Contracts\CompletionConditionRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $validator->sometimes('mandatory', 'required|exists:logics,id', function($input) {
            return app(Repository::class)->getById($input->activity_id)->isCompletable();
        });
        $validator->sometimes(
            'completion_condition_alias',
            ['required', Rule::in(
                collect(app(CompletionConditionRepository::class)->getAllForModule($this->alias))->map(fn(CompletionCondition $completionCondition) => $completionCondition->alias())->toArray()
            )],
            function($input) {
                return app(Repository::class)->getById($input->activity_id)->isCompletable();
            }
        );
    }
}
