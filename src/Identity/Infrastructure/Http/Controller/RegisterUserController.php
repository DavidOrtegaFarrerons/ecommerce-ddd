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
            return new JsonResponse(['error' => 'No JSON Data was provided'], 400);
        }

        if (!isset($data['email'], $data['password'], $data['firstName'], $data['lastName']) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        $email     = $data['email'];
        $password  = $data['password'];
        $firstName = $data['firstName'];
        $lastName  = $data['lastName'];

        $command = new RegisterUserCommand($email, $firstName, $lastName, $password);
        $this->commandBus->handle($command);

        return new JsonResponse(['status' => 'ok'], 201);
    }
}
