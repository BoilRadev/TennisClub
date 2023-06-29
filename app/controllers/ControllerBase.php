<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function initialize(){

        $ratingCollection = $this->assets->collection("rating");
        $ratingCollection->addJs('js/star-rating.min.js');
        $ratingCollection->addJs('js/fontawesome.min.js');
        $ratingCollection->addCss('css/fontawesome.min.css');
        $ratingCollection->addCss('css/star-rating.min.css');
        }

}

