<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class MembershiptypeController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for membershiptype
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Membershiptype', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "membershipType";

        $membershiptype = Membershiptype::find($parameters);
        if (count($membershiptype) == 0) {
            $this->flash->notice("The search did not find any membershiptype");

            $this->dispatcher->forward([
                "controller" => "membershiptype",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $membershiptype,
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
     * Edits a membershiptype
     *
     * @param string $membershipType
     */
    public function editAction($membershipType)
    {
        if (!$this->request->isPost()) {

            $membershiptype = Membershiptype::findFirstBymembershipType($membershipType);
            if (!$membershiptype) {
                $this->flash->error("membershiptype was not found");

                $this->dispatcher->forward([
                    'controller' => "membershiptype",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->membershipType = $membershiptype->getMembershiptype();

            $this->tag->setDefault("membershipType", $membershiptype->getMembershiptype());
            $this->tag->setDefault("courtHourlyFee", $membershiptype->getCourthourlyfee());
            
        }
    }

    /**
     * Creates a new membershiptype
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "membershiptype",
                'action' => 'index'
            ]);

            return;
        }

        $membershiptype = new Membershiptype();
        $membershiptype->setmembershipType($this->request->getPost("membershipType"));
        $membershiptype->setcourtHourlyFee($this->request->getPost("courtHourlyFee"));
        

        if (!$membershiptype->save()) {
            foreach ($membershiptype->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "membershiptype",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("membershiptype was created successfully");

        $this->dispatcher->forward([
            'controller' => "membershiptype",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a membershiptype edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "membershiptype",
                'action' => 'index'
            ]);

            return;
        }

        $membershipType = $this->request->getPost("membershipType");
        $membershiptype = Membershiptype::findFirstBymembershipType($membershipType);

        if (!$membershiptype) {
            $this->flash->error("membershiptype does not exist " . $membershipType);

            $this->dispatcher->forward([
                'controller' => "membershiptype",
                'action' => 'index'
            ]);

            return;
        }

        $membershiptype->setmembershipType($this->request->getPost("membershipType"));
        $membershiptype->setcourtHourlyFee($this->request->getPost("courtHourlyFee"));
        

        if (!$membershiptype->save()) {

            foreach ($membershiptype->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "membershiptype",
                'action' => 'edit',
                'params' => [$membershiptype->getMembershiptype()]
            ]);

            return;
        }

        $this->flash->success("membershiptype was updated successfully");

        $this->dispatcher->forward([
            'controller' => "membershiptype",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a membershiptype
     *
     * @param string $membershipType
     */
    public function deleteAction($membershipType)
    {
        $membershiptype = Membershiptype::findFirstBymembershipType($membershipType);
        if (!$membershiptype) {
            $this->flash->error("membershiptype was not found");

            $this->dispatcher->forward([
                'controller' => "membershiptype",
                'action' => 'index'
            ]);

            return;
        }

        if (!$membershiptype->delete()) {

            foreach ($membershiptype->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "membershiptype",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("membershiptype was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "membershiptype",
            'action' => "index"
        ]);
    }

}
