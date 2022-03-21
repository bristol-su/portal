<?php

namespace App\Actions;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
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
        $selectField = \FormSchema\Generator\Field::select('tag_id')->setLabel('Tag')->setRequired(true);
        app(RoleTagRepository::class)->all()->each(fn(RoleTag $roleTag) => $selectField->withOption($roleTag->id(), sprintf('%s (%s)', $roleTag->name(), $roleTag->fullReference()), $roleTag->category()->name()));

        return \FormSchema\Generator\Form::make()->withField(
            Field::textInput('role_id')->setLabel('Role ID')->setRequired(true)->setValue(null)->setHint('The ID of the role to tag')
        )->withField($selectField)->form();
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
