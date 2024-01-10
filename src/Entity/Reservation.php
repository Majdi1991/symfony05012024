<?php

// src/Entity/Reservation.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reservations")
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="SportActivity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    public function getActivity(): ?SportActivity
    {
        return $this->activity;
    }

    public function setActivity(?SportActivity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }
    private $reservationDateTime;

    // Ajoutez d'autres champs si nécessaire

    // Getter et Setter pour chaque champ
}
