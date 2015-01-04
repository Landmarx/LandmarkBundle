<?php
namespace Landmarx\Bundle\LandmarkBundle\Document;

use \Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use \Doctrine\Common\Collections\ArrayCollection;
use \Symfony\Component\Validator\Constraints as Assert;
use \Gedmo\Mapping\Annotation as Gedmo;

use \Landmarx\Bundle\CoreBundle\Traits\SluggableTrait;
use \Landmarx\Bundle\CoreBundle\Traits\TimestampableTrait;
use \Landmarx\Bundle\CoreBundle\Traits\BlameableTrait;

/**
 * @ODM\Document(repositoryClass="Landmarx\Bundle\LandmarkBundle\Repository\TypeRepository")
 */
class Type implements \Landmarx\Component\Landmark\Interfaces\TypeInterface
{
    use SluggableTrait;
    use TimestampableTrait;
    use BlameableTrait;

    /**
     * Id
     * @var integer
     * @ODM\Id
     */
    protected $id;
    
    /**
     * Name
     * @var string
     * @ODM\String
     */
    protected $name;
    
    /**
     * Description
     * @var string
     * @ODM\String
     */
    protected $description;
    
    /**
     * Parent
     * @var Type $parent
     * @ODM\ReferenceOne(targetDocument="Type")
     */
    protected $parent;

    /**
     * Get id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get parent
     * @return Landmarx\Component\Landmark\Interfaces\Type
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set parent
     * @param Landmarx\Component\Landmark\Interfaces\Type $type
     * @return _self
     */
    public function setParent(Type $parent)
    {
        $this->parent = $parent;

        return $this;
    }
}
