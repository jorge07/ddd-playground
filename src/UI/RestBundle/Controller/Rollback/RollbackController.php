<?php

namespace Leos\UI\RestBundle\Controller\Rollback;

use Leos\UI\RestBundle\Controller\AbstractBusController;

use Leos\Application\UseCase\Transaction\Request\RollbackDeposit as RollbackDepositRequest;
use Leos\Application\UseCase\Transaction\Request\RollbackWithdrawal as RollbackWithdrawalRequest;

use Leos\Domain\Payment\Model\RollbackDeposit;
use Leos\Domain\Payment\Model\RollbackWithdrawal;

use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/**
 * Class RollbackController
 *
 * @package Leos\UI\RestBundle\Controller\Rollback
 *
 * @RouteResource("Rollback", pluralize=false)
 */
class RollbackController extends AbstractBusController
{
    /**
     * @Operation(
     *     tags={"Rollback"},
     *     summary="Rollback the given deposit",
     *     @SWG\Parameter(
     *         name="deposit",
     *         in="formData",
     *         description="Deposit identifier",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="202",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when Bad request"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when not found"
     *     )
     * )
     *
     *
     * @RequestParam(name="deposit", description="Deposit identifier")
     *
     * @View(statusCode=202, serializerGroups={"Identifier", "Basic"})
     *
     * @param ParamFetcher $fetcher
     *
     * @return RollbackDeposit
     */
    public function postDepositAction(ParamFetcher $fetcher): RollbackDeposit
    {
        return $this->handle(
            new RollbackDepositRequest($fetcher->get('deposit'))
        );
    }

    /**
     * @Operation(
     *     tags={"Rollback"},
     *     summary="Rollback the given withdrawal",
     *     @SWG\Parameter(
     *         name="withdrawal",
     *         in="formData",
     *         description="Withdrawal identifier",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="202",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when Bad request"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when not found"
     *     )
     * )
     *
     *
     * @RequestParam(name="withdrawal", description="Withdrawal identifier")
     *
     * @View(statusCode=202, serializerGroups={"Identifier", "Basic"})
     *
     * @param ParamFetcher $fetcher
     *
     * @return RollbackWithdrawal
     */
    public function postWithdrawalAction(ParamFetcher $fetcher): RollbackWithdrawal
    {
        return $this->handle(
            new RollbackWithdrawalRequest($fetcher->get('withdrawal'))
        );
    }
}
