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

{{--                            <h1 class="mx-auto mb-12 text-2xl font-semibold leading-none tracking-tighter text-black lg:text-3xl title-font" v-if="pageTitle" v-text="pageTitle"></h1>--}}
{{--                            <h2 class="mx-auto mb-4 text-xl font-semibold leading-none tracking-tighter text-black title-font" v-if="pageSubtitle" v-text="pageSubtitle"></h2>--}}
{{--                            <p class="mx-auto text-base font-medium leading-relaxed text-blueGray-700 " v-if="pageContent" v-text="pageContent"></p>--}}
