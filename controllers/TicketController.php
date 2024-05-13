<?php

use myspotifyV2\models\Ticket;
use myspotifyV2\models\User;
use myspotifyV2\Requests\Validator;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/requests/Validator.php';
require $_SERVER['DOCUMENT_ROOT'] . "/models/User.php";
require $_SERVER['DOCUMENT_ROOT'] . "/models/SessionManager.php";
require $_SERVER['DOCUMENT_ROOT'] . "/models/Ticket.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/myfunctions.php";

$userdatas = SessionManager::getSession('userdatas');
$ticket = new Ticket();
$user = new User();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $validator = new Validator($_POST);
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

    if(isset($_POST["bSubmitTicket"])){

        if(empty($errors) && $validatedRequest['contactUsername'] === $userdatas['username']){
            $validatedRequest['user_id'] = $userdatas['id'];
            try{
                // dd($validatedRequest);
                // die(var_dump($validatedRequest));
                $ticketCreated = $ticket->createTicket($validatedRequest);
            }catch(Exception $e){
                if($e->getMessage() === "ticket_exists"){
                    SessionManager::setSession('error',['ticket_exists' => "<p style='color:red'>Un ticket est déjà en cours de traitement</p>"]);
                    header("Location: /views/contact.php");
                    exit;
                }
                else{
                    SessionManager::setSession('error',['ticket_model_error' => "<p style='color:red'>{$e->getMessage()}</p>"]);
                    header("Location: /views/contact.php");
                    exit;
                }
            }
            if($ticketCreated) {
                $message['create_ticket'] = "<p class='text-cus-2'> Création du ticket réussie, vous aurez une réponse dans les plus brefs délais.</p>" ;
                SessionManager::setSession('success',$message);
                header("Location: /views/contact.php");
                exit;
            }
        }
        die("Erreur à gerer username non conforme ou not empty errors");
        header("Location: /views/contact.php");
        exit;
    }
    elseif(isset($_POST['bRespondTicket'])){
        if(empty($errors)){
            $ticket->closeTicket($validatedRequest['ticketId'],$validatedRequest['ticketResponse']);
            SessionManager::unsetSession("ticket_to_display");
            SessionManager::setSession("tickets_datas",$ticket->getAllTickets());
            header("Location: ../views/admin.php");
            exit;   
        }
    }


}

elseif($_SERVER['REQUEST_METHOD'] === 'GET'){

    $validator = new Validator($_GET);
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

    if(isset($_GET["bUpdateState"])){

        if(empty($errors)){
            $getTicket = $ticket->getTicket($validatedRequest['bUpdateState']);
            $getTicket['contactUsername'] = $user->getUsername($getTicket['user_id']);
            if ($getTicket['state'] === 1) {
                $ticket->updateTicketState($getTicket['id']);
            }
            SessionManager::setSession("tickets_datas",$ticket->getAllTickets());
            SessionManager::setSession('ticket_to_display',$getTicket);
            header("Location: ../views/admin.php?ticket");
            exit; 
        }
          
    }
    elseif(isset($_GET["bIsReadTicket"])){

        if(!$errors){
        $ticket->setReadTicket($validatedRequest['bIsReadTicket']);
        SessionManager::setSession('unread_tickets', $ticket->getUnreadTickets($userdatas['id']));
        header("Location: ../views/home.php");
        exit; 
        }     
    }
    


}


