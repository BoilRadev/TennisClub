<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;
use secutiry\Dbaccesscontrollist;
use secutiry\Dbrole;
use secutiry\Dbaction;
use secutiry\Dbresource;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users have only access to the me
 */

class SecurityPlugin extends Plugin{

    public function getAcl(){
        if (isset($this->persistent->acl)){
            $acl = new AclList();
            $acl->setDefaultAction(Acl::DENY);

            $dbRoles = Dbrole::find();
            $dbResources = Dbresource::find();
            $dbACLItems = Dbaccesscontrollist::find();

            //Register roles
            foreach ($dbRoles as $dbRole){
                $acl->addRole($dbRole->getRole());
            }

            foreach ($dbResources as $dbResource){
                $dbActions = $dbResource->getDbaction();
                $actions[] = null;
                foreach ($dbActions as $dbAction) {
                    array_push($actions,$dbAction->getAction());
                }
                $acl->addResource(new Resource($dbAction->getResource()),$actions);
            }
            foreach ($dbACLItems as $ACLItem){
                $acl->allow($ACLItem->getRole(), $ACLItem->getResource() , $ACLItem->getAction());
            }
            $this->persistent->acl = $acl;
        }
        return $this->persistent->acl;
    }

    public function beforeDispatch(Event $event, Dispatcher $dispatcher){

        $auth = $this->session->get('auth');
        if (!$auth){
            $role = 'Guest';
        }
        else{
            $role = $auth['role'];
        }

        $controller = strtolower($dispatcher->getControllerName());
        $action = strtolower($dispatcher->getActionName());

        $acl = $this->getAcl();
        if (!$acl->isResource($controller)){
            $dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404'
            ]);
            return false;
        }

        $allowed = $acl->isAllowed($role, $controller, $action);
        if (!$allowed){
            $dispatcher->forward(array(
                'controller' => 'error',
                'action' => 'show401'
            ));
        }
    }
}