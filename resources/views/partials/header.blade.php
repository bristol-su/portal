@inject('authentication', 'BristolSU\Support\User\Contracts\UserAuthentication')

<p-header
    title="{{config('app.name', 'Committee Portal')}}"
    drawer-tag="{{ (isset($drawerTag) ? $drawerTag : 'p-nav-drawer-module')}}">

</p-header>
