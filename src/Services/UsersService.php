<?php


namespace App\Services;


use App\DTO\AbstractDto;
use App\DTO\UsersDto;
use App\Entity\AbstractEntity;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UsersService extends AbstractEntityService
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UsersRepository $usersRepository, UserPasswordEncoderInterface $passwordEncoder) {
        parent::__construct($usersRepository);
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param UsersDto $dto
     * @param Users $entity
     */
    public function addOrUpdate(AbstractDto $dto, AbstractEntity $entity): void {
        if ($dto->email !== $entity->getEmail()) {
            $userWithNewMail = $this->repository->findByMail($dto->email);
            if ($userWithNewMail) {
                throw new Exception('Cette adresse mail est déjà utilisée');
            }
        }
        if ($dto->password) {
            $dto->password = $this->encodePassword($entity, $dto->password);
        }
        parent::addOrUpdate($dto, $entity);
    }

    public function encodePassword(UserInterface $user, string $value): string {
        return $this->passwordEncoder->encodePassword($user, $value);
    }

    public function isPasswordValid(UserInterface $user, string $value): bool {
        return $this->passwordEncoder->isPasswordValid($user, $value);
    }

}