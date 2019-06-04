<?php


namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * Class UserController
 * @package App\Controller
 * @Route("/users")
 */
class UserController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @Route("/create")
     */
    public function createAction(Request $request, EntityManagerInterface $entityManager)
    {
        $data = $request->request;
    /**
     * @param string $username
     * @param UserRepository $userRepository
     * @Route("/{username}")
     */
    public function getAction(string $username, UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        $user = $userRepository->getUserByUsername($username);

        if (null !== $user) {
            return new JsonResponse($serializer->serialize($user, 'json'), 200, [], true);
        }

        throw new NotFoundHttpException();
    }
}
