<?php

namespace Tests\Leos\UI\RestBundle\Controller\Security;

use Leos\Domain\User\Model\User;

/**
 * Class SecurityTrait
 *
 * @package Leos\UI\RestBundle\Controller\Security
 */
trait SecurityTrait
{
    /**
     * @var string
     */
    protected $accessToken = [];

    /**
     * @var User[]
     */
    protected $users = [];

    /**
     * @param string $username
     * @param string $password
     * @param bool $fixture
     *
     */
    public function loginClient(string $username, string $password, bool $fixture = true)
    {
        if (!isset($this->accessToken[$username])) {

            if ($fixture) {
                $this->users = $this->loadFixturesFromDirectory('user');
            }

            $this->client->request('POST', '/auth/login.json', [
                '_username' => $username,
                '_password' => $password
            ]);

             $response =  $this->client->getResponse();

            self::assertResponseCode($response, 200);

            $data = json_decode($response->getContent(), true);

            $this->accessToken[$username] = $data['token'];
        }

        $this->client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $this->accessToken[$username]));
    }

}
