<?php

namespace Leos\Application\RestBundle\Controller\Wallet;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Leos\Domain\Wallet\Exception\Wallet\WalletNotFoundException;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\UseCase\WalletManager;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Infrastructure\Common\Exception\Form\FormException;
use Leos\Infrastructure\WalletBundle\DTO\CreateWalletDTO;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Leos\Application\RestBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class WalletController
 *
 * @package Leos\Application\RestBundle\Controller\Wallet
 *
 * @RouteResource("Wallet", pluralize=false)
 */
class WalletController extends AbstractController
{
    /**
     * @var WalletManager
     */
    private $walletManager;

    /**
     * WalletController constructor.
     * @param WalletManager $walletManager
     */
    public function __construct(WalletManager $walletManager)
    {
        $this->walletManager = $walletManager;
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Create a new Wallet",
     *   output = "Leos\Domain\Wallet\Model\Wallet",
     *   statusCodes = {
     *     201 = "Returned when successful"
     *   }
     * )
     *
     * @RequestParam(name="real", default="0", description="Initial real balance wallet")
     * @RequestParam(name="bonus", default="0", description="Initial bonus balance wallet")
     *
     * @View(statusCode=201, serializerGroups={"Identifier", "Basic"})
     *
     * @param ParamFetcher $fetcher
     *
     * @return Wallet
     */
    public function postAction(ParamFetcher $fetcher)
    {
        try {

            $wallet = $this->walletManager->create(
                new CreateWalletDTO((int) $fetcher->get('real'), (int) $fetcher->get('bonus'))
            );

            return $this->routeRedirectView('get_wallet', [
                'walletId' => $wallet->id()
            ]);

        } catch (FormException $e) {

            return $e->getForm();
        }
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a wallet for the given identifier",
     *   output = "Leos\Domain\Wallet\Model\Wallet",
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when bad request",
     *     404 = "Returned when not found"
     *   }
     * )
     *
     * @View(statusCode=200)
     *
     * @param string $walletId
     * @return Wallet
     */
    public function getAction(string $walletId): Wallet
    {
        try {

            return $this->walletManager->get(new WalletId($walletId));

        } catch (WalletNotFoundException $e) {

            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
