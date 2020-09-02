<div id="header-vue-root">
    <v-app-bar app>


        <v-app-bar-nav-icon></v-app-bar-nav-icon>

        <v-toolbar-title>{{ config('app.name', 'Committee Portal') }}</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
            <v-icon>mdi-heart</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-menu
            left
            bottom
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    icon
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>
            </template>

            <v-list>

            </v-list>
        </v-menu>


    {{--                    <img style="max-height: 40px" src="{{asset('images/logo.jpg')}}"/>--}}

{{--            <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--                <ul class="navbar-nav ml-auto">--}}
{{--                @guest--}}
{{--                    <!-- Login and register links for non logged in users -->--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
{{--                        </li>--}}
{{--                @else--}}
{{----}}
{{----}}
{{--                    <!-- Account Management -->--}}
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"--}}
{{--                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                @inject('userAuthentication', 'BristolSU\Support\User\Contracts\UserAuthentication')--}}
{{--                                {{ $userAuthentication->getUser()->controlUser()->data()->preferredName() }} <span--}}
{{--                                    class="caret"></span>--}}
{{--                            </a>--}}
{{----}}
{{--                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
{{--                                <!-- Home -->--}}
{{--                                <a class="dropdown-item" href="#">--}}
{{--                                    @if($currentRole !== null)--}}
{{--                                        Acting as {{$currentRole->data()->roleName()}}--}}
{{--                                        of {{$currentRole->group()->data()->name()}}--}}
{{--                                    @elseif($currentGroup !== null)--}}
{{--                                        Acting in your membership to {{$currentGroup->data()->name()}}--}}
{{--                                    @elseif($currentUser !== null)--}}
{{--                                        Acting as yourself--}}
{{--                                    @else--}}
{{--                                        Not acting as anything--}}
{{--                                    @endif--}}
{{--                                </a>--}}
{{--                                <a class="dropdown-item" href="{{url('/')}}">Home</a>--}}
{{--                                <!-- Settings -->--}}
{{--                                @can('view-management')--}}
{{--                                    <a class="dropdown-item" href="{{ route('management') }}">Management</a>--}}
{{--                                @endcan--}}
{{--                                @can('access-control')--}}
{{--                                    <a class="dropdown-item" href="{{ route('control') }}">Control</a>--}}
{{--                            @endcan--}}
{{--                            <!-- Logout -->--}}
{{--                                <a class="dropdown-item" href="#"--}}
{{--                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
{{--                                    {{ __('Logout') }}--}}
{{--                                </a>--}}
{{--                                <form id="logout-form" action="{{ route('logout') }}" method="POST"--}}
{{--                                      style="display: none;">@csrf</form>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    @endguest--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </nav>--}}
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
    </v-app-bar>
</div>

@push('scripts')
    <script src="{{ mix('js/header.js') }}"></script>
@endpush
