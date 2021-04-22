<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/api/p2p-transfer")
 */
class P2PTransferController extends AbstractController
{
    /**
     * @Route(methods={"POST"}, name="api.p2p-transfer.make-transfer")
     */
    public function makeTransfer(Request $request)
    {
        return $this->json(['msg' => 'deu bom \0/']);
    }
}