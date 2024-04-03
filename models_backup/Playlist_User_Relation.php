<?php

    class PlaylistUserRelation {

        private $db;

        public function __construct($db) {
            $this->db = $db;
        }
        /**
         * Crée une relation de subscription entre un utilisateur, auditeur et une playlist.
         * Le but, c'est que plusieurs utilisateurs peuvent avoir le même playlist id dans ce contexte.
         */
        public function make_subscribe_relation(int $userid, int $playlistid){
            $request = $this->db->prepare("INSERT INTO playlists_users_relations (`user_id`, playlist_id) VALUES ( :userid, :playlistid)");
            $request->bindValue(":userid", $userid);
            $request->bindValue(":playlistid", $playlistid);
            $request->execute();
        }
        /**
         * Va analyser les relations d'abonnement, sur base de l'id d'utilisateur.
         * Si l'id de l'utilisateur correspond à une entrée c'est qu'il est au moins abonné au playlist_id correspondant.
         * Et comme l'idéal serait de récupérer TOUTES les playlist ID on renvoie un tableau.
         */
        public function get_related_susbcribes(int $userid):array{
            $request = $this->db->prepare("SELECT playlist_id FROM playlists_users_relations WHERE (`user_id`= :userId)");
            $request->bindValue(":userId", $userid);
            $request->execute();
            $result = $request->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            
        }

    }
    