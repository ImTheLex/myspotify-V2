<?php

    class Track {

        private $db;

        public function __construct($db) {
            $this->db = $db;
        }
        /**
         * Crée une playlist et retourne l'id de cette dernière.
         */
        public function create_track($track_title, $duration, $artist_id):int{


            $request = $this->db->prepare("INSERT INTO tracks (title, duration, artist_id) VALUES (:title, :duration, :artist_id)");
            $request->bindValue(":title", $track_title);
            $request->bindValue(":duration", $duration);
            $request->bindValue(":artist_id", $artist_id);
            $request->execute();

            $lastTrack = $this->db->lastInsertId();

            return $lastTrack;
        }

        public function show_my_tracks(array $tracks_ids){
        
            if(!empty($tracks_ids)):
                $placeholders = array_fill( 0 , count(array_map(function($value){
                    // var_dump("Valuetab:",$value['playlist_id']);
                    return trim($value['track_id']);
                },$tracks_ids)),'?');

                $placeholders = implode(',',$placeholders );
                $request = $this->db->prepare("SELECT * FROM tracks WHERE id IN ($placeholders)");
                foreach ($tracks_ids as $index => $track) {
                    $request->bindValue($index + 1, $track['track_id'], PDO::PARAM_INT);
                }

                $request->execute();
                $result = $request->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            else:
                return false;
            endif;
        }
        public function show_tracks(){
            $request = $this->db->prepare("SELECT * FROM tracks");
            $request->execute();
            return $request->fetchAll(PDO::FETCH_ASSOC);
        }

        public function delete_track($track_id) {

            $request = $this->db->prepare("DELETE FROM tracks WHERE (id = :track_id)");
            $request->bindValue(':track_id', $track_id);
            $request->execute();
        
        }

    }