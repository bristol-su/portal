@extends('layouts.app')

@section('title', 'Settings')

@section('app-content')

    <ul class="nav nav-pills nav-fill">
        @foreach($categories as $category)
            <li class="nav-item">
                <a class="nav-link{{$active === $category->key() ? ' active' : ''}}" aria-current="page" href="{{route('settings.show', ['category' => $category->key()])}}">{{$category->name()}}</a>
            </li>
        @endforeach
    </ul>

    <div style="text-align: left;">
        <dynamic-settings :schema="{{json_encode($form)}}" :setting-keys="{{json_encode($settingKeys)}}">

        </dynamic-settings>
    </div>

@endsection
