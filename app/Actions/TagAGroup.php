<?php

namespace App\Actions;

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
        $tags = app(GroupTagRepository::class)->all();
        $values = [];
        foreach ($tags as $tag) {
            $values[] = [
                'id' => $tag->id(),
                'name' => sprintf('%s (%s)', $tag->name(), $tag->fullReference()),
                'group' => $tag->category()->name()
            ];
        }

        return \FormSchema\Generator\Form::make()->withField(
            Field::input('group_id')->inputType('text')->label('Group ID')->required(true)->default(null)->hint('The ID of the group to tag')
        )->withField(
            \FormSchema\Generator\Field::select('tag_id')->values($values)->label('Tag')->required(true)
        )->getSchema();
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
