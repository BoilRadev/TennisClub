<?php

namespace tennisClub;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
class Users extends \Phalcon\Mvc\Model
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
     * @Column(column="username", type="string", length=45, nullable=true)
     */
    protected $username;

    /**
     *
     * @var string
     * @Column(column="password", type="string", length=100, nullable=true)
     */
    protected $password;

    /**
     *
     * @var string
     * @Column(column="firstname", type="string", length=45, nullable=true)
     */
    protected $firstname;

    /**
     *
     * @var string
     * @Column(column="surname", type="string", length=45, nullable=true)
     */
    protected $surname;

    /**
     *
     * @var string
     * @Column(column="emailAddress", type="string", length=100, nullable=true)
     */
    protected $emailAddress;

    /**
     *
     * @var string
     * @Column(column="role", type="string", length=70, nullable=true)
     */
    protected $role;

    /**
     *
     * @var string
     * @Column(column="validationKey", type="string", length=255, nullable=true)
     */
    protected $validationKey;

    /**
     *
     * @var string
     * @Column(column="status", type="string", length=2550, nullable=true)
     */
    protected $status;

    /**
     *
     * @var string
     * @Column(column="createdAt", type="string", nullable=true)
     */
    protected $createdAt;

    /**
     *
     * @var string
     * @Column(column="updatedAt", type="string", nullable=true)
     */
    protected $updatedAt;

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
     * Method to set the value of field username
     *
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

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
     * Method to set the value of field emailAddress
     *
     * @param string $emailAddress
     * @return $this
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Method to set the value of field role
     *
     * @param string $role
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Method to set the value of field validationKey
     *
     * @param string $validationKey
     * @return $this
     */
    public function setValidationKey($validationKey)
    {
        $this->validationKey = $validationKey;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

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
     * Method to set the value of field updatedAt
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

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
     * Returns the value of field username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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
     * Returns the value of field emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Returns the value of field role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Returns the value of field validationKey
     *
     * @return string
     */
    public function getValidationKey()
    {
        return $this->validationKey;
    }

    /**
     * Returns the value of field status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
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
     * Returns the value of field updatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tennisClub");
        $this->setSource("users");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function validation(){
        $validator = new Validation();
        $uValidator = new UniquenessValidator(["message"=>"this userName has already been chosen"]);
        $validator->add('username', $uValidator);
        return $this->validate($validator);
    }

}
