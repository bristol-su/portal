<?php

namespace App\Actions;

use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepository;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag as RoleTagRepository;
use BristolSU\Support\Action\ActionResponse;
use BristolSU\Support\Action\Contracts\Action;
use FormSchema\Generator\Field;
use FormSchema\Schema\Form;

class TagARole extends Action
{

    /**
     * @inheritDoc
     */
    public static function options(): Form
    {
        $tags = app(RoleTagRepository::class)->all();
        $values = [];
        foreach ($tags as $tag) {
            $values[] = [
                'id' => $tag->id(),
                'name' => sprintf('%s (%s)', $tag->name(), $tag->fullReference()),
                'role' => $tag->category()->name()
            ];
        }

        return \FormSchema\Generator\Form::make()->withField(
            Field::input('role_id')->inputType('text')->label('Role ID')->required(true)->default(null)->hint('The ID of the role to tag')
        )->withField(
            \FormSchema\Generator\Field::select('tag_id')->values($values)->label('Tag')->required(true)
        )->getSchema();
    }

    /**
     * @inheritDoc
     */
    public function run(): ActionResponse
    {
        $roleId = (int) $this->option('role_id', null);
        if($roleId === null) {
            return ActionResponse::failure('The role ID was not given');
        }
        $tagId = (int) $this->option('tag_id', null);
        if($tagId === null) {
            return ActionResponse::failure('The tag ID was not given');
        }

        $role = app(RoleRepository::class)->getById($roleId);
        $tag = app(RoleTagRepository::class)->getById($tagId);
        $role->addTag($tag);

        return ActionResponse::success(sprintf('Role #%s tagged with tag #%s', $roleId, $tagId));
    }
}
