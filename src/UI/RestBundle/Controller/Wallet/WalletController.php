<?php

namespace Leos\UI\RestBundle\Controller\Wallet;

use Leos\Domain\Payment\Model\Deposit;
use Leos\Infrastructure\CommonBundle\Exception\Form\FormException;
use Leos\UI\RestBundle\Controller\AbstractBusController;

use Leos\Application\UseCase\Wallet\Request\Find;
use Leos\Application\UseCase\Wallet\Request\GetWallet;
use Leos\Application\UseCase\Transaction\Request\CreateDeposit;
use Leos\Application\UseCase\Transaction\Request\Withdrawal;
use Leos\Application\UseCase\Transaction\Request\CreateWallet;


use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Payment\Model\Withdrawal as WithdrawalModel;
use Leos\Infrastructure\CommonBundle\Pagination\PagerTrait;

use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

use Hateoas\Representation\PaginatedRepresentation;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;

use Symfony\Component\Form\Form;

/**
 * Class WalletController
 *
 * @package Leos\UI\RestBundle\Controller\Wallet
 *
 * @RouteResource("Wallet", pluralize=false)
 */
class WalletController extends AbstractBusController
{
    use PagerTrait;

    /**
     * @Operation(
     *     tags={"Wallet"},
     *     summary="List wallet collection",
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page Number",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Items per page",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="orderParameter",
     *         in="query",
     *         description="Order Parameter",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="orderValue",
     *         in="query",
     *         description="Order Value",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="filterParam",
     *         in="query",
     *         description="Keys to filter",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="filterOp",
     *         in="query",
     *         description="Operators to filter",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="filterValue",
     *         in="query",
     *         description="Values to filter",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when Bad Request"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when page not found"
     *     )
     * )
     *
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
        $request = new Find($fetcher->all());

        return $this->getPagination(
            $this->ask($request),
            'cget_wallet',
            [],
            $request->getLimit(),
            $request->getPage()
        );
    }

    /**
     * @Operation(
     *     tags={"Wallet"},
     *     summary="Gets a wallet for the given identifier",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when not found"
     *     )
     * )
     *
     *
     * @View(statusCode=200, serializerGroups={"Identifier", "Basic"})
     *
     * @param string $walletId
     *
     * @return Wallet
     */
    public function getAction(string $walletId): Wallet
    {
        return $this->ask(new GetWallet($walletId));
    }

    /**
     * @Operation(
     *     tags={"Wallet"},
     *     summary="Create a new Wallet",
     *     @SWG\Parameter(
     *         name="userId",
     *         in="formData",
     *         description="The user identifier",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="currency",
     *         in="formData",
     *         description="The currency of the wallet",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Returned when successful"
     *     )
     * )
     *
     *
     * @RequestParam(name="userId",   default="none", description="The user identifier")
     * @RequestParam(name="currency", default="EUR",  description="The currency of the wallet")
     *
     * @View(statusCode=201)
     *
     * @param ParamFetcher $fetcher
     *
     * @return \FOS\RestBundle\View\View|Form
     */
    public function postAction(ParamFetcher $fetcher)
    {
        try {
            /** @var Wallet $wallet */
            $wallet = $this->handle(
                new CreateWallet(
                    $fetcher->get('userId'),
                    $fetcher->get('currency')
                )
            );
        } catch (FormException $exception) {

            return $exception->getForm();
        }

        return $this->routeRedirectView('get_wallet', [ 'walletId' => $wallet->id() ]);
    }

    /**
     * @Operation(
     *     tags={"Wallet"},
     *     summary="Generate a positive insertion on the given Wallet",
     *     @SWG\Parameter(
     *         name="real",
     *         in="formData",
     *         description="Deposit amount",
     *         required=false,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="currency",
     *         in="formData",
     *         description="Currency",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="provider",
     *         in="formData",
     *         description="Payment provider",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="202",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when bad request"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when wallet not found"
     *     )
     * )
     *
     *
     * @RequestParam(name="real",     default="0",   description="Deposit amount")
     * @RequestParam(name="currency", default="EUR", description="Currency")
     * @RequestParam(name="provider", default="", description="Payment provider")
     *
     * @View(statusCode=202, serializerGroups={"Identifier", "Basic"})
     *
     * @param string $uid
     * @param ParamFetcher $fetcher
     *
     * @return Deposit
     */
    public function postDepositAction(string $uid, ParamFetcher $fetcher): Deposit
    {
        return $this->handle(
            new CreateDeposit(
                $uid,
                $fetcher->get('currency'),
                (float) $fetcher->get('real'),
                $fetcher->get('provider')
            )
        );
    }

    /**
     * @Operation(
     *     tags={"Wallet"},
     *     summary="Generate a negative insertion on the given Wallet",
     *     @SWG\Parameter(
     *         name="real",
     *         in="formData",
     *         description="Withdrawal amount",
     *         required=false,
     *         type="number"
     *     ),
     *     @SWG\Parameter(
     *         name="currency",
     *         in="formData",
     *         description="Currency",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="provider",
     *         in="formData",
     *         description="Payment provider",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="202",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when bad request"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when wallet not found"
     *     ),
     *     @SWG\Response(
     *         response="409",
     *         description="Returned when not enough founds"
     *     )
     * )
     *
     *
     * @RequestParam(name="real",     default="0",  description="Withdrawal amount")
     * @RequestParam(name="currency", default="EUR", description="Currency")
     * @RequestParam(name="provider", default="", description="Payment provider")
     *
     * @View(statusCode=202, serializerGroups={"Identifier", "Basic"})
     *
     * @param string $uid
     * @param ParamFetcher $fetcher
     *
     * @return WithdrawalModel
     */
    public function postWithdrawalAction(string $uid, ParamFetcher $fetcher): WithdrawalModel
    {
        return $this->handle(
            new Withdrawal(
                $uid,
                $fetcher->get('currency'),
                (float) $fetcher->get('real'),
                $fetcher->get('provider')
            )
        );
    }
}
