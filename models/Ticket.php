<?php
class Ticket {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    public function createTicket(int $user_id, string $content){

        if($this->checkExistingTicket($user_id)){
            $sql = $this->db->prepare("INSERT INTO tickets (content, `user_id`)  VALUES (:content, :user_id)");
            $sql->bindValue(":content",$content);
            $sql->bindValue(":user_id",$user_id);
            $sql->execute();

       
        }   
        return false;      
    }

    public function checkExistingTicket(int $user_id){

        $sql = $this->db->prepare("SELECT id FROM tickets WHERE `user_id` = :user_id AND `state` = 1");
        $sql->bindValue(":user_id",$user_id);
        $sql->execute();
        $result = $sql->fetchColumn();
        if ($result > 0){
            throw new Exception("ticket_exists");
        }
        return true;
        
    }

    public function getAllTickets(){
        $sql = $this->db->prepare("SELECT * FROM tickets");
        $sql->execute();
        $result = $sql->fetchAll();
        return $result;
    }

    public function getTicket(int $ticket_id){
        $sql = $this->db->prepare("SELECT * FROM tickets WHERE id = :id");
        $sql->bindValue(":id",$ticket_id);
        $sql->execute();
        $result = $sql->fetch();
        return $result;
    }
    /**
     * Based on ticket id, will update the state of the current ticket
     */
    public function updateTicketState(int $ticket_id){
        $sql = $this->db->prepare("UPDATE tickets SET `state` = 2 WHERE id = :id");
        $sql->bindValue(":id",$ticket_id);
        $sql->execute();
        $result = $sql->rowCount();
        if ($result === 0) {
            throw new Exception("ticket_state_update_failed");
        }
        return true;
    }

    public function closeTicket(int $ticket_id, string $ticket_response){
        $sql = $this->db->prepare("UPDATE tickets SET `state` = 3, response = :ticket_response WHERE id = :id");
        $sql->bindValue(":id",$ticket_id);
        $sql->bindValue(":ticket_response", $ticket_response);
        $sql->execute();
        $result = $sql->rowCount();
        if ($result === 0) {
            throw new Exception("ticket_response_update_failed");
        }
        return true;
    }

    public function getUnreadTickets(int $user_id){
        $sql = $this->db->prepare("SELECT * FROM tickets WHERE `state` = 3 AND is_read = 0 AND user_id = :user_id");
        $sql->bindValue(":user_id",$user_id);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($result);
        // exit;
        if (!$result) {
            return false;
        }
        return $result;
    }

    public function setReadTicket(int $ticket_id){
        $sql = $this->db->prepare("UPDATE tickets SET is_read = 1 WHERE id = :id");
        $sql->bindValue(":id",$ticket_id);
        $sql->execute();
        $result = $sql->rowCount();
        if ($result === 0) {
            throw new Exception("ticket_is_read_update_failed");
        }
        return true;
    }
}