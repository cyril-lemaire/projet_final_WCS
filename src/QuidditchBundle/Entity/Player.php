<?php

namespace QuidditchBundle\Entity;

/**
 * Player
 */
class Player
{
	public function __toString()
	{
		return $this->getName() . ' (Role: ' . $this->getRole() . ')';
	}

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->setExp(random_int(20, 80));
		$this->setAge(random_int(18, 30));
		$this->setExhaust(random_int(0, 20));
	}

	/**
	 * Set team
	 *
	 * @param \QuidditchBundle\Entity\Team $team
	 *
	 * @return Player
	 */
	public function setTeam(\QuidditchBundle\Entity\Team $team = null)
	{
		if ($this->getTeam() != null)
			$this->getTeam()->removePlayer($this);
		$this->team = null;
		if ($team != null) {
			$team->addPlayer($this);
		}
		return $this;
	}

	/**
	 * Set team, DOES NOT MAKE ANY CHECK FOR VALIDITY
	 *
	 * @param \QuidditchBundle\Entity\Team $team
	 *
	 * @return Player
	 */
	public function _setTeamWithNoCheck(\QuidditchBundle\Entity\Team $team = null)
	{
		$this->team = $team;

		return $this;
	}

	/**
	 * Add exp
	 *
	 * @param integer $exp
	 *
	 * @return Player
	 */
	public function addExp($exp)
	{
		$this->exp += $exp;

		return $this;
	}

	/**
	 * Add exhaust
	 *
	 * @param integer $exhaust
	 *
	 * @return Player
	 */
	public function addExhaust($exhaust)
	{
		$this->exhaust = min($this->exhaust + $exhaust, 80);

		return $this;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Player
	 */
	public function setName($name)
	{
		$this->name = ucwords(strtolower($name));

		return $this;
	}

	////////////////////
	// GENERATED CODE //
	////////////////////
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $exp;

    /**
     * @var integer
     */
    private $age;

    /**
     * @var integer
     */
    private $exhaust;

    /**
     * @var \QuidditchBundle\Entity\Team
     */
    private $team;

    /**
     * @var \QuidditchBundle\Entity\Role
     */
    private $role;


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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set exp
     *
     * @param integer $exp
     *
     * @return Player
     */
    public function setExp($exp)
    {
        $this->exp = $exp;

        return $this;
    }

    /**
     * Get exp
     *
     * @return integer
     */
    public function getExp()
    {
        return $this->exp;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Player
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set exhaust
     *
     * @param integer $exhaust
     *
     * @return Player
     */
    public function setExhaust($exhaust)
    {
        $this->exhaust = $exhaust;

        return $this;
    }

    /**
     * Get exhaust
     *
     * @return integer
     */
    public function getExhaust()
    {
        return $this->exhaust;
    }

    /**
     * Get team
     *
     * @return \QuidditchBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set role
     *
     * @param \QuidditchBundle\Entity\Role $role
     *
     * @return Player
     */
    public function setRole(\QuidditchBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \QuidditchBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
