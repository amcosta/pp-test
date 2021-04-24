<?php

namespace App\Controller;

use App\Entity\P2PTransaction;
use App\Form\P2PTransactionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route(path="/api/p2p-transfer")
 */
class P2PTransferController extends AbstractController
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
    public function makeTransfer(Request $request)
    {
        $transaction = new P2PTransaction();
        $transaction->setPayer($this->security->getUser());

        $form = $this->createForm(P2PTransactionType::class, $transaction);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $transaction = $form->getData();
            return $this->json(['name' => $transaction->getAmount()]);
        }

        foreach ($form->getErrors() as $error) {
            echo $error->getMessage();
        }
    }
}
