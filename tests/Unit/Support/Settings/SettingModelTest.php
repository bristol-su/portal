<?php

namespace Tests\Unit\Support\Settings;

use App\Support\Settings\SettingModel;
use BristolSU\Module\Typeform\CompletionConditions\Dummy;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SettingModelTest extends TestCase
{

    /** @test */
    public function it_saves_and_retrieves_a_string_type_setting(){
        $setting = SettingModel::create([
            'value' => 'a setting value', 'key' => 'a_key'
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'a_key',
            'value' => 'a setting value',
            'type' => 'string'
        ]);

        $this->assertEquals('a setting value', $setting->getSettingValue());
        $this->assertEquals('a setting value', $setting->value);
    }

    /** @test */
    public function it_saves_and_retrieves_a_integer_type_setting(){
        $setting = SettingModel::create([
            'value' => 5, 'key' => 'a_key'
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'a_key',
            'value' => 5,
            'type' => 'integer'
        ]);

        $this->assertEquals(5, $setting->getSettingValue());
        $this->assertEquals(5, $setting->value);

    }

    /** @test */
    public function it_saves_and_retrieves_an_associative_array_type_setting(){
        $setting = SettingModel::create([
            'value' => ['one' => 1, 'two' => 2], 'key' => 'a_key'
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'a_key',
            'value' => '{"one":1,"two":2}',
            'type' => 'array'
        ]);

        $this->assertEquals(['one' => 1, 'two' => 2], $setting->getSettingValue());
        $this->assertEquals(['one' => 1, 'two' => 2], $setting->value);

    }

    /** @test */
    public function it_saves_and_retrieves_an_array_type_setting(){
        $setting = SettingModel::create([
            'value' => ['one', 'two'], 'key' => 'a_key'
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'a_key',
            'value' => '["one","two"]',
            'type' => 'array'
        ]);

        $this->assertEquals(['one', 'two'], $setting->getSettingValue());
        $this->assertEquals(['one', 'two'], $setting->value);

    }

    /** @test */
    public function it_saves_and_retrieves_a_bool_true_type_setting(){
        $setting = SettingModel::create([
            'value' => true, 'key' => 'a_key'
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'a_key',
            'value' => 1,
            'type' => 'boolean'
        ]);

        $this->assertEquals(true, $setting->getSettingValue());
        $this->assertEquals(true, $setting->value);

    }

    /** @test */
    public function it_saves_and_retrieves_a_bool_false_type_setting(){
        $setting = SettingModel::create([
            'value' => false, 'key' => 'a_key'
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'a_key',
            'value' => 0,
            'type' => 'boolean'
        ]);

        $this->assertEquals(false, $setting->getSettingValue());
        $this->assertEquals(false, $setting->value);

    }

    /** @test */
    public function it_saves_and_retrieves_a_float_type_setting(){
        $setting = SettingModel::create([
            'value' => 3.1415926, 'key' => 'a_key'
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'a_key',
            'value' => 3.1415926,
            'type' => 'float'
        ]);

        $this->assertEquals(3.1415926, $setting->getSettingValue());
        $this->assertEquals(3.1415926, $setting->value);

    }

    /** @test */
    public function it_saves_and_retrieves_a_null_type_setting(){
        $setting = SettingModel::create([
            'value' => null, 'key' => 'a_key'
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'a_key',
            'value' => null,
            'type' => 'null'
        ]);

        $this->assertEquals(null, $setting->getSettingValue());
        $this->assertEquals(null, $setting->value);

    }

    /** @test */
    public function it_saves_and_retrieves_an_object_type_setting(){
        $object = new DummySerialisedClass('test1_value');

        $setting = SettingModel::create([
            'value' => $object, 'key' => 'a_key'
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'a_key',
            'type' => 'object'
        ]);

        $this->assertInstanceOf(DummySerialisedClass::class, $setting->getSettingValue());
        $this->assertInstanceOf(DummySerialisedClass::class, $setting->value);
        $this->assertEquals('test1_value', $setting->getSettingValue()->getTestValue());
        $this->assertEquals('test1_value', $setting->value->getTestValue());

    }

    /** @test */
    public function getSettingKey_returns_the_setting_key(){
        $setting = SettingModel::create([
            'key' => 'a_key', 'value' => true
        ]);

        $this->assertEquals('a_key', $setting->getSettingKey());
    }

    /** @test */
    public function scope_key_applies_a_where_constraint(){
        $setting1 = SettingModel::create([
            'key' => 'a_key1', 'value' => true
        ]);
        $setting2 = SettingModel::create([
            'key' => 'a_key2', 'value' => true
        ]);

        $setting = SettingModel::key('a_key1')->get();
        $this->assertInstanceOf(Collection::class, $setting);
        $this->assertCount(1, $setting);
        $this->assertInstanceOf(SettingModel::class, $setting[0]);
        $this->assertTrue($setting1->is($setting[0]));
    }
}

class DummySerialisedClass {
    public $test;

    public function __construct($value)
    {
        $this->test = $value;
    }

    public function getTestValue()
    {
        return $this->test;
    }
}
