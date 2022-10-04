<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\Position;
use App\Form\PositionType;
use App\Service\CountingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/position')]
class PositionController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {

    }

    #[Route('/new/{id}', name: 'position_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        Invoice $invoice,
        CountingService $countingService
    ): Response
    {
        $position = new Position();
        $position->setInvoice($invoice);
        $form = $this->createForm(PositionType::class, $position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($position);

            $countingService->countPositionGross($position);
            $countingService->countInvoice($invoice);
            $this->entityManager->flush();

            return $this->redirectToRoute(
                'invoice_show',
                [
                    'id' => $invoice->getId(),
                ]
            );
        }

        return $this->render(
            'position/new.html.twig',
            [
                'position' => $position,
                'form'     => $form->createView(),
            ]
        );
    }

    #[Route('/{id}/edit', name: 'position_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Position $position,
        CountingService $countingService
    ): Response {
        $form = $this->createForm(PositionType::class, $position);
        $form->handleRequest($request);
        $invoice = $position->getInvoice();

        if($form->isSubmitted() && $form->isValid()) {

            $countingService->countPositionGross($position);
            $countingService->countInvoice($invoice);

            $this->entityManager->flush();

            return $this->redirectToRoute('invoice_show',
            [
                'id' => $invoice->getId()
            ]);
        }

        return $this->render(
            'position/edit.html.twig',
            [
                'position' => $position,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/{id}', name: 'position_delete', methods: ['DELETE'])]
    public function delete(
        Request $request,
        Position $position,
    ): Response {
        $invoice = $position->getInvoice();

        if($this->isCsrfTokenValid('delete'.$position->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($position);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('invoice_show',
        [
            'id' => $invoice->getId()
        ]);
    }

}
