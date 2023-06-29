<?php

namespace tennisClub;

class Members extends \Phalcon\Mvc\Model
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
     * @Column(column="firstname", type="string", length=30, nullable=true)
     */
    protected $firstname;

    /**
     *
     * @var string
     * @Column(column="surname", type="string", length=30, nullable=true)
     */
    protected $surname;

    /**
     *
     * @var string
     * @Column(column="memberType", type="string", length=6, nullable=true)
     */
    protected $memberType;

    /**
     *
     * @var string
     * @Column(column="dateOfBirth", type="string", nullable=true)
     */
    protected $dateOfBirth;

    /**
     *
     * @var string
     * @Column(column="memberpic", type="string", nullable=true)
     */
    protected $memberpic;

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
     * Method to set the value of field firstname
     *
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Method to set the value of field surname
     *
     * @param string $surname
     * @return $this
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Method to set the value of field memberType
     *
     * @param string $memberType
     * @return $this
     */
    public function setMemberType($memberType)
    {
        $this->memberType = $memberType;

        return $this;
    }

    /**
     * Method to set the value of field dateOfBirth
     *
     * @param string $dateOfBirth
     * @return $this
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Method to set the value of field memberpic
     *
     * @param string $memberpic
     * @return $this
     */
    public function setMemberpic($memberpic)
    {
        $this->memberpic = $memberpic;

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
     * Returns the value of field firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Returns the value of field surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Returns the value of field memberType
     *
     * @return string
     */
    public function getMemberType()
    {
        return $this->memberType;
    }

    /**
     * Returns the value of field dateOfBirth
     *
     * @return string
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Returns the value of field memberpic
     *
     * @return string
     */
    public function getMemberpic()
    {
        return $this->memberpic;
    }

    /**
     * Method to set the value of field memberType
     *
     * @param string $memberType
     * @return $this
     */



    public function getAge(){
        $dob = new \DateTime($this->dateOfBirth);
        $today = new \DateTime();
        $interval = $today->diff($dob);
        return $interval->format("%y");
    }


    public function __toString(){
        return $this->firstname . " " . $this->surname;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tennisClub");
        $this->setSource("member");
        $this->hasMany('id','tennisClub\Bookings', 'memberId', ['alias' => 'Booking']);
        $this->hasMany('id','tennisClub\Memberimage', 'memberId', ['alias' => 'Memberimage']);
        $this->belongsTo('memberType','tennisClub\MembershipType', 'membershipType', ['alias' => 'membershipType']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Members[]|Members|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Members|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public static function findOverage($age){
        $today = new \DateTime();
        $bornBeforeDate = $today->sub(new \DateInterval("P" . $age . "Y"));
        return parent::find(['conditions'=>'dateOfBirth < :dob:', 'bind' => ['dob' => $bornBeforeDate->format('Y-m-d')]]);
    }


    public static function findUnderage($age){
        $today = new \DateTime();
        $bornAfterDate = $today->sub(new \DateInterval("P" . $age . "Y"));
        return parent::find(['conditions'=>'dateOfBirth > :dob:', 'bind' => ['dob' => $bornAfterDate->format('Y-m-d')]]);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'members';
    }

}
