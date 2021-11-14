<?php

namespace App\Entity;

use App\Repository\VisitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisitRepository::class)
 */
class Visit {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $data;

    /**
     * @ORM\Column(type="text")
     */
    private $url;

    public function getId(): ?int {
        return $this->id;
    }

    public function getData(): ?\DateTimeInterface {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self {
        $this->data = $data;

        return $this;
    }

    public function getUrl(): ?string {
        return $this->url;
    }

    public function setUrl(string $url): self {
        $this->url = $url;

        return $this;
    }

    public function serialize() {
        return [$this->getData(), $this->getUrl()];
    }

}
