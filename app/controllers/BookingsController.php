<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use tennisClub\Bookings;

class BookingsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    public function displayCalendarAction(){

        $fcCollection = $this->assets->collection("fullCalendar");
        $fcCollection->addJs('js/moment.min.js');
        $fcCollection->addJs('js/fullcalendar.min.js');
        $fcCollection->addCss('css/fullcalendar.min.css');
    }

    public function jsonChartDataAction(){

        $this->view->disable();
        $dataPoints = Datapoints::find();
        $this->response->resetHeaders();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setContent(json_encode($dataPoints, JSON_NUMERIC_CHECK));
        return $this->response->send();
    }

    public function bookingsChartAction(){

    }

    public function jsonAction(){

        //$this->view->disable();
        $events = Event::find();
        $this->response->resetHeaders();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setContent(json_encode($events));
        return $this->response->send();
    }

    /**
     * Searches for bookings
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'bookings', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $bookings = Bookings::find($parameters);
        if (count($bookings) == 0) {
            $this->flash->notice("The search did not find any bookings");

            $this->dispatcher->forward([
                "controller" => "bookings",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $bookings,
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
        $this->view->setTemplateBefore("coachingAd");
        $this->view->members = tennisClub\Members::find();
        $this->view->courts = tennisClub\Courts::find();
    }

    /**
     * Edits a booking
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $booking = Bookings::findFirstByid($id);
            if (!$booking) {
                $this->flash->error("booking was not found");

                $this->dispatcher->forward([
                    'controller' => "bookings",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $booking->getId();

            $this->tag->setDefault("id", $booking->getId());
            $this->tag->setDefault("bookingDate", $booking->getBookingDate());
            $this->tag->setDefault("startTime", $booking->getStartTime());
            $this->tag->setDefault("endTime", $booking->getEndTime());
            $this->tag->setDefault("memberId", $booking->getMemberId());
            $this->tag->setDefault("courtId", $booking->getCourtId());
            $this->tag->setDefault("fee", $booking->getFee());
            
        }
    }

    /**
     * Creates a new booking
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "bookings",
                'action' => 'index'
            ]);

            return;
        }

        $booking = new Bookings();
        $booking->setbookingDate($this->request->getPost("bookingDate"));
        $booking->setstartTime($this->request->getPost("startTime"));
        $booking->setendTime($this->request->getPost("endTime"));
        $booking->setmemberId($this->request->getPost("memberId"));
        $booking->setcourtId($this->request->getPost("courtId"));
        $booking->setfee($this->request->getPost("fee"));
        

        if (!$booking->save()) {
            foreach ($booking->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "bookings",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Booking created. Your booking fee is $" . $booking->getFee());

        $this->dispatcher->forward([
            'controller' => "bookings",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a booking edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "bookings",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $booking = Bookings::findFirstByid($id);

        if (!$booking) {
            $this->flash->error("booking does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "bookings",
                'action' => 'index'
            ]);

            return;
        }

        $booking->setbookingDate($this->request->getPost("bookingDate"));
        $booking->setstartTime($this->request->getPost("startTime"));
        $booking->setendTime($this->request->getPost("endTime"));
        $booking->setmemberId($this->request->getPost("memberId"));
        $booking->setcourtId($this->request->getPost("courtId"));
        $booking->setfee($this->request->getPost("fee"));
        

        if (!$booking->save()) {

            foreach ($booking->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "bookings",
                'action' => 'edit',
                'params' => [$booking->getId()]
            ]);

            return;
        }

        $this->flash->success("booking was updated successfully");

        $this->dispatcher->forward([
            'controller' => "bookings",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a booking
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $booking = Bookings::findFirstByid($id);
        if (!$booking) {
            $this->flash->error("booking was not found");

            $this->dispatcher->forward([
                'controller' => "bookings",
                'action' => 'index'
            ]);

            return;
        }

        if (!$booking->delete()) {

            foreach ($booking->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "bookings",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("booking was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "bookings",
            'action' => "index"
        ]);
    }

}
