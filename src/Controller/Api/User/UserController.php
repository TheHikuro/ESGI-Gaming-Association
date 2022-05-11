<?php

namespace App\Controller\Api\User;

use App\Controller\Api\ApiController;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/users', name: 'users')]
class UserController extends ApiController
{
    public function __construct(RequestStack $requestStack)
    {
        parent::__construct($requestStack);
        $this->whitelistCriteria = ['id', 'email', 'roles', 'name', 'lastname', 'pseudo'];
    }

    #[Route('/find', name: '_find', methods: ['GET'])]
    public function list(Request $request, UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        if ($this->isAuthorized($request)) {
            $users = [];

            if ($this->populate == null) {
                return $this->unvalidatedPopulateResponse();
            }

            if (!$this->whitelistCriteriaValidator()) {
                return $this->unvalidatedCriteriaResponse();
            }

            try {
                $users = json_decode($serializer->serialize($userRepository->findBy($this->criteria, $this->order, $this->limit, $this->offset), JsonEncoder::FORMAT, [AbstractObjectNormalizer::CIRCULAR_REFERENCE_LIMIT => 2, AbstractObjectNormalizer::ATTRIBUTES => $this->populate]));
            } catch (\Exception $e) {
                return $this->customErrorResponse($e->getMessage(), 400);
            }

            return $this->successResponse($users);
        }
        return $this->unAuthorizedResponse();
    }

    #[Route('/edit', name: '_edit', methods: ['PUT'])]
    public function edit(Request $request, UserRepository $userRepository): Response
    {
        if ($this->isAuthorized($request)) {
            if (!$this->whitelistCriteriaValidator() || empty($this->criteria)) {
                return $this->unvalidatedCriteriaResponse();
            }

            try {
                $user = $userRepository->findOneBy($this->criteria);
            } catch (\Exception $e) {
                return $this->customErrorResponse($e->getMessage(), 400);
            }

            //$user->....

            return $this->successResponse('User updated');
        }
    }

    #[Route('/delete', name: '_delete', methods: ['DELETE'])]
    public function delete(Request $request, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        if ($this->isAuthorized($request)) {
            if (!$this->whitelistCriteriaValidator() || empty($this->criteria)) {
                return $this->unvalidatedCriteriaResponse();
            }

            try {
                $user = $userRepository->findOneBy($this->criteria);
            } catch (\Exception $e) {
                return $this->customErrorResponse($e->getMessage(), 400);
            }

            $em->remove($user);
            $em->flush();

            return $this->successResponse('User deleted');
        }
    }
}