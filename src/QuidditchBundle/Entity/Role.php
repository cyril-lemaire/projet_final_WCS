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
    /**
     * @var integer
     */
    private $maxPerTeam;


    /**
     * Set maxPerTeam
     *
     * @param integer $maxPerTeam
     *
     * @return Role
     */
    public function setMaxPerTeam($maxPerTeam)
    {
        $this->maxPerTeam = $maxPerTeam;

        return $this;
    }

    /**
     * Get maxPerTeam
     *
     * @return integer
     */
    public function getMaxPerTeam()
    {
        return $this->maxPerTeam;
    }
}
