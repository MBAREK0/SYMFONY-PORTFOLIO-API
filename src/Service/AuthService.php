<?php


namespace App\Service;

use App\Entity\PersonalInformation;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PersonalInformationRepository;

class AuthService
{
    private $personalInformationRepository;
    private $entityManager;

    public function __construct(PersonalInformationRepository $personalInformationRepository, EntityManagerInterface $entityManager)
    {
        $this->personalInformationRepository = $personalInformationRepository;
        $this->entityManager = $entityManager;
    }

    public function login(object $request): ?PersonalInformation
    {
        $personalInformation = $this->personalInformationRepository->findOneBy([]);
        if ($personalInformation && $personalInformation->getPassword() === $request->get('password')) {
            $session = $request->getSession();
            $session->set('is_i_log_in', true);

            return $personalInformation;
        }
        return  null;
    }
}