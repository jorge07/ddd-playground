<?php

namespace Leos\UI\RestBundle\Controller\Rollback;

use League\Tactician\CommandBus;
use Leos\UI\RestBundle\Controller\AbstractController;

use Leos\Application\UseCase\Transaction\Request\RollbackDeposit as RollbackDepositRequest;
use Leos\Application\UseCase\Transaction\Request\RollbackWithdrawal as RollbackWithdrawalRequest;

use Leos\Domain\Payment\Model\RollbackDeposit;
use Leos\Domain\Payment\Model\RollbackWithdrawal;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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
class RollbackController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * RollbackController constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }
    
    /**
     * @ApiDoc(
     *     resource = true,
     *     section="Rollback",
     *     description = "Rollback the given deposit",
     *     statusCodes = {
     *       200 = "Returned when successful",
     *       400 = "Returned when Bad request",
     *       404 = "Returned when not found"
     *     }
     * )
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
        return $this->commandBus->handle(
            new RollbackDepositRequest($fetcher->get('deposit'))
        );
    }

    /**
     * @ApiDoc(
     *     resource = true,
     *     section="Rollback",
     *     description = "Rollback the given withdrawal",
     *     statusCodes = {
     *       200 = "Returned when successful",
     *       400 = "Returned when Bad request",
     *       404 = "Returned when not found"
     *     }
     * )
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
        return $this->commandBus->handle(
            new RollbackWithdrawalRequest($fetcher->get('withdrawal'))
        );
    }
}
