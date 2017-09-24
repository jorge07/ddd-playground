<?php

namespace Tests\Leos\Infrastructure\UserBundle\Factory\Form;

use Lakion\ApiTestCase\ApiTestCase;
use Leos\Domain\User\Model\User;
use Leos\Infrastructure\UserBundle\Factory\Form\ChangePasswordType;
use Tests\Leos\Domain\User\Model\UserTest;

class ChangePasswordTypeTest extends ApiTestCase
{

    public function setUp()
    {
        parent::setUp();

        self::createClient();
    }

    public function testChangePassword()
    {
        $user = UserTest::create();

        $originalPass = $user->auth()->password();

        $form = $this->client->getContainer()->get('form.factory')->create(ChangePasswordType::class, $user);

        $form->submit(['oldPassword' => 'iyoquease', 'newPassword' => 'iyoquease2']);
        /** @var User $user */
        $user = $form->getData();

        self::assertNotEquals($user->auth()->password(), $originalPass);
    }
}
