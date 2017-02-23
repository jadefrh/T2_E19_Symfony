<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TVShow", inversedBy="votes")
     * @ORM\JoinColumn(name="show_id", referencedColumnName="id")
     */
    private $show;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="votes")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * Set show
     *
     * @param \AppBundle\Entity\TVShow $show
     *
     * @return Vote
     */
    public function setShow(\AppBundle\Entity\TVShow $show = null)
    {
        $this->show = $show;

        return $this;
    }

    /**
     * Get show
     *
     * @return \AppBundle\Entity\TVShow
     */
    public function getShow()
    {
        return $this->show;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return Vote
     */
    public function setAuthor(\AppBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Vote
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
