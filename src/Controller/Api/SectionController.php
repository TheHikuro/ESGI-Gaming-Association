<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiController;
use App\Repository\User\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/section', name: 'section')]
class SectionController extends ApiController
{
    public function __construct(RequestStack $requestStack, \Swift_Mailer $mailer)
    {
        parent::__construct($requestStack, $mailer);
        $this->whitelistCriteria = ['id', 'name'];
    }

    #[Route('/find', name: '_find', methods: ['GET'])]
    public function list(Request $request, SectionRepository $sectionRepository, SerializerInterface $serializer): Response
    {
        if (!$this->isAuthorized($request))
            return $this->unAuthorizedResponse();

        $sections = [];

        if ($this->populate == null)
            return $this->unvalidatedPopulateResponse();

        if (!$this->whitelistCriteriaValidator())
            return $this->unvalidatedCriteriaResponse();

        try {
            $sections = json_decode($serializer->serialize($sectionRepository->findBy($this->criteria, $this->order, $this->limit, $this->offset), JsonEncoder::FORMAT, [AbstractObjectNormalizer::CIRCULAR_REFERENCE_LIMIT => 2, AbstractObjectNormalizer::ATTRIBUTES => $this->populate]));
        } catch (\Exception $e) {
            return $this->customErrorResponse($e->getMessage(), 400);
        }

        return $this->successResponse($sections);
    }

    #[Route('/edit', name: '_edit', methods: ['PUT'])]
    public function edit(Request $request, SectionRepository $sectionRepository): Response
    {
        if (!$this->isAuthorized($request))
            return $this->unAuthorizedResponse();

        if (!$this->whitelistCriteriaValidator() || empty($this->criteria))
            return $this->unvalidatedCriteriaResponse();

        try {
            $section = $sectionRepository->findOneBy($this->criteria);
        } catch (\Exception $e) {
            return $this->customErrorResponse($e->getMessage(), 400);
        }

        //$section->....

        return $this->successResponse('Section updated');;
    }

    #[Route('/add', name: '_add', methods: ['POST'])]
    public function add(Request $request, SectionRepository $sectionRepository): Response
    {
        if (!$this->isAuthorized($request))
            return $this->unAuthorizedResponse();
    }

    #[Route('/delete', name: '_delete', methods: ['DELETE'])]
    public function delete(Request $request, SectionRepository $sectionRepository, EntityManagerInterface $em): Response
    {
        if (!$this->isAuthorized($request))
            return $this->unAuthorizedResponse();

        if (!$this->whitelistCriteriaValidator() || empty($this->criteria))
            return $this->unvalidatedCriteriaResponse();

        try {
            $section = $sectionRepository->findOneBy($this->criteria);
        } catch (\Exception $e) {
            return $this->customErrorResponse($e->getMessage(), 400);
        }

        if (!$section)
            return $this->customErrorResponse('Section not found', 404);

        $em->remove($section);
        $em->flush();

        return $this->successResponse('Section deleted');
    }
}
