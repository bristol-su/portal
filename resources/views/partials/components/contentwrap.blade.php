<div class="flex-col w-full md:flex md:flex-row md:min-h-screen bg-blueGray-50">
    @if(isset($sidebarSchema) && !isset($exception))
        <div id="sidebar-vue-root">
            <p-sidenav
                user-name="{{app(\BristolSU\Support\Authentication\Contracts\Authentication::class)->getUser()->data()->preferredName()}}"
                :nav-items="{{ json_encode($sidebarSchema) }}"
                subtitle="{{ $subtitle }}"
            >
            </p-sidenav>

            @if(session()->has('messages'))
                @foreach(session()->get('messages') as $message)
                    <p-notification type="{{$message['type']}}" message="{{$message['message']}}" :show-on-start="true"></p-notification>
                @endforeach
            @endif
        </div>

        <!-- Start Content -->
        <section class="w-full">
            {{--        <p-breadcrumbs--}}

            {{--        ></p-breadcrumbs>--}}

            <div class="container items-center px-5 py-8 mx-auto lg:px-24 w-full">
                <section class="text-blueGray-700 align-left">
                    <div class="container flex flex-col items-center px-5 py-8 mx-auto">
                        <div class="flex flex-col w-full mb-12 text-left ">
                            <div class="w-full mx-auto">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </section>
    @else
        <div id="sidebar-vue-root">
            @if(session()->has('messages'))
                @foreach(session()->get('messages') as $message)
                    <p-notification type="{{$message['type']}}" message="{{$message['message']}}" :show-on-start="true"></p-notification>
                @endforeach
            @endif
        </div>
        <div class="w-full">
            {{ $slot }}
        </div>
    @endif
</div>
