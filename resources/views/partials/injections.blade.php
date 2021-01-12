@push('fonts')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
@endpush

@push('meta-tags')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=10">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@prepend('scripts')
    @include('theme::scripts')

    @if(config('app.analytics.enabled', false))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{config('app.analytics.UA')}}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', '{{config('app.analytics.UA')}}');
        </script>
    @endif

    @can('access-helpdesk')
        <script>
            window.fwSettings={
                'widget_id':{{config('app.helpdesk.widget.id')}}
            };
            !function(){if("function"!=typeof window.FreshworksWidget){var n=function(){n.q.push(arguments)};n.q=[],window.FreshworksWidget=n}}()
        </script>
        <script type='text/javascript' src='https://euc-widget.freshworks.com/widgets/{{config('app.helpdesk.widget.id')}}.js' async defer></script>
    @endcan


@endprepend


@push('styles')
    @include('theme::styles')
@endpush
