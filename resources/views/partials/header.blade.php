@inject('authentication', 'BristolSU\Support\User\Contracts\UserAuthentication')

<p-header
    title="{{config('app.name', 'Committee Portal')}}"
    :is-logged-in="{{($authentication->getUser() === null ? 'false' : 'true')}}"
    drawer-tag="{{ (isset($drawerTag) ? $drawerTag : 'p-nav-drawer-module')}}"
    first-name="{{($authentication->getUser() === null ? '' : $authentication->getUser()->controlUser()->data()->firstName())}}">



</p-header>
