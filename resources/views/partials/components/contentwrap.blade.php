<div class="flex-col w-full md:flex md:flex-row md:min-h-screen bg-blueGray-50">
    @auth
        <div id="sidebar-vue-root">
            <p-sidenav
                user-name="{{app(\BristolSU\Support\Authentication\Contracts\Authentication::class)->getUser()->data()->preferredName()}}"
                :nav-items="{{ json_encode($sidebarSchema) }}"
            >
            </p-sidenav>
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
    @endauth
</div>
