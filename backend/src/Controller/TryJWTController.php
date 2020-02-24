<?php

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TryJWTController extends AbstractController
{

    /**
     * @Route("/try-jwt/get-token", name="home")
     */
    public function getToken(): Response
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://web',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        $response = $client->post('/api/login_check',[
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'username' => 'mario@example.com',
                'password' => 'password'
            ])
        ]);

        $body = json_encode((string)$response->getBody(), true);


        return $this->render('try-jwt/get-token.html.twig', ['body' => $body]);
    }


}