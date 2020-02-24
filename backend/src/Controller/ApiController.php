<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api")
 */
class ApiController  extends AbstractController
{

    /**
     * @Route("/hello", name="api_hello")
     */
    public function hello(): Response
    {
        return new JsonResponse(['hello' => 'world']);
    }

}