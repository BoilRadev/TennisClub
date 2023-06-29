<?php
namespace tennisClub;
class Bookings extends \Phalcon\Mvc\Model
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
     * @Column(column="booking_date", type="string", nullable=true)
     */
    protected $bookingDate;

    /**
     *
     * @var string
     * @Column(column="start_time", type="string", nullable=true)
     */
    protected $startTime;

    /**
     *
     * @var string
     * @Column(column="end_time", type="string", nullable=true)
     */
    protected $endTime;

    /**
     *
     * @var integer
     * @Column(column="member_id", type="integer", length=11, nullable=true)
     */
    protected $memberId;

    /**
     *
     * @var integer
     * @Column(column="court_id", type="integer", length=11, nullable=true)
     */
    protected $courtId;

    /**
     *
     * @var double
     * @Column(column="fee", type="double", length=18, nullable=true)
     */
    protected $fee;

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
     * Method to set the value of field booking_date
     *
     * @param string $bookingDate
     * @return $this
     */
    public function setBookingDate($bookingDate)
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    /**
     * Method to set the value of field start_time
     *
     * @param string $startTime
     * @return $this
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Method to set the value of field end_time
     *
     * @param string $endTime
     * @return $this
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Method to set the value of field member_id
     *
     * @param integer $memberId
     * @return $this
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;

        return $this;
    }

    /**
     * Method to set the value of field court_id
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
     * Method to set the value of field fee
     *
     * @param double $fee
     * @return $this
     */
    public function setFee($fee)
    {
        $this->fee = $fee;

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
     * Returns the value of field booking_date
     *
     * @return string
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }

    /**
     * Returns the value of field start_time
     *
     * @return string
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Returns the value of field end_time
     *
     * @return string
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Returns the value of field member_id
     *
     * @return integer
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * Returns the value of field court_id
     *
     * @return integer
     */
    public function getCourtId()
    {
        return $this->courtId;
    }

    /**
     * Returns the value of field fee
     *
     * @return double
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tennisClub");
        $this->setSource("bookings");
        $this->belongsTo('memberId', 'tennisClub\Members', 'id', ['alias' => 'Members']);
        $this->belongsTo('courtId', 'tennisClub\Courts', 'id', ['alias' => 'Courts']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'bookings';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Bookings[]|Bookings|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Bookings|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function beforeSave(){

        $costPerHour = $this->getMembers()->getMembershipType()->getCourthourlyfee();
        $startTime = \DateTime::createFromFormat("H:i",$this->startTime);
        $endTime = \DateTime::createFromFormat("H:i",$this->endTime);
        $interval = $endTime->diff($startTime);
        $totalHours = round($interval->s / 3600 + $interval->i / 60  + $interval->h, 2);
        $this->fee = $costPerHour * $totalHours;
    }

}
