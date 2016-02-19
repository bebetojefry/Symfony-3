<?php

namespace AppBundle\Modal;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

class Api {
    
    /**
     * @Type("string")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 20,
     *      minMessage = "Role name must be at least {{ limit }} characters long",
     *      maxMessage = "Role name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;
    
    /**
     * @Type("string")
     */
    private $description;
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name = $name;
        return $this;
    }
    
    public function getDescription(){
        return $this->description;
    }
    
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }
}

