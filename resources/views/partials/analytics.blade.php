@if(config('app.analytics.enabled', false))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{config('app.analytics.UA')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '{{config('app.analytics.UA')}}');

        // Feature detects Navigation Timing API support.
        if (window.performance) {
            // Gets the number of milliseconds since page load
            // (and rounds the result since the value must be an integer).
            var timeSincePageLoad = Math.round(performance.now());

            // Sends the timing event to Google Analytics.
            gtag('event', 'timing_complete', {
                'name': 'load',
                'value': timeSincePageLoad,
                'event_category': 'Page Load',
                'event_label': window.location.href
            });
        }
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
