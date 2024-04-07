<?php

use myspotifyV2\models\Ticket;
use myspotifyV2\Requests\Validator;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/requests/Validator.php';
require $_SERVER['DOCUMENT_ROOT'] . "/models/User.php";
require $_SERVER['DOCUMENT_ROOT'] . "/models/SessionManager.php";
require $_SERVER['DOCUMENT_ROOT'] . "/models/Ticket.php";

$userdatas = SessionManager::getSession('userdatas');
$ticket = new Ticket();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $validator = new Validator($_POST);
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

    if(isset($_POST["bSubmitTicket"])){

        if(empty($errors) && $validatedRequest['contactUsername'] === $userdatas['username']){
            
            try{
                $ticket->createTicket($userdatas['id'],$validatedRequest);
            }catch(Exception $e){
                if($e->getMessage() === "ticket_exists"){
                    SessionManager::setSession('error',['ticket_exists' => "<p style='color:red'>Un ticket est déjà en cours de traitement</p>"]);
                    header("Location: /views/contact.php");
                    exit;
                }
            }
            $message['create_ticket'] = "<p class='text-cus-2'> Création du ticket réussie, vous aurez une réponse dans les plus brefs délais.</p>" ;
            SessionManager::setSession('success',$message);
            header("Location: /views/contact.php");
            exit;
    
        }
        header("Location: /views/contact.php");
        exit;
    }
    elseif(isset($_POST['bRespondTicket'])){
        // $ticket->closeTicket($_POST['ticketId'],$_POST['ticketResponse']);
        header("Location: ../views/admin.php?ticket={$_POST['ticketId']}");
        exit;   
    }


}

elseif($_SERVER['REQUEST_METHOD'] === 'GET'){

    $validator = new Validator($_GET);
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

    if(isset($_GET["bUpdateState"])){

        // $checkticket = $ticket->getTicket($_GET['bUpdateState']);
        if ($checkticket['state'] === 1) {
            // $ticket->updateTicketState($_GET['bUpdateState']);
        }
        // var_dump($validatedRequest);
        // exit;
        header("Location: ../views/admin.php?ticket={$_GET['bUpdateState']}");
        exit;   
    }
    elseif(isset($_GET["bIsReadTicket"])){

        
    
         if(!$errors){
            // $ticket->setReadTicket($validatedRequest['bIsReadTicket']);
            // SessionManager::setSession('unread_tickets', $ticket->getUnreadTickets($userdatas['id']));
            header("Location: ../views/home.php");
            exit; 
         }     
    }
    


}


