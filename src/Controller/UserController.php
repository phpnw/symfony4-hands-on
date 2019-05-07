<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    }
}
