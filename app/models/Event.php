<?php

class Event extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Column(column="title", type="string", length=61, nullable=true)
     */
    protected $title;

    /**
     *
     * @var string
     * @Column(column="start", type="string", length=21, nullable=true)
     */
    protected $start;

    /**
     *
     * @var string
     * @Column(column="end", type="string", length=21, nullable=true)
     */
    protected $end;

    /**
     *
     * @var string
     * @Column(column="venue", type="string", length=18, nullable=false)
     */
    protected $venue;

    /**
     *
     * @var integer
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    protected $id;

    /**
     * Method to set the value of field title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Method to set the value of field start
     *
     * @param string $start
     * @return $this
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Method to set the value of field end
     *
     * @param string $end
     * @return $this
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Method to set the value of field venue
     *
     * @param string $venue
     * @return $this
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;

        return $this;
    }

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
     * Returns the value of field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the value of field start
     *
     * @return string
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Returns the value of field end
     *
     * @return string
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Returns the value of field venue
     *
     * @return string
     */
    public function getVenue()
    {
        return $this->venue;
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tennisClub");
        $this->setSource("event");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'event';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Event[]|Event|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Event|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
