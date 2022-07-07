<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Actions\Auth\RegisterRequest;
use App\Mail\WelcomeEmail;
use App\Repository\UserRepository;
use Illuminate\Mail\Mailer;

final class RegisterAction
{
    public function __construct(private UserRepository $userRepository, private Mailer $mailer)
    {
    }

    public function execute(RegisterRequest $request): AuthenticationResponse
    {
        $user = $this->userRepository->create([
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
            'name' => $request->getName(),
            'lastname' => $request->getLastName(),
            'phone' => $request->getPhone()
        ]);
        $token = auth()->login($user);

        $this->mailer->to($user)->send(new WelcomeEmail());

        return new AuthenticationResponse(
            $token,
            'bearer',
            auth()->factory()->getTTL() * 60
        );
    }
}
