<?php

namespace App\Providers;

use App\Events\UserVerificationRequestGenerated;
use App\Listeners\SendEmailVerificationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Facebook\FacebookExtendSocialite;
use SocialiteProviders\GitHub\GitHubExtendSocialite;
use SocialiteProviders\Google\GoogleExtendSocialite;
use SocialiteProviders\Instagram\InstagramExtendSocialite;
use SocialiteProviders\LinkedIn\LinkedInExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Reddit\RedditExtendSocialite;
use SocialiteProviders\SharePoint\SharePointExtendSocialite;
use SocialiteProviders\Slack\SlackExtendSocialite;
use SocialiteProviders\Spotify\SpotifyExtendSocialite;
use SocialiteProviders\Trello\TrelloExtendSocialite;
use SocialiteProviders\Twitter\TwitterExtendSocialite;
use SocialiteProviders\YouTube\YouTubeExtendSocialite;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserVerificationRequestGenerated::class => [
            SendEmailVerificationListener::class,
        ],
        SocialiteWasCalled::class => [
            RedditExtendSocialite::class,
            SharePointExtendSocialite::class,
            SpotifyExtendSocialite::class,
            TrelloExtendSocialite::class,
            TwitterExtendSocialite::class,
            YouTubeExtendSocialite::class,
            LinkedInExtendSocialite::class,
            SlackExtendSocialite::class,
            FacebookExtendSocialite::class,
            GitHubExtendSocialite::class,
            GoogleExtendSocialite::class,
            InstagramExtendSocialite::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
