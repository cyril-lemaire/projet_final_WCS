<?php

namespace QuidditchBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;

/**
 * Picture
 */
class Picture
{
	/**
	 * @var File
	 */
	private $file;

	/**
	 * @return File
	 */
	public function getFile()
	{
		return $this->file;
	}

	/**
	 * @param File $file
	 * @return $this
	 */
	public function setFile(File $file)
	{
		$this->file = $file;

		return $this;
	}

	////////////////////
	// GENERATED CODE //
	////////////////////

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $alt;


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
     * Set path
     *
     * @param string $path
     *
     * @return Picture
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Picture
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
}
