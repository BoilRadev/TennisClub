<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use tennisClub\Courtrating;

class CourtratingController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for courtRating
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, '\tennisClub\Courtrating', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $courtRating = Courtrating::find($parameters);
        if (count($courtRating) == 0) {
            $this->flash->notice("The search did not find any courtRating");

            $this->dispatcher->forward([
                "controller" => "courtRating",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $courtRating,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction($courtId){

        $this->view->courtId = $courtId;
    }

    public function showRatingsAction($id){

            $this->view->courtratings = Courtrating::findByCourtId($id);
    }

    /**
     * Edits a courtRating
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $courtRating = Courtrating::findFirstByid($id);
            if (!$courtRating) {
                $this->flash->error("courtRating was not found");

                $this->dispatcher->forward([
                    'controller' => "courtRating",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $courtRating->getId();

            $this->tag->setDefault("id", $courtRating->getId());
            $this->tag->setDefault("rating", $courtRating->getRating());
            $this->tag->setDefault("comment", $courtRating->getComment());
            $this->tag->setDefault("createdAt", $courtRating->getCreatedat());
            $this->tag->setDefault("courtId", $courtRating->getCourtid());
            
        }
    }

    /**
     * Creates a new courtRating
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "courtRating",
                'action' => 'index'
            ]);

            return;
        }

        $courtRating = new Courtrating();
        $courtRating->setrating($this->request->getPost("rating"));
        $courtRating->setcomment($this->request->getPost("comment"));
        $courtRating->setcreatedAt((new DateTime()) ->format("Y-m-d H:i:s"));
        $courtRating->setcourtId($this->request->getPost("courtId"));
        

        if (!$courtRating->save()) {
            foreach ($courtRating->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "courtRating",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("courtRating was created successfully");

        $this->dispatcher->forward([
            'controller' => "courtRating",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a courtRating edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "courtRating",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $courtRating = Courtrating::findFirstByid($id);

        if (!$courtRating) {
            $this->flash->error("courtRating does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "courtRating",
                'action' => 'index'
            ]);

            return;
        }

        $courtRating->setrating($this->request->getPost("rating"));
        $courtRating->setcomment($this->request->getPost("comment"));
        $courtRating->setcreatedAt($this->request->getPost("createdAt"));
        $courtRating->setcourtId($this->request->getPost("courtId"));
        

        if (!$courtRating->save()) {

            foreach ($courtRating->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "courtRating",
                'action' => 'edit',
                'params' => [$courtRating->getId()]
            ]);

            return;
        }

        $this->flash->success("courtRating was updated successfully");

        $this->dispatcher->forward([
            'controller' => "courtRating",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a courtRating
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $courtRating = Courtrating::findFirstByid($id);
        if (!$courtRating) {
            $this->flash->error("courtRating was not found");

            $this->dispatcher->forward([
                'controller' => "courtRating",
                'action' => 'index'
            ]);

            return;
        }

        if (!$courtRating->delete()) {

            foreach ($courtRating->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "courtRating",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("courtRating was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "courtRating",
            'action' => "index"
        ]);
    }

}
