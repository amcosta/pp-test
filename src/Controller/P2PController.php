<?php

namespace App\Controller;

use App\Entity\P2PTransaction;
use App\Form\P2PTransactionType;
use App\Services\MakeP2PTransfer;
use PHPUnit\TextUI\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route(path="/api/p2p-transfer")
 */
class P2PController extends AbstractController
{
    /**
     * @var Security
     */
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route(methods={"POST"}, name="api.p2p-transfer.make-transfer")
     */
    public function makeTransfer(Request $request, MakeP2PTransfer $service)
    {
        $transaction = new P2PTransaction();
        $transaction->setPayer($this->security->getUser());

        $form = $this->createForm(P2PTransactionType::class, $transaction);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }

        try {
            $service->execute($transaction);
            return new JsonResponse([], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return new JsonResponse([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }
}
