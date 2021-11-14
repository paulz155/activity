<?php

namespace App\Method;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Url;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;
use App\Entity\Visit;

class PostVisitMethod implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface {
    
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function apply(array $paramList = null) {

        $visit = new Visit();
        $visit->setData(new \Datetime($paramList['data']));
        $visit->setUrl($paramList['url']);
        $this->em->persist($visit);
        $this->em->flush();

        return ['success' => 1];
    }

    public function getParamsConstraint(): Constraint {
        return new Collection(['fields' => [
                'data' => new Required([
                    new Date()
                        ]),
                'url' => new Required([
                    new Url()
                        ]),
        ]]);
    }

}
