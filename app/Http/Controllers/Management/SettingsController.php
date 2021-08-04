<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use BristolSU\Support\Settings\Definition\Category;
use BristolSU\Support\Settings\Definition\SettingStore;
use FormSchema\Generator\Field;
use FormSchema\Generator\Form;
use FormSchema\Generator\Group;
use FormSchema\Transformers\VFGTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SettingsController extends Controller
{

    public function index(SettingStore $settingStore)
    {
        $category = collect($settingStore->getCategories())
            ->filter(fn(Category $category) => count($category->groupsWithGlobalSettings()) > 0)
            ->first();
        if($category === null) {
            throw new NotFoundHttpException('No settings could be found');
        }
        return redirect()->route('settings.show', ['category' => $category->key()]);
    }

    public function show(string $category, SettingStore $settingStore)
    {
        $categoryModel = $settingStore->getCategory($category);

        $formSchema = Form::make()->getSchema();
        $settingKeys = [];
        foreach($categoryModel->groupsWithGlobalSettings() as $group) {
            $groupSchema = Group::make($group->name())->getSchema();
            foreach($group->globalSettings($categoryModel) as $setting) {
                $settingKeys[$setting->inputName()] = $setting->key();
                $field = $setting->fieldOptions();
                $field->default($setting->value());
                $groupSchema->addField($field);
            }
            $formSchema->addGroup($groupSchema);
        }

        return view('management.settings.settings')
            ->with('categories',
                collect($settingStore->getCategories())
                    ->filter(fn(Category $category) => count($category->groupsWithGlobalSettings()) > 0)
            )
            ->with('active', $category)
            ->with('form', (new VFGTransformer())->transformToArray($formSchema))
            ->with('settingKeys', $settingKeys);
    }

}
