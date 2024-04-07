<?php
namespace myspotifyV2\models;
use myspotifyV2\dependencies\MyModel;

require_once '../dependencies/MyModel.php';
class Ticket extends MyModel {

    protected $rules = ([
        'id'=>'required|int',
        'subject'=>'required|min:3|max:30',
        'content'=>'required|min:5|max:150',
        'content'=>'required|min:5|max:150'
    ]);
    // die(var_dump($datas));

    /**
     * Will create a new "ticket" based on the datas provided, thoses "datas" concern : user_id of the sender, subject, and content of the ticket. Can see that similar to a "mail" except the "to" is support team.
     */
    public function createTicket(array $datas){

        if($this->validate($datas,$this->rules())){
            if($this->checkExistingTicket($datas['user_id'])){
                $keys = array_keys($datas);
                $this->db->beginTransaction();
                    $result = $this->query("INSERT INTO $this->table (user_id,subject,content) VALUES (:user_id,:subject,:content)",
                    [
                        'user_id' => $datas[$keys[0]],
                        'subject' => $datas[$keys[1]],
                        'content' => $datas[$keys[2]]
                    ]);
                $this->db->commit();
                return $result;

            }
            
        }

    }

    /**
     * Based on a user_id will check if any ticket unopened yet exists. If so, "throw new exception" else returns true to say "its valid, continue". 
     */
    public function checkExistingTicket(int $user_id){

        $result = $this->query("SELECT id FROM tickets WHERE `user_id` = :user_id AND `state` = 1",
        [
            "user_id" => $user_id
        ])->fetchColumn();
        if ($result > 0){
            throw new \Exception("ticket_exists");
        }
        return true;
        
    }

    
    public function closeTicket(int $ticket_id, string $ticket_response){
        $result = $this->query("UPDATE tickets SET `state` = 3, response = :ticket_response WHERE id = :id",
        [
            'id' => $ticket_id,
            'ticket_response' => $ticket_response
        ]);
        if ($result === 0) {
            throw new \Exception("ticket_response_update_failed");
        }
        return true;
    }

    public function getUnreadTickets(int $user_id){
        $result = $this->query("SELECT * FROM tickets WHERE `state` = 3 AND is_read = 0 AND user_id = :user_id",
        [
            'user_id' => $user_id
        ])->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result) {
            return false;
        }
        return $result;
    }
}