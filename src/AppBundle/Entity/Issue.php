<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * updates creator, editor fields
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="issue", cascade={"persist", "remove"})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="staffer_id", referencedColumnName="id", nullable=true)
     */
    private $staffer;

    public function __construct()
    {
        $this->status = $this::STATUS_OPEN;
        $this->comments = new ArrayCollection();
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
     * Set description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Check if the issue has been closed
     *
     * @return bool
     */
    public function isClosed()
    {
        return $this->status === $this::STATUS_CLOSED;
    }

    /**
     * Add a comment
     *
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        if (false === $this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setIssue($this);
        }
    }

    /**
     * Remove a comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        if (true === $this->comments->contains($comment)) {
            $this->comments->remove($comment);
        }
    }
    /**
     * Get comments
     *
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Check if the issue has comments
     *
     * @return bool
     */
    public function hasComments()
    {
        return $this->comments->count() > 0;
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
