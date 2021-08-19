<div id="header-vue-root">

    @auth
    <p-topbar
        home-route="{{route('portal')}}"
        logout-route="{{route('logout')}}"
        control-route="{{route('control')}}"
        settings-route="{{route('management')}}"
        :can-access-control="{{(\BristolSU\Support\Permissions\Facade\PermissionTester::evaluate('access-control') ? 'true' : 'false' )}}"
        :can-access-settings="{{(\BristolSU\Support\Permissions\Facade\PermissionTester::evaluate('view-management') ? 'true' : 'false' )}}"
        site-name="{{config('app.name', 'Committee Portal')}}"
        >
    </p-topbar>
    @endauth

{{--    @auth--}}
{{--        <div>--}}
{{--            <validation-errors></validation-errors>--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <breadcrumbs--}}
{{--                query-string="{{\Illuminate\Routing\UrlGenerator::getAuthQueryString()}}"--}}
{{--                :admin="{{(request()->is('a/*') ? 'true' : 'false')}}"--}}
{{--                previous="{{url()->previous()}}"--}}
{{--                :hide-back="{{(request()->is('p', 'a') ? 'true' : 'false')}}"></breadcrumbs>--}}
{{--        </div>--}}
{{--    @endauth--}}
</div>

@push('scripts')
    <script src="{{ mix('js/header.js') }}"></script>
@endpush
