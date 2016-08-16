<?php

namespace Leos\UI\RestBundle\Controller\Wallet;

use Leos\Application\DTO\Wallet\DebitDTO;
use Leos\Application\DTO\Wallet\CreditDTO;
use Leos\Application\DTO\Wallet\CreateWalletDTO;
use Leos\Application\UseCase\Wallet\WalletManager;
use Leos\UI\RestBundle\Controller\AbstractController;

use Leos\Domain\Wallet\Exception\Credit\CreditNotEnoughException;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Wallet\Exception\Wallet\WalletNotFoundException;

use Leos\Infrastructure\Common\Exception\Form\FormException;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class WalletController
 *
 * @package Leos\UI\RestBundle\Controller\Wallet
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
     *     resource = true,
     *     section="Wallet",
     *     description = "Create a new Wallet",
     *     output = "Leos\Domain\Wallet\Model\Wallet",
     *     statusCodes = {
     *       201 = "Returned when successful"
     *     }
     * )
     *
     * @RequestParam(name="real", default="0", description="Initial real Credit in wallet")
     * @RequestParam(name="bonus", default="0", description="Initial bonus Credit in wallet")
     *
     * @View(statusCode=201)
     *
     * @param ParamFetcher $fetcher
     *
     * @return Wallet
     */
    public function postAction(ParamFetcher $fetcher)
    {
        try {
            $wallet = $this->walletManager->create(
                new CreateWalletDTO(
                    (int) $fetcher->get('real'),
                    (int) $fetcher->get('bonus')
                )
            );

            return $this->routeRedirectView('get_wallet', [ 'walletId' => $wallet->id() ]);

        } catch (FormException $e) {

            return $e->getForm();
        }
    }

    /**
     * @ApiDoc(
     *     resource = true,
     *     section="Wallet",
     *     description = "Gets a wallet for the given identifier",
     *     output = "Leos\Domain\Wallet\Model\Wallet",
     *     statusCodes = {
     *       201 = "Returned when successful",
     *       404 = "Returned when not found"
     *     }
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

    /**
     * @ApiDoc(
     *     resource = true,
     *     section="Wallet",
     *     description = "Generate a positive insertion on the given Wallet",
     *     output = "Leos\Domain\Wallet\Model\Wallet",
     *     statusCodes = {
     *       202 = "Returned when successful"
     *     }
     * )
     *
     * @RequestParam(name="real", default="0", description="Real amount to credit")
     * @RequestParam(name="bonus", default="0", description="Bonus amount to credit")
     * @RequestParam(name="currency", default="EUR", description="Currency")
     *
     * @View(statusCode=202, serializerGroups={"Identifier", "Basic"})
     *
     * @param string $uid
     * @param ParamFetcher $fetcher
     *
     * @return Wallet
     */
    public function postCreditAction(string $uid, ParamFetcher $fetcher)
    {
        try {
            return $this->walletManager->credit(
                new CreditDTO(
                    new WalletId($uid),
                    new Currency($fetcher->get('currency')),
                    (float) $fetcher->get('real'),
                    (float) $fetcher->get('bonus')
                )
            );
            
        } catch (WalletNotFoundException $e) {

            throw new NotFoundHttpException($e->getMessage(), $e, $e->getCode());

        }
    }

    /**
     * @ApiDoc(
     *     resource = true,
     *     section="Wallet",
     *     description = "Generate a negative insertion on the given Wallet",
     *     output = "Leos\Domain\Wallet\Model\Wallet",
     *     statusCodes = {
     *       202 = "Returned when successful"
     *     }
     * )
     *
     * @RequestParam(name="real", default="0", description="Real amount to credit")
     * @RequestParam(name="bonus", default="0", description="Bonus amount to credit")
     * @RequestParam(name="currency", default="EUR", description="Currency")
     *
     * @View(statusCode=202, serializerGroups={"Identifier", "Basic"})
     *
     * @param string $uid
     * @param ParamFetcher $fetcher
     *
     * @return Wallet
     */
    public function postDebitAction(string $uid, ParamFetcher $fetcher)
    {
        try {

            return $this->walletManager->debit(
                new DebitDTO(
                    new WalletId($uid),
                    new Currency($fetcher->get('currency')),
                    (float) $fetcher->get('real'),
                    (float) $fetcher->get('bonus')
                )
            );

        } catch (WalletNotFoundException $e) {

            throw new NotFoundHttpException($e->getMessage(), $e, $e->getCode());

        } catch (CreditNotEnoughException $e) {

            throw new ConflictHttpException($e->getMessage(), $e, $e->getCode());
        }
    }
}
