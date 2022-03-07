<?php

namespace App\Entity;

use App\Config\StatusEnum;
use App\Repository\RequestRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RequestRepository::class)]
class Request
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Слишком короткий заголовок",
     *      maxMessage = "Слишком дилнный заголовок"
     * )
     */
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $text;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'integer')]
    #[ORM\OneToMany(targetEntity: 'App\Entity\User')]
    private $user;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow')));
        $this->setStatus(StatusEnum::NEW->value);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getStatusLabel(): ?string
    {
        return StatusEnum::getLabel(StatusEnum::from($this->status));
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Определяет находится ли заявка больше часа в статусе "Новая"
     *
     * @return bool
     */
    public function isRequiredApproval(): bool
    {
        $now = (new Carbon())->addHour();
        if ($now->greaterThan($this->getCreatedAt()) && $this->status === StatusEnum::NEW->value) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user->getId();

        return $this;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId)
    {
        $this->user = $userId;

        return $this;
    }
}
