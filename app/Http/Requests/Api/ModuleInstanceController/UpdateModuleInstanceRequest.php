<?php

namespace App\Http\Requests\Api\ModuleInstanceController;

use BristolSU\Support\Activity\Contracts\Repository;
use BristolSU\Support\Completion\CompletionConditionInstance;
use BristolSU\Support\Completion\Contracts\CompletionCondition;
use BristolSU\Support\Completion\Contracts\CompletionConditionRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Fluent;
use Illuminate\Validation\Rule;

class UpdateModuleInstanceRequest extends FormRequest
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
            'alias' => ['modulealias', 'sometimes'],
            'activity_id' => ['exists:activities,id'],
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'slug' => 'sometimes|string',
            'active' => 'sometimes|exists:logics,id',
            'visible' => 'sometimes|exists:logics,id',
            'mandatory' => 'nullable|exists:logics,id'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->sometimes('mandatory', 'sometimes|exists:logics,id', function(Fluent $input) {
            return $input->get('activity_id') && app(Repository::class)->getById($input->activity_id)->isCompletable();
        });
        $validator->sometimes(
            'completion_condition_alias',
            ['sometimes', Rule::in(
                collect(app(CompletionConditionRepository::class)->getAllForModule($this->alias))->map(fn(CompletionCondition $completionCondition) => $completionCondition->alias())->toArray()
            )],
            function($input) {
                return $input->get('activity_id') && app(Repository::class)->getById($input->activity_id)->isCompletable();
            }
        );
    }
}
