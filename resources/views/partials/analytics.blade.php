@if(config('app.analytics.enabled', false))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{config('app.analytics.UA')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '{{config('app.analytics.UA')}}', {
            'site_speed_sample_rate': 100
        });
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
