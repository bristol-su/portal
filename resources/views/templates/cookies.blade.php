@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script>
@endpush

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />
@endpush

<script>
    window.cookieconsent.initialise({
        "palette": {
            "popup": {
                "background": "#0984e3",
                "text": "#ffffff"
            },
            "button": {
                "background": "#16e497",
                "text": "#000000"
            }
        },
        "theme": "classic",
        "position": "top",
        "static": true,
        "content": {
            "message": "We use cookies to ensure that we give you the best experience on our website. If you continue we'll assume that you are happy to receive all cookies on our website.",
            "href": "https://www.bristolsu.org.uk/terms-conditions/cookies-policy"
        },
        "cookie": {
            "domain": "{{config('app.cookie_domain')}}"
        }
    });
</script>
