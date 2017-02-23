<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use AppBundle\Entity\Traits\BlameableEntity;

/**
 * Issue
 *
 * @ORM\Table(name="it__issue")
 * @ORM\Entity()
 *
 * @author Wolfgang Gassner <gassnerw@gmail.com>
 */
class Issue
{
    const STATUS_OPEN   = 'open';
    const STATUS_CLOSED = 'closed';

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="staffer_id", referencedColumnName="id", nullable=true)
     */
    private $staffer;

    public function __construct()
    {
        $this->status = $this::STATUS_OPEN;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Issue
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Issue
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set staffer
     *
     * @param User $staffer
     * @return Issue
     */
    public function setStaffer(User $staffer = null)
    {
        $this->staffer = $staffer;

        return $this;
    }

    /**
     * Get staffer
     *
     * @return User
     */
    public function getStaffer()
    {
        return $this->staffer;
    }
}
