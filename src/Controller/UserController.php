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
     * @Route("/", methods={"POST"})
     */
    public function createAction(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, UserRepository $userRepository)
    {
        $data = $request->request;

        $username = $data->get('username');
        $existing_user = $userRepository->getUserByUsername($username);

        if ($existing_user !== null) {
            return new JsonResponse(['error' => "User with name $username already exists"], Response::HTTP_BAD_REQUEST);
        }

        $password = $data->get('password');
        $hashed = \password_hash($password, \PASSWORD_DEFAULT);

        $data->set('hashedPassword', $hashed);
        $data->remove('password');

        $json_encode = \json_encode($data->all());
        $user = $serializer->deserialize($json_encode, User::class, 'json');

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse($serializer->serialize($user, 'json'), Response::HTTP_CREATED, [], true);
    }

    /**
     * @param string $username
     * @param UserRepository $userRepository
     * @Route("/{username}", methods={"GET"})
     */
    public function getAction(string $username, UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        $user = $userRepository->getUserByUsername($username);

        if (null !== $user) {
            return new JsonResponse($serializer->serialize($user, 'json'), Response::HTTP_OK, [], true);
        }

        throw new NotFoundHttpException();
    }

    /**
     * @param Request $request
     * @param EntityManager $entityManager
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route("/{username}", methods={"PATCH"})
     */
    public function updateAction($username, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $user = $userRepository->getUserByUsername($username);

        if ($user === null) {
            return new JsonResponse(['error' => "User not found with name $username"], Response::HTTP_NOT_FOUND);
        }

        $data = $request->request;
        $user->setBio($data->get('bio'));

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse($serializer->serialize($user, 'json'), Response::HTTP_OK, [], true);
    }
}
