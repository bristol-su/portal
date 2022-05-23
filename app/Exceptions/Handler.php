<?php

namespace App\Exceptions;

use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceResolver;
use BristolSU\Support\ActivityInstance\Contracts\DefaultActivityInstanceGenerator;
use BristolSU\Support\ActivityInstance\Exceptions\NotInActivityInstanceException;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\Authentication\Contracts\ResourceIdGenerator;
use BristolSU\Support\Authorization\Exception\ActivityDisabled;
use BristolSU\Support\Authorization\Exception\ActivityRequiresAdmin;
use BristolSU\Support\Authorization\Exception\ActivityRequiresGroup;
use BristolSU\Support\Authorization\Exception\ActivityRequiresParticipant;
use BristolSU\Support\Authorization\Exception\ActivityRequiresRole;
use BristolSU\Support\Authorization\Exception\ActivityRequiresUser;
use BristolSU\Support\Authorization\Exception\IncorrectLogin;
use BristolSU\Support\Authorization\Exception\ModuleInactive;
use BristolSU\Support\Authorization\Exception\ModuleInstanceDisabled;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ActivityRequiresParticipant::class,
        ActivityRequiresAdmin::class,
        NotInActivityInstanceException::class,

        ModuleInactive::class,
        ActivityDisabled::class,
        ModuleInstanceDisabled::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function __construct(Container $container)
    {
        unset($this->dontReport[array_search(ModelNotFoundException::class, $this->dontReport)]);
        
        parent::__construct($container);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (ActivityRequiresParticipant $exception, Request $request) {
            if($request->expectsJson()) {
                return response()->json(['message' => 'You do not have access in your current role.'], $exception->getCode());
            }
            return redirect()->route('login.participant', [
                'activity_slug' => $exception->getActivity()->slug,
                'redirect' => $request->fullUrl()
            ]);
        });
        $this->renderable(function (ActivityRequiresAdmin $exception, Request $request) {
            if($request->expectsJson()) {
                return response()->json(['message' => 'You do not have access to the admin side in your current role.'], $exception->getCode());
            }
            return redirect()->route('login.admin', [
                'activity_slug' => $exception->getActivity()->slug,
                'redirect' => $request->fullUrl()
            ]);
        });
        $this->renderable(function (ModuleInactive $exception, Request $request) {
            if($request->expectsJson()) {
                return response()->json(['message' => 'This module is currently locked for you.'], $exception->getCode());
            }
        });
        $this->renderable(function (NotInActivityInstanceException $exception, Request $request) {
            if($request->expectsJson()) {
                return response()->json(['message' => 'You must be in an activity instance to access this page.'], $exception->getCode());
            }
            $activity = $request->route('activity_slug');
            try {
                $activityInstance = app(DefaultActivityInstanceGenerator::class)
                    ->generate(
                        $activity,
                        $activity->activity_for,
                        app(ResourceIdGenerator::class)->fromString($activity->activity_for)
                    );
            } catch (Exception $e) {
                if($activity->activity_for === 'user') {
                    throw new ActivityRequiresUser('', 0, null, $activity);
                }
                if($activity->activity_for === 'group') {
                    throw new ActivityRequiresGroup('', 0, null, $activity);
                }
                if($activity->activity_for === 'role') {
                    throw new ActivityRequiresRole('', 0, null, $activity);
                }
            }
            app(ActivityInstanceResolver::class)->setActivityInstance($activityInstance);
            return redirect()->to($request->fullUrl());
        });
        $this->renderable(function (ActivityDisabled $exception, Request $request) {
            if($request->expectsJson()) {
                return response()->json(['message' => sprintf('%s has been disabled', $exception->activity()->name)], $exception->getCode());
            }
        });
        $this->renderable(function (ModuleInstanceDisabled $exception, Request $request) {
            if($request->expectsJson()) {
                return response()->json(['message' => 'This module has been disabled.'], $exception->getCode());
            }
        });
        $this->renderable(function (IncorrectLogin $exception, Request $request) {
            if($request->expectsJson()) {
                return response()->json(['message' => 'You do not have access to the credentials you are using.'], $exception->getCode());
            }
        });
    }

    protected function getHttpExceptionView(HttpExceptionInterface $e)
    {
        return 'errors.error';
    }

    /**
     * Get the default context variables for logging.
     *
     * @return array
     */
    protected function context()
    {
        $context = [];
        try {
            $auth = app(Authentication::class);
        } catch (BindingResolutionException $e) {
            // Exception occured before auth could be registered, so ignore the context.
            return parent::context();
        }
        if($auth->hasUser()) {
            $context['control_user_id'] = $auth->getUser()->id();
        }
        if($auth->hasGroup()) {
            $context['control_group_id'] = $auth->getGroup()->id();
        }
        if($auth->hasRole()) {
            $context['control_role_id'] = $auth->getRole()->id();
        }
        return array_merge(parent::context(), $context);
    }
}
