<?php

namespace App\Identity\Infrastructure\Http\Controller;

use App\Identity\Infrastructure\Persistence\Doctrine\UserRecord;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginUserController extends AbstractController
{
    #[Route('/auth/login', name: 'login', methods: ['POST'])]
    public function __invoke(#[CurrentUser] ?UserRecord $userRecord): JsonResponse
    {
        if (null === $userRecord) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse(['status' => 'ok'], 200);
    }
}
