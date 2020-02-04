<?php

namespace Tests\Unit\Support\Settings;

use App\Support\Settings\Setting;
use App\Support\Settings\SettingModel;
use Tests\TestCase;

class SettingTest extends TestCase
{

    /** @test */
    public function has_returns_true_if_the_setting_exists(){
        $repository = new Setting();
        SettingModel::create(['key' => 'a_key1', 'value' => 'SettingValue']);

        $this->assertTrue($repository->has('a_key1'));
    }

    /** @test */
    public function has_returns_false_if_the_setting_does_not_exist(){
        $repository = new Setting();
        SettingModel::create(['key' => 'a_key1', 'value' => 'SettingValue']);

        $this->assertFalse($repository->has('a_key2'));
    }

    /** @test */
    public function get_returns_the_default_if_the_setting_does_not_exist(){
        $repository = new Setting();
        SettingModel::create(['key' => 'a_key1', 'value' => 'SettingValue']);

        $this->assertEquals('DefaultValue', $repository->get('a_key2', 'DefaultValue'));
    }

    /** @test */
    public function get_returns_the_setting_value_ifa_found(){
        $repository = new Setting();
        SettingModel::create(['key' => 'a_key1', 'value' => 'SettingValue']);

        $this->assertEquals('SettingValue', $repository->get('a_key1', 'DefaultValue'));
    }

    /** @test */
    public function all_returns_all_settings_in_an_associative_array(){
        $repository = new Setting();

        SettingModel::create(['key' => 'a_key1', 'value' => 'SettingValue1']);
        SettingModel::create(['key' => 'a_key2', 'value' => 'SettingValue2']);
        SettingModel::create(['key' => 'a_key3', 'value' => 'SettingValue3']);

        $this->assertEquals([
            'a_key1' => 'SettingValue1',
            'a_key2' => 'SettingValue2',
            'a_key3' => 'SettingValue3'
        ], $repository->all());
    }

    /** @test */
    public function all_returns_an_empty_array_if_there_are_no_settings(){
        $repository = new Setting();

        $this->assertEquals([], $repository->all());
    }

    /** @test */
    public function set_updates_the_value_of_a_setting_if_it_already_exists(){
        $repository = new Setting();

        $setting = SettingModel::create(['key' => 'a_key1', 'value' => 'SettingValue1']);

        $repository->set('a_key1', 'SettingValue2');

        $this->assertDatabaseHas('settings', [
            'id' => $setting->id,
            'key' => 'a_key1',
            'value' => 'SettingValue2'
        ]);
    }

    /** @test */
    public function set_creates_a_setting_if_it_does_not_exist(){
        $repository = new Setting();

        $repository->set('a_key1', 'SettingValue2');

        $this->assertDatabaseHas('settings', [
            'key' => 'a_key1',
            'value' => 'SettingValue2'
        ]);
    }

}
