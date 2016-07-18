<?php

namespace RJSite\PlatformBundle\Entity\CV;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="cv_section")
 * @ORM\Entity(repositoryClass="RJSite\PlatformBundle\Repository\CV\SectionRepository")
 */
class Section
{
    /**
     * @ORM\OneToMany(targetEntity="Experience", mappedBy="section")
     */
    private $experiences;
    
    /**
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profile;
    
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

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
     * Set title
     *
     * @param string $title
     *
     * @return Profile
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Section
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * Set link
     *
     * @param string $link
     *
     * @return Section
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set profile
     *
     * @param \OC\PlatformBundle\Entity\CV\Profile $profile
     *
     * @return Section
     */
    public function setProfile(\OC\PlatformBundle\Entity\CV\Profile $profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \OC\PlatformBundle\Entity\CV\Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
