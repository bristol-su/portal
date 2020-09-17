@inject('authentication', 'BristolSU\Support\User\Contracts\UserAuthentication')

<p-header
    title="{{config('app.name', 'Committee Portal')}}"
    :is-logged-in="{{($authentication->getUser() === null ? 'false' : 'true')}}">

</p-header>
