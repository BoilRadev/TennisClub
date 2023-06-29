<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use tennisClub\Courts;


class CourtsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for courts
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Courts', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $courts = Courts::find($parameters);
        if (count($courts) == 0) {
            $this->flash->notice("The search did not find any courts");

            $this->dispatcher->forward([
                "controller" => "courts",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $courts,
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
     * Edits a court
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $court = Courts::findFirstByid($id);
            if (!$court) {
                $this->flash->error("court was not found");

                $this->dispatcher->forward([
                    'controller' => "courts",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $court->getId();

            $this->tag->setDefault("id", $court->getId());
            $this->tag->setDefault("surface", $court->getSurface());
            $this->tag->setDefault("floodlights", $court->getFloodlights());
            $this->tag->setDefault("indoor", $court->getIndoor());
            
        }
    }

    /**
     * Creates a new court
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "courts",
                'action' => 'index'
            ]);

            return;
        }

        $court = new Courts();
        $court->setsurface($this->request->getPost("surface"));
        $court->setfloodlights($this->request->getPost("floodlights"));
        $court->setindoor($this->request->getPost("indoor"));
        

        if (!$court->save()) {
            foreach ($court->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "courts",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("court was created successfully");

        $this->dispatcher->forward([
            'controller' => "courts",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a court edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "courts",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $court = Courts::findFirstByid($id);

        if (!$court) {
            $this->flash->error("court does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "courts",
                'action' => 'index'
            ]);

            return;
        }

        $court->setsurface($this->request->getPost("surface"));
        $court->setfloodlights($this->request->getPost("floodlights"));
        $court->setindoor($this->request->getPost("indoor"));
        

        if (!$court->save()) {

            foreach ($court->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "courts",
                'action' => 'edit',
                'params' => [$court->getId()]
            ]);

            return;
        }

        $this->flash->success("court was updated successfully");

        $this->dispatcher->forward([
            'controller' => "courts",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a court
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $court = Courts::findFirstByid($id);
        if (!$court) {
            $this->flash->error("court was not found");

            $this->dispatcher->forward([
                'controller' => "courts",
                'action' => 'index'
            ]);

            return;
        }

        if (!$court->delete()) {

            foreach ($court->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "courts",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("court was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "courts",
            'action' => "index"
        ]);
    }

}
