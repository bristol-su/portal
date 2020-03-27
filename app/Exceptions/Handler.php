<?php

namespace App\Exceptions;

use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceResolver;
use BristolSU\Support\ActivityInstance\Contracts\DefaultActivityInstanceGenerator;
use BristolSU\Support\ActivityInstance\Exceptions\NotInActivityInstanceException;
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
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        ModuleInactive::class,
        NotInActivityInstanceException::class,
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

    /**
     * Report or log an exception.
     *
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * - Redirect to participant login page if $e instance of ActivityRequiresParticipant
     * - Redirect to admin login page if $e instance of ActivityRequiresAdmin
     * - Return a 403 HttpException if $e instanceof ModuleInactive
     * - Log into the default activity instance if possible if $e instanceof NotInActivityInstanceException
     *
     * @param Request $request
     * @param Exception $exception
     * @return Response|RedirectResponse|JsonResponse
     * @throws ActivityRequiresGroup
     * @throws ActivityRequiresRole
     * @throws ActivityRequiresUser
     */
    public function render($request, Exception $exception)
    {
        if (!$request->expectsJson()) {

            if ($exception instanceof ActivityRequiresParticipant) {
                return redirect()->route('login.participant', [
                    'activity_slug' => $exception->getActivity()->slug,
                    'redirect' => $request->fullUrl()
                ]);
            }
            if($exception instanceof ActivityRequiresAdmin) {
                return redirect()->route('login.admin', [
                    'activity_slug' => $exception->getActivity()->slug,
                    'redirect' => $request->fullUrl()
                ]);
            }

            if($exception instanceof ModuleInactive) {
                abort(403);
            }
            if($exception instanceof NotInActivityInstanceException) {
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
            }
            if($exception instanceof ActivityDisabled) {
                return response()->view('errors.activity_disabled', ['activity' => $exception->activity()]);
            } if($exception instanceof ModuleInstanceDisabled) {
                return response()->view('errors.module_instance_disabled', ['moduleInstance' => $exception->moduleInstance()]);
            }
        } else {
            if($exception instanceof IncorrectLogin) {
                return response()->json(['message' => $exception->getMessage()], $exception->getStatusCode());
            }
        }

        // TODO Handle exceptions above if expects json

        return parent::render($request, $exception);
    }
}
