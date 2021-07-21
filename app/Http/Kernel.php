<?php

namespace App\Http;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckCredentialCookies;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\SetCredentialCookies;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\VerifyCsrfToken;
use Fruitcake\Cors\HandleCors;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laravel\Passport\Http\Middleware\CreateFreshApiToken;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        TrustProxies::class,
        HandleCors::class
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
        'password.confirm' => RequirePassword::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            CreateFreshApiToken::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],

        'api' => [
            'throttle:150,1',
            'bindings',
        ],

    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        /*
         * Request Middleware
         */

        // Start the current session. Use Laravel session not PHP Sessions.
        StartSession::class,

        // Share errors from the session with the view
        ShareErrorsFromSession::class,

        // Load authentication information from the session to set up the Laravel authentication framework
        AuthenticateSession::class,

        // Encrypt cookies on response
        EncryptCookies::class,

        // Create a fresh API token for consuming API through Passport
        \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,

        // Allow for route model binding.
        SubstituteBindings::class,

        // Validate the request signature. Used for Laravel signed URLs
        ValidateSignature::class,

        // Verify the CSRF token
        VerifyCsrfToken::class,

        // Throttle requests if needed
        ThrottleRequests::class,

        // Check the user is logged in if needed
        Authenticate::class,

        // Redirect a logged out user to the portal page when authenticated but accessing a guest page
        RedirectIfAuthenticated::class,

        // Check a users email is verified.
        EnsureEmailIsVerified::class,

        // Check an admin is logged into a user
        \BristolSU\Support\Authorization\Middleware\CheckAdminIsAtLeastUser::class,

        // Inject the module instance into the container
        \BristolSU\Support\ModuleInstance\Middleware\InjectModuleInstance::class,

        // Inject the activity into the container
        \BristolSU\Support\Activity\Middleware\InjectActivity::class,

        // Inject the activity instance into the container
        \BristolSU\Support\ActivityInstance\Middleware\InjectActivityInstance::class,

        // Check the module instance is active
        \BristolSU\Support\Authorization\Middleware\CheckModuleInstanceActive::class,

        // Check a module instance is enabled
        \BristolSU\Support\Authorization\Middleware\CheckModuleInstanceEnabled::class,

        // Check an activity is enabled
        \BristolSU\Support\Authorization\Middleware\CheckActivityEnabled::class,

        // Make variables available to the frontend of any module
        \BristolSU\Support\Http\Middleware\InjectJavascriptVariables::class,

        // Check the control user logged in is owned by the database user
        \BristolSU\Support\Authorization\Middleware\CheckDatabaseUserOwnsControlUser::class,

        // Check the logged in control user can be logged into the group/role they're logged into
        \BristolSU\Support\Authorization\Middleware\CheckAdditionalCredentialsOwnedByUser::class,

        // Ensure an activity instance has been set
        \BristolSU\Support\ActivityInstance\Middleware\CheckLoggedIntoActivityInstance::class,

        // Check the logged in Activity Instance belongs to the activity
        \BristolSU\Support\ActivityInstance\Middleware\CheckActivityInstanceForActivity::class,

        // Check the logged in activity instance belongs to the thing the user is logged in as
        \BristolSU\Support\ActivityInstance\Middleware\CheckActivityInstanceAccessible::class,

        // Check the user is logged into the correct model to use the activity
        \BristolSU\Support\Authorization\Middleware\CheckLoggedIntoActivityForType::class,

        // Check the user is in the activity for logic group
        \BristolSU\Support\Authorization\Middleware\CheckActivityFor::class,

        // Authorization middleware for use with can:
        Authorize::class,


        /*
         * Response Middleware
         */

        // Set cache headers on the response
        SetCacheHeaders::class,

        // Add queued cookies to response
        AddQueuedCookiesToResponse::class,


    ];
}
