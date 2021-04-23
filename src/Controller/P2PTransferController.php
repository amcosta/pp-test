<?php

namespace App\Controller;

use App\DTO\MakeP2PTransferRequest;
use App\Form\MakeP2PTransferType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/api/p2p-transfer")
 */
class P2PTransferController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route(methods={"POST"}, name="api.p2p-transfer.make-transfer")
     */
    public function makeTransfer(Request $request)
    {
        $form = $this->createForm(MakeP2PTransferType::class, new MakeP2PTransferRequest());
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $data = $form->getData();
            return $this->json(['name' => $data->getAmount()]);
        }

        foreach ($form->getErrors() as $error) {
            echo $error->getMessage();
        }

        return $this->json(array_reduce((array) $form->getErrors(), function () {}));
    }
}