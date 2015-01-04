<?php
namespace Landmarx\Bundle\LandmarkBundle\Model;

use \Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use \Doctrine\Common\Collections\ArrayCollection;
use \Symfony\Component\Validator\Constraints as Assert;
use \Oh\GoogleMapFormTypeBundle\Validator\Constraints as OhAssert;

use \Landmarx\Bundle\CoreBundle\Traits\BlameableTrait;
use \Landmarx\Bundle\CoreBundle\Traits\SluggableTrait;
use \Landmarx\Bundle\CoreBundle\Traits\TimestampableTrait;
use \Landmarx\Bundle\CoreBundle\Traits\ToggleVisibilityTrait;

class Landmark
{
    use BlameableTrait;
    use SluggableTrait;
    use TimestampableTrait;
    use ToggleVisibilityTrait;

    /**
     * Id
     * @var integer
     */
    protected $id;

    /**
     * Name
     * @var string
     */
    protected $name;

    /**
     * Description
     * @var string
     */
    protected $description;
    
    /**
     * Brief description
     * @var string
     */
    protected $briefDescription;

    /**
     * Landmark type
     * @var \Landmarx\Bundle\LandmarkBundle\Model\Type
     */
    protected $type;

    /**
     * Parent
     * @var \Landmarx\Bundle\LandmarkBundle\Model\Landmark
     */
    protected $parent;
    
    /**
     * Location
     * @var \Landmarx\Bundle\LocationBundle\Model\Location
     */
    protected $location;
    
    /**
     * Children
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $children;
    
    /**
     * Visibility
     * @var boolean
     */
    protected $visibility;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        
    }
    
    /**
     * Get landmark id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get description
     * @return string
     */
     
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Get brief description
     * @return string
     */
    public function getBriefDescription()
    {
        return $this->briefDescription;
    }

    /**
     * Get type
     * @return \Landmarx\Bundle\LandmarkBundle\Model\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get parent
     * @return \Landmarx\Bundle\LandmarkBundle\Model\Landmark
     */
    public function getParent()
    {
        return $this->parent;
    }
        
    /**
     * Get location
     * @return \Landmarx\Bundle\LocationBundle\Model\Location
     */
    public function getLocation()
    {
        return $this->location;
    }
    
    /**
     * Get chilrent
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }
    
    /**
     * Get child
     * @param string $child
     * @return \Landmarx\Bundle\LandmarkBundle\Model\Landmark
     */
    public function getChild($child)
    {
        return $this->children->get($child);
    }
    
    /**
     * Has child
     * @param string $child
     * @return boolean
     */
    public function hasChild($child)
    {
        return $this->cihldren->contains($child);
    }

    /**
     * Set anme
     * @param string $name
     * @return \Landmarx\Bundle\LandmarkBundle\Model\Landmark
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set description
     * @param string $description
     * @return \Landmarx\Bundle\LandmarkBundle\Model\Landmark
     */
    public function setDescription($description)
    {
        $this->description = $description;
        
        if (is_null($this->briefDescription)) {
            /** @todo Add configuration variable for brief description length */
            $max = 50;
            
            return $this->setBriefDescription(substr($description, 0, $max));
        }

        return $this;
    }
    
    /**
     * Set brief description
     * @param string $description
     * @return \Landmarx\Bundle\LandmarkBundle\Model\Landmark
     */
    public function setBriefDescription($description)
    {
        $this->briefDescription = $description;
        
        return $this;
    }

    /**
     * Set Type
     * @param \Landmarx\Bundle\LandmarkBundle\Model\Type $type
     * @return \Landmarx\Bundle\LandmarkBundle\Model\Landmark
     */
    public function setType(\Landmarx\Bundle\LandmarkBundle\Model\Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set parent
     * @param \Landmarx\Bundle\LandmarkBundle\Model\Landmark $parent
     * @return \Landmarx\Bundle\LandmarkBundle\Model\Landmark
     */
    public function setParent(\Landmarx\Bundle\LandmarkBundle\Model\Landmark $parent)
    {
        $this->parent = $parent;

        return $this;
    }
    
    /**
     * Set location
     * @param \Landmarx\Bundle\LocationBundle\Model\Location $location
     * @return \Landmarx\Bundle\LandmarkBundle\Model\Landmark
     */
    public function setLocation(\Landmarx\Bundle\LocationBundle\Model\Location $location)
    {
        $this->location = $location;
        
        return $this;
    }
    
    /**
     * Set children
     * @param array $children
     * @return \Landmarx\Bundle\LandmarkBundle\Model\Landmark
     */
    public function setChildren(array $children)
    {
        $this->children = new ArrayCollection($children);
        
        return $this;
    }
    
    /**
     * Add child
     * @param \Landmarx\Bundle\LandmarkBundle\Model\Landmark $child
     * @return \Landmarx\Bundle\LandmarkBundle\Model\Landmark
     */
    public function addChild(\Landmarx\Bundle\LandmarkBundle\Model\Landmark $child)
    {
        $this->children->add($child);
        
        return $this;
    }
}
