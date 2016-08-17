<?php

namespace Leos\UI\RestBundle\Controller\Wallet;

use Leos\Domain\Common\Exception\InvalidUUIDException;
use Leos\UI\RestBundle\Controller\AbstractController;

use Leos\Application\DTO\Wallet\DebitDTO;
use Leos\Application\DTO\Wallet\CreditDTO;
use Leos\Application\DTO\Common\PaginationDTO;
use Leos\Application\DTO\Wallet\CreateWalletDTO;
use Leos\Application\UseCase\Wallet\WalletManager;

use Leos\Domain\Wallet\Exception\Credit\CreditNotEnoughException;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Wallet\Exception\Wallet\WalletNotFoundException;

use Leos\Infrastructure\Common\Pagination\PagerTrait;
use Leos\Infrastructure\Common\Exception\Form\FormException;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Hateoas\Representation\PaginatedRepresentation;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
    use PagerTrait;

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
     *     description = "List wallet collection",
     *     output = "Leos\Domain\Wallet\Model\Wallet",
     *     statusCodes = {
     *       201 = "Returned when successful",
     *       400 = "Returned when Bad Request",
     *       404 = "Returned when page not found"
     *     }
     * )
     *
     * @QueryParam(
     *     name="page",
     *     default="1",
     *     description="Page Number"
     * )
     * @QueryParam(
     *     name="limit",
     *     default="500",
     *     description="Items per page"
     * )
     *
     * @QueryParam(
     *     name="orderParameter",
     *     nullable=true,
     *     requirements="(real.amount|bonus.amount|createdAt|updatedAt)",
     *     map=true,
     *     description="Order Parameter"
     * )
     *
     * @QueryParam(
     *     name="orderValue",
     *     nullable=true,
     *     requirements="(ASC|DESC)",
     *     map=true,
     *     description="Order Value"
     * )
     *
     * @QueryParam(
     *     name="filterParam",
     *     nullable=true,
     *     requirements="(real.amount|bonus.amount|createdAt|updatedAt)",
     *     strict=true,
     *     map=true,
     *     description="Keys to filter"
     * )
     *
     * @QueryParam(
     *     name="filterOp",
     *     nullable=true,
     *     requirements="(gt|gte|lt|lte|eq|like|between)",
     *     strict=true,
     *     map=true,
     *     description="Operators to filter"
     * )
     *
     * @QueryParam(
     *     name="filterValue",
     *     map=true,
     *     description="Values to filter"
     * )
     *
     * @View(statusCode=200, serializerGroups={"Default", "Identifier", "Basic"})
     *
     * @param ParamFetcher $fetcher
     *
     * @return PaginatedRepresentation
     */
    public function cgetAction(ParamFetcher $fetcher): PaginatedRepresentation
    {
        $dto = new PaginationDTO($fetcher->all());

        return $this->getPagination(
            $this->walletManager->find($dto),
            'cget_wallet',
            [],
            $dto->getLimit(),
            $dto->getPage()
        );
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
     * @View(statusCode=200, serializerGroups={"Identifier", "Basic"})
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
            
        } catch (InvalidUUIDException $e) {

            throw new BadRequestHttpException($e->getMessage(), $e, $e->getCode());

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

        } catch (InvalidUUIDException $e) {

            throw new BadRequestHttpException($e->getMessage(), $e, $e->getCode());

        } catch (WalletNotFoundException $e) {

            throw new NotFoundHttpException($e->getMessage(), $e, $e->getCode());

        } catch (CreditNotEnoughException $e) {

            throw new ConflictHttpException($e->getMessage(), $e, $e->getCode());
        }
    }
}
