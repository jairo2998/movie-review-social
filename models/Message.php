<?php
    class Message {
        private $url;
        public function __construct($url){
            $this->url = $url;
        }
        public function setMessage($msg, $type, $redirect = "index.php"){
            $_SESSION["message"] = $msg;
            $_SESSION["message_type"] = $type;

            if($redirect !== "back"){
                header("Location: ".$this->url . $redirect);
            } else {
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
        }

        public function getMessage(){
            if(!empty($_SESSION["message"])){ 

                $data["msg"] = $_SESSION["message"];
                $data["type"] = $_SESSION["message_type"];
                return $data;

            } else {
                return false;
            }
        }

        public function clearMessage(){
            unset($_SESSION["message"]);
            unset($_SESSION["message_type"]);
        }
    }