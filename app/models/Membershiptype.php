<?php
namespace tennisClub;
class Membershiptype extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="membershipType", type="string", length=30, nullable=false)
     */
    protected $membershipType;

    /**
     *
     * @var double
     * @Column(column="courtHourlyFee", type="double", length=10, nullable=true)
     */
    protected $courtHourlyFee;

    /**
     * Method to set the value of field membershipType
     *
     * @param string $membershipType
     * @return $this
     */
    public function setMembershipType($membershipType)
    {
        $this->membershipType = $membershipType;

        return $this;
    }

    /**
     * Method to set the value of field courtHourlyFee
     *
     * @param double $courtHourlyFee
     * @return $this
     */
    public function setCourtHourlyFee($courtHourlyFee)
    {
        $this->courtHourlyFee = $courtHourlyFee;

        return $this;
    }

    /**
     * Returns the value of field membershipType
     *
     * @return string
     */
    public function getMembershipType()
    {
        return $this->membershipType;
    }

    /**
     * Returns the value of field courtHourlyFee
     *
     * @return double
     */
    public function getCourtHourlyFee()
    {
        return $this->courtHourlyFee;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tennisClub");
        $this->setSource("membershiptype");
        $this->hasMany('membershipType', 'tennisClub\Members', 'memberType', ['alias' => 'Members']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'membershiptype';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Membershiptype[]|Membershiptype|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Membershiptype|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
