<?php

namespace App\Services;

use App\DTO\AbstractDto;
use App\Entity\AbstractEntity;
use App\Repository\AbstractRepository;

abstract class AbstractEntityService {

    /**
     * @var AbstractRepository
     */
    protected $repository;

    public function __construct(AbstractRepository $repository) {
        $this->repository = $repository;
    }

    public function addOrUpdate(AbstractDto $dto, AbstractEntity $entity) {
        $entity->setFromDto($dto);
        $this->repository->save($entity);
    }

    public function delete(AbstractEntity $entity): void {
        $this->repository->delete($entity);
    }
}