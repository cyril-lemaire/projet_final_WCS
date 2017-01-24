<?php

namespace QuidditchBundle\Entity;

/**
 * Role
 */
class Role
{
	public function __toString()
	{
		return $this->getName();
	}

	////////////////////
	// GENERATED CODE //
	////////////////////

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Role
	 */
	public function setName($name)
	{
		$this->name = ucfirst(strtolower($name));

		return $this;
	}

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;


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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
