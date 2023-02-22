<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $sum = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'o', targetEntity: OrderDetail::class, orphanRemoval: true)]
    private Collection $order_orderDetail;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    public function __construct()
    {
        $this->order_orderDetail = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSum(): ?float
    {
        return $this->sum;
    }

    public function setSum(float $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, OrderDetail>
     */
    public function getOrderOrderDetail(): Collection
    {
        return $this->order_orderDetail;
    }

    public function addOrderOrderDetail(OrderDetail $orderOrderDetail): self
    {
        if (!$this->order_orderDetail->contains($orderOrderDetail)) {
            $this->order_orderDetail->add($orderOrderDetail);
            $orderOrderDetail->setO($this);
        }

        return $this;
    }

    public function removeOrderOrderDetail(OrderDetail $orderOrderDetail): self
    {
        if ($this->order_orderDetail->removeElement($orderOrderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderOrderDetail->getO() === $this) {
                $orderOrderDetail->setO(null);
            }
        }

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
