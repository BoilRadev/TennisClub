<?php

namespace tennisClub;

class Courts extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(column="surface", type="string", length=30, nullable=true)
     */
    protected $surface;

    /**
     *
     * @var integer
     * @Column(column="floodlights", type="integer", length=1, nullable=true)
     */
    protected $floodlights;

    /**
     *
     * @var integer
     * @Column(column="indoor", type="integer", length=1, nullable=true)
     */
    protected $indoor;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field surface
     *
     * @param string $surface
     * @return $this
     */
    public function setSurface($surface)
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * Method to set the value of field floodlights
     *
     * @param integer $floodlights
     * @return $this
     */
    public function setFloodlights($floodlights)
    {
        $this->floodlights = $floodlights;

        return $this;
    }

    /**
     * Method to set the value of field indoor
     *
     * @param integer $indoor
     * @return $this
     */
    public function setIndoor($indoor)
    {
        $this->indoor = $indoor;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field surface
     *
     * @return string
     */
    public function getSurface()
    {
        return $this->surface;
    }

    /**
     * Returns the value of field floodlights
     *
     * @return integer
     */
    public function getFloodlights()
    {
        return $this->floodlights;
    }

    /**
     * Returns the value of field indoor
     *
     * @return integer
     */
    public function getIndoor()
    {
        return $this->indoor;
    }


    public function __toString(){
        return "Court: " . $this->id . ", Surface: " . $this->surface;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tennisClub");
        $this->setSource("courts");
        $this->hasMany('id', 'tennisClub\Bookings', 'courtId', ['alias' => 'Bookings']);
        $this->hasMany('id', 'tennisClub\Courtrating', 'courtId', ['alias' => 'Courtrating']);
    }

    public function getAverageRating(){

        $id = $this->id;
        $averageRating = Courtrating::average(['conditions' => "courtId = $id" , 'column' => 'rating']);
        return $averageRating;
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Courts[]|Courts|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Courts|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'courts';
    }

}
