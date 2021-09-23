<div id="header-vue-root">

    @if(app(\BristolSU\Support\Authentication\Contracts\Authentication::class)->hasUser() && !app('router')->is(['verify.notice', 'password.confirmation.notice']))
    <p-topbar
        logo="{{ asset('images/logo.png') }}"
        home-route="{{route('portal')}}"
        logout-route="{{route('logout')}}"
        control-route="{{route('control')}}"
        settings-route="{{route('management')}}"
        :can-access-control="{{(\BristolSU\Support\Permissions\Facade\PermissionTester::evaluate('access-control') ? 'true' : 'false' )}}"
        :can-access-settings="{{(\BristolSU\Support\Permissions\Facade\PermissionTester::evaluate('view-management') ? 'true' : 'false' )}}"
        site-name="{{config('app.name', 'Committee Portal')}}"
        default-avatar-src="{{asset('images/smallLogo.jpeg')}}"
        user-name="{{app(\BristolSU\Support\Authentication\Contracts\Authentication::class)->getUser()->data()->preferredName() ?? (app(\BristolSU\Support\Authentication\Contracts\Authentication::class)->getUser()->data()->firstName() . ' ' . app(\BristolSU\Support\Authentication\Contracts\Authentication::class)->getUser()->data()->lastName())}}"
        >
    </p-topbar>
    @endif

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
