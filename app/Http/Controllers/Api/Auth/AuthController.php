<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\RegisterRequest;
use App\Http\Controllers\Api\ApiController;
use App\Http\Presenters\AuthenticationResponseArrayPresenter;
use App\Http\Request\Api\Auth\RegisterHttpRequest;
use App\Http\Response\ApiResponse;
use Illuminate\Http\Request;

final class AuthController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(
        RegisterHttpRequest $httpRequest,
        RegisterAction $action,
        AuthenticationResponseArrayPresenter $authenticationResponseArrayPresenter
    ): ApiResponse {
        $request = new RegisterRequest(
            $httpRequest->get('email'),
            $httpRequest->get('password'),
            $httpRequest->get('name'),
            $httpRequest->get('lastname'),
            $httpRequest->get('phone')
        );
        $response = $action->execute($request);

        return $this->createSuccessResponse($authenticationResponseArrayPresenter->present($response));
    }

    public function login(
        LoginHttpRequest $httpRequest,
        LoginAction $action,
        AuthenticationResponseArrayPresenter $authenticationResponseArrayPresenter
    ): ApiResponse {
        $request = new LoginRequest(
            $httpRequest->email,
            $httpRequest->password
        );
        $response = $action->execute($request);

        return $this->createSuccessResponse($authenticationResponseArrayPresenter->present($response));
    }
/*
    public function me(GetAuthenticatedUserAction $action, UserArrayPresenter $userArrayPresenter): ApiResponse
    {
        $response = $action->execute();

        return $this->createSuccessResponse($userArrayPresenter->present($response->getUser()));
    }

    public function logout(LogoutAction $action): ApiResponse
    {
        $action->execute();

        return $this->createEmptyResponse();
    }

    public function update(
        UpdateProfileHttpRequest $httpRequest,
        UpdateProfileAction $action,
        UserArrayPresenter $userArrayPresenter
    ): ApiResponse {
        $response = $action->execute(
            new UpdateProfileRequest(
                $httpRequest->get('email'),
                $httpRequest->get('first_name'),
                $httpRequest->get('last_name'),
                $httpRequest->get('nickname')
            )
        );

        return $this->createSuccessResponse($userArrayPresenter->present($response->getUser()));
    }

    public function uploadProfileImage(
        UploadProfileImageHttpRequest $httpRequest,
        UploadProfileImageAction $action,
        UserArrayPresenter $userArrayPresenter
    ): ApiResponse {
        $response = $action->execute(
            new UploadProfileImageRequest(
                $httpRequest->file('image')
            )
        );

        return $this->createSuccessResponse($userArrayPresenter->present($response->getUser()));
    }

    public function resetPassword(ResetPasswordHttpRequest $request, ResetPasswordAction $action)
    {
        return $this->createSuccessResponse($action->execute($request));
    }

    public function applyNewPassword(ApplyNewPasswordHttpRequest $request, ApplyNewPasswordAction $action)
    {
        return $this->createSuccessResponse($action->execute($request));
    }
*/
}
