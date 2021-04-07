<?php

class Flash {
 

    private $classes=[
        'error' => 'alert-danger',
        'success' => 'alert-success',
        'info' => 'alert-info',
        'warning' =>'alert-warning'
    ];
    
    private $messageBuck=array();

    public function __construct(){
        $this->Initialize();
    }

    public function __call($name,$arg){
        $message=$arg[0];
        $this->setFlash($name,$message);
    }

    public function setFlash($type,$message){
        if(is_array($message)){
            foreach($message as $value){
                $_SESSION['flash'][$type][]=$value;
            }
        }
        else{
            $_SESSION['flash'][$type][]=$message;
        }    
    }

    public function display($type=null){
        $html="";
        if(is_null($type)){
            foreach($this->messageBuck as $name => $messages){
                if($this->checkType($name)){
                    $class=$this->classes[$name];
                    $html.="<div class='alert $class' role='alert'>";
                    foreach ($messages as $message){
                        $html.="<p>$message</p>";
                    }

                    $html.="</div>";
                }
            }    
        }
        else{
            if($this->checkType($type)){
                $class=$this->classes[$type];
                $html.="<div class='alert $class' role='alert'>";
                foreach ($this->messageBuck[$type] as $message){
                    $html.="<p>$message</p>";
                }
                $html.="</div>";
            }
        }
        echo $html;
    }

    public function checkErrors(){
        if(!empty($this->messageBuck['error'])){
            return true;
        }
        return false;
    }
    
    public function checkType($type){
        if(!empty($this->messageBuck[$type])){
            return true;
        }
        return false;
    }

    private function Initialize(){
        if(array_key_exists('flash',$_SESSION)){
            $this->messageBuck=$_SESSION['flash'];
        }
        $_SESSION['flash']=array();
    }
}

?>