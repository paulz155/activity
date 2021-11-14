<?php

namespace App\Method;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;
use App\Entity\Visit;

class GetVisitsMethod implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function apply(array $paramList = null) {
        $repository = $this->em->getRepository(Visit::class);
        $rows = [];
        foreach($repository->findAllGroupByUrl($paramList['page'] ?? null, $paramList['limit'] ?? 2) as $visit) {
            $rows[] = $visit;
        }

        return ['rows' => $rows, 'count' => $repository->countAllGroupByUrl()];
    }

    public function getParamsConstraint(): Constraint {
        return new Collection(['fields' => [
                'page' => new Optional([
                    new PositiveOrZero()
                ]),
                'limit' => new Optional([
                    new PositiveOrZero()
                ]),
        ]]);
    }

}
