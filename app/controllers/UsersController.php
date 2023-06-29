<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use tennisClub\Users;

class UsersController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    public function loginAction(){

    }

    public function authorizeAction(){

        $username = $this->request->getPost('username');
        $pass = $this->request->getPost('password');
        $user = Users::findFirstByUsername($username);
        if ($user){
            if ($this->security->checkHash($pass, $user->getPassword())){
                $this->session->set('auth',
                ['userName' => $user->getUsername(),
                 'role' => $user->getRole()]);
                $this->flash->success("Welcome back " . $user->getUsername());
                return $this->dispatcher->forward(["controller" => "members", "action" => "search"]);
            }
            else{
                $this->flash->error("Your password is incorrect - try again");
                return $this->dispatcher->forward(["controller" => "users", "action" => "login"]);
            }
        }
        else{
            $this->flash->error("That username was not found - try again ");
            return $this->dispatcher->forward(["controller" => "users", "action" => "login"]);
        }
        return $this->dispatcher->forward(["controller" => "index", "action" => "index"]);
    }

    /**
     * Searches for users
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, '\tennisClub\Users', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $users = Users::find($parameters);
        if (count($users) == 0) {
            $this->flash->notice("The search did not find any users");

            $this->dispatcher->forward([
                "controller" => "users",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $users,
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
     * Edits a user
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $user = Users::findFirstByid($id);
            if (!$user) {
                $this->flash->error("user was not found");

                $this->dispatcher->forward([
                    'controller' => "users",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $user->getId();

            $this->tag->setDefault("id", $user->getId());
            $this->tag->setDefault("username", $user->getUsername());
            $this->tag->setDefault("password", $user->getPassword());
            $this->tag->setDefault("firstname", $user->getFirstname());
            $this->tag->setDefault("surname", $user->getSurname());
            $this->tag->setDefault("emailAddress", $user->getEmailaddress());
            $this->tag->setDefault("role", $user->getRole());
            $this->tag->setDefault("validationKey", $user->getValidationkey());
            $this->tag->setDefault("status", $user->getStatus());
            $this->tag->setDefault("createdAt", $user->getCreatedat());
            $this->tag->setDefault("updatedAt", $user->getUpdatedat());
            
        }
    }

    /**
     * Creates a new user
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

        $user = new Users();
        $user->setusername($this->request->getPost("username"));
        $user->setpassword($this->security->hash($this->request->getPost("password")));
        $user->setfirstname($this->request->getPost("firstname"));
        $user->setsurname($this->request->getPost("surname"));
        $user->setemailAddress($this->request->getPost("emailAddress"));
        $user->setRole("Registered User");
        $user->setStatus("Active");
        $user->setValidationKey(md5($this->request->getPost("username") . uniqid()));
        $user->setCreatedAt((new DateTime())->format("Y-m-d H:i:s"));

        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("user was created successfully");

        $this->dispatcher->forward([
            'controller' => "users",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $user = Users::findFirstByid($id);

        if (!$user) {
            $this->flash->error("user does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

        $user->setusername($this->request->getPost("username"));
        $user->setpassword($this->request->getPost("password"));
        $user->setfirstname($this->request->getPost("firstname"));
        $user->setsurname($this->request->getPost("surname"));
        $user->setemailAddress($this->request->getPost("emailAddress"));
        $user->setrole($this->request->getPost("role"));
        $user->setvalidationKey($this->request->getPost("validationKey"));
        $user->setstatus($this->request->getPost("status"));
        $user->setcreatedAt($this->request->getPost("createdAt"));
        $user->setupdatedAt($this->request->getPost("updatedAt"));
        

        if (!$user->save()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'edit',
                'params' => [$user->getId()]
            ]);

            return;
        }

        $this->flash->success("user was updated successfully");

        $this->dispatcher->forward([
            'controller' => "users",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a user
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $user = Users::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user was not found");

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("user was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "users",
            'action' => "index"
        ]);
    }

}
