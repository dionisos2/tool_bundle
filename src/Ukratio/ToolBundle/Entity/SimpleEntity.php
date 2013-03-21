<?php

namespace Ukratio\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ukratio\ToolBundle\Service\AssertData;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * SimpleEntity
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ukratio\ToolBundle\Entity\SimpleEntityRepository")
 */
class SimpleEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
    
}