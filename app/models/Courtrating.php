<?php

namespace tennisClub;

class Courtrating extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(column="rating", type="integer", length=11, nullable=true)
     */
    protected $rating;

    /**
     *
     * @var string
     * @Column(column="comment", type="string", nullable=true)
     */
    protected $comment;

    /**
     *
     * @var string
     * @Column(column="createdAt", type="string", nullable=true)
     */
    protected $createdAt;

    /**
     *
     * @var integer
     * @Column(column="courtId", type="integer", length=11, nullable=true)
     */
    protected $courtId;

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
     * Method to set the value of field rating
     *
     * @param integer $rating
     * @return $this
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Method to set the value of field comment
     *
     * @param string $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Method to set the value of field createdAt
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Method to set the value of field courtId
     *
     * @param integer $courtId
     * @return $this
     */
    public function setCourtId($courtId)
    {
        $this->courtId = $courtId;

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
     * Returns the value of field rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Returns the value of field comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Returns the value of field createdAt
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Returns the value of field courtId
     *
     * @return integer
     */
    public function getCourtId()
    {
        return $this->courtId;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tennisClub");
        $this->setSource("courtRating");
        $this->belongsTo('courtId', 'tennisClub\Courts', 'id', ['alias' => 'Courts']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'courtRating';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Courtrating[]|Courtrating|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Courtrating|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
