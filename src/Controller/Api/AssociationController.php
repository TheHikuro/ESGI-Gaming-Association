<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiController;
use App\Repository\Association\AssociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/association', name: 'association')]
class AssociationController extends ApiController
{
    public function __construct(RequestStack $requestStack, \Swift_Mailer $mailer)
    {
        parent::__construct($requestStack, $mailer);
        $this->whitelistCriteria = ['id', 'name', 'create_date', 'owner'];
    }

    #[Route('/find', name: '_find', methods: ['GET'])]
    public function list(Request $request, AssociationRepository $associationRepository, SerializerInterface $serializer): Response
    {
        if (!$this->isAuthorized($request))
            return $this->unAuthorizedResponse();

        $associations = [];

        if ($this->populate == null)
            return $this->unvalidatedPopulateResponse();

        if (!$this->whitelistCriteriaValidator())
            return $this->unvalidatedCriteriaResponse();

        try {
            $associations = json_decode($serializer->serialize($associationRepository->findBy($this->criteria, $this->order, $this->limit, $this->offset), JsonEncoder::FORMAT, [AbstractObjectNormalizer::CIRCULAR_REFERENCE_LIMIT => 2, AbstractObjectNormalizer::ATTRIBUTES => $this->populate]));
        } catch (\Exception $e) {
            return $this->customErrorResponse($e->getMessage(), 400);
        }

        return $this->successResponse($associations);
    }

    #[Route('/edit', name: '_edit', methods: ['PUT'])]
    public function edit(Request $request, AssociationRepository $associationRepository): Response
    {
        if (!$this->isAuthorized($request))
            return $this->unAuthorizedResponse();

        if (!$this->whitelistCriteriaValidator() || empty($this->criteria))
            return $this->unvalidatedCriteriaResponse();

        try {
            $association = $associationRepository->findOneBy($this->criteria);
        } catch (\Exception $e) {
            return $this->customErrorResponse($e->getMessage(), 400);
        }

        //$association->....

        return $this->successResponse('Association updated');
    }

    #[Route('/add', name: '_add', methods: ['POST'])]
    public function add(Request $request, AssociationRepository $associationRepository): Response
    {
        if (!$this->isAuthorized($request))
            return $this->unAuthorizedResponse();
    }

    #[Route('/delete', name: '_delete', methods: ['DELETE'])]
    public function delete(Request $request, AssociationRepository $associationRepository, EntityManagerInterface $em): Response
    {
        if (!$this->isAuthorized($request))
            return $this->unAuthorizedResponse();
        
        if (!$this->whitelistCriteriaValidator() || empty($this->criteria))
            return $this->unvalidatedCriteriaResponse();

        try {
            $association = $associationRepository->findOneBy($this->criteria);
        } catch (\Exception $e) {
            return $this->customErrorResponse($e->getMessage(), 400);
        }

        if (!$association)
            return $this->customErrorResponse('Association not found', 404);

        $em->remove($association);
        $em->flush();

        return $this->successResponse('Association deleted');
    }
}
