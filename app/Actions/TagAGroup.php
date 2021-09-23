<?php

namespace App\Actions;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag as GroupTagRepository;
use BristolSU\Support\Action\ActionResponse;
use BristolSU\Support\Action\Contracts\Action;
use FormSchema\Generator\Field;
use FormSchema\Schema\Form;

class TagAGroup extends Action
{

    /**
     * @inheritDoc
     */
    public static function options(): Form
    {
        $selectField = \FormSchema\Generator\Field::select('tag_id')->setLabel('Tag')->setRequired(true);
        app(GroupTagRepository::class)->all()->each(fn(GroupTag $groupTag) => $selectField->withOption($groupTag->fullReference(), sprintf('%s (%s)', $groupTag->name(), $groupTag->fullReference()), $groupTag->category()->name()));

        return \FormSchema\Generator\Form::make()->withField(
            Field::input('group_id')->inputType('text')->label('Group ID')->required(true)->default(null)->hint('The ID of the group to tag')
        )->withField($selectField)->getSchema();
    }

    /**
     * @inheritDoc
     */
    public function run(): ActionResponse
    {
        $groupId = (int) $this->option('group_id', null);
        if($groupId === null) {
            return ActionResponse::failure('The group ID was not given');
        }
        $tagId = (int) $this->option('tag_id', null);
        if($tagId === null) {
            return ActionResponse::failure('The tag ID was not given');
        }

        $group = app(GroupRepository::class)->getById($groupId);
        $tag = app(GroupTagRepository::class)->getById($tagId);
        $group->addTag($tag);

        return ActionResponse::success(sprintf('Group #%s tagged with tag #%s', $groupId, $tagId));
    }
}
