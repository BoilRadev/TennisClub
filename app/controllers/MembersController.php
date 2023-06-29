<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use tennisClub\Members;


class MembersController extends ControllerBase
{
    public function initialize(){
        $this->view->setTemplateBefore("coachingAd");
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    public function findAgeAction($overUnder,$age){
        $member = Members::$overUnder($age);
        $numberPage = 1;

        if (count($member) == 0){
            $this->flash->notice("The search did not find any members");

            $this->dispatcher->forward([
                "controller" => "Members",
                "action" => "index"
            ]);

            return;
        }

        $this->view->pick("members/search");
        $paginator = new Paginator([
            'data'=>$member,
            'limit'=>10,
            'page'=>$numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Searches for Members
     */
    public function searchAction($params = null)
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'tennisClub\Members', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            if (isset($params)){
                $query = Criteria::fromInput($this->di, 'tennisClub\Members', $params);
                $this->persistent->parameters = $query->getParams();
            }
            else{
                $numberPage = $this->request->getQuery("page", "int");
            }
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $members = Members::find($parameters);
        if (count($members) == 0) {
            $this->flash->notice("The search did not find any Members");

            $this->dispatcher->forward([
                "controller" => "Members",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $members,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a Member
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $member = Members::findFirstByid($id);
            if (!$member) {
                $this->flash->error("Member was not found");

                $this->dispatcher->forward([
                    'controller' => "Members",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $member->getId();

            $this->tag->setDefault("id", $member->getId());
            $this->tag->setDefault("firstname", $member->getFirstname());
            $this->tag->setDefault("surname", $member->getSurname());
            $this->tag->setDefault("memberType", $member->getMemberType());
            $this->tag->setDefault("dateOfBirth", $member->getDateOfBirth());
            $this->view->memberImages = $member->getMemberimage();

            
        }
    }

    /**
     * Creates a new Member
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "Members",
                'action' => 'index'
            ]);

            return;
        }

        $member = new Members();
        $member->setfirstname($this->request->getPost("firstname"));
        $member->setsurname($this->request->getPost("surname"));
        $member->setmemberType($this->request->getPost("memberType"));
        $member->setdateOfBirth($this->request->getPost("dateOfBirth"));
        $member->setMemberpic(base64_encode(file_get_contents($this->request->getUploadedFiles()[0]->getTempName())));

        if (!$member->save()) {
            foreach ($member->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "Members",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Member was created successfully");

        $this->dispatcher->forward([
            'controller' => "Members",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a Member edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "Members",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $member = Members::findFirstByid($id);

        if (!$member) {
            $this->flash->error("Member does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "Members",
                'action' => 'index'
            ]);

            return;
        }

        $member->setfirstname($this->request->getPost("firstname"));
        $member->setsurname($this->request->getPost("surname"));
        $member->setmemberType($this->request->getPost("memberType"));
        $member->setdateOfBirth($this->request->getPost("dateOfBirth"));
        

        if (!$member->save()) {

            foreach ($member->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "Members",
                'action' => 'edit',
                'params' => [$member->getId()]
            ]);

            return;
        }

        $this->flash->success("Member was updated successfully");

        $this->dispatcher->forward([
            'controller' => "Members",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a Member
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $member = Members::findFirstByid($id);
        if (!$member) {
            $this->flash->error("Member was not found");

            $this->dispatcher->forward([
                'controller' => "Members",
                'action' => 'index'
            ]);

            return;
        }

        if (!$member->delete()) {

            foreach ($member->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "Members",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("Member was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "Members",
            'action' => "index"
        ]);
    }

}
