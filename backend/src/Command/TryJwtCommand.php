<?php

namespace App\Command;

use GuzzleHttp\Client;
use Lcobucci\JWT\Signer\Key;
use Study\Credential\Domain\Model\KeyGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TryJwtCommand extends Command
{
    protected static $defaultName = 'study:try-jwt';

    protected function configure()
    {
        $this
            ->setDescription('Try to get a jwt token and access to an endpoint');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://web',
            // You can set any number of default request options.
            'timeout' => 2.0,
        ]);

        $keyGenerator = new KeyGenerator();

        $response = $client->post('/api/login_check', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'username' => $keyGenerator->generate('a_seed'),
                'password' => $keyGenerator->generate('a_seed')
            ])
        ]);

        $body = (string)$response->getBody();

        $data = json_decode($body, true);

        $token = $data['token'];


        $response = $client->get('/api/hello', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]);


        $io = new SymfonyStyle($input, $output);

        $io->writeln($response->getBody());

        return 0;
    }
}
