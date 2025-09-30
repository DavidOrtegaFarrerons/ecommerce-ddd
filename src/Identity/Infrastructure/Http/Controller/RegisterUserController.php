<?php

namespace App\Identity\Infrastructure\Http\Controller;

use App\Identity\Application\Service\RegisterUserCommand;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

readonly class RegisterUserController
{

    public function __construct(private CommandBus $commandBus)
    {
    }

    #[Route('/auth/register', name: 'register', methods: ['POST'])]
    public function __invoke(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return new JsonResponse(['error' => 'Invalid JSON'], 400);
        }

        $email     = $data['email']     ?? null;
        $password  = $data['password']  ?? null;
        $firstName = $data['firstName'] ?? null;
        $lastName  = $data['lastName']  ?? null;

        $command = new RegisterUserCommand($email, $firstName, $lastName, $password);
        $this->commandBus->handle($command);

        return new JsonResponse(['status' => 'ok'], 201);
    }
}
