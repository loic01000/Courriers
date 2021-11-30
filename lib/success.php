<?php
    class Success
    {
        public $messages;
       
        public function __construct()
        {
            $this->code = 0;
        }

        public function getMessagesSuccess($page)
        {
            $messages = "";
            $i=1;
            foreach($this->messages[$page] as $error)
            {
                if($code & $i)
                {
                    error_log($i);
                    $messages = str_replace($error,'',$messages);
                    $messages.= "\n".$error;
                    $messages = trim($messages);
                }
                $i *= 2;
            }

            return($messages);
        }
    }

    $errors = new Success();

    $errors->messages['success'][1]  = "Le champ de l'identifiant est vide.";
   

    