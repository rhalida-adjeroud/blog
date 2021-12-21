<?php
session_start();

    class user{
        protected $bdd;
        private $id;
        public $login;
        public $email;
        protected $password;
        private $id_droit;
        
        
        public function __construct(){
           $this->bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
            
        }
    

        public function register($login, $email, $password){
            $this->login = $login;
            $this->email = $email;
            $this->password = $password;

           
            //connexion à la base de données pour verifier si le login existe deja 
            $requetesql2 = "SELECT login FROM utilisateurs WHERE login = '$this->login'";
            $calcul2 = $this->bdd->prepare($requetesql2);
            $calcul2 -> execute();
            // rowCount permet de compter le nombre d'utilisateur avec ce login
            $result2 = $calcul2->rowCount();

            // Si aucun utilisateur n'a ce login alors je le rentre ne base 
            if(($result2) == 0){
                $requetesql1 = "INSERT INTO `utilisateurs` (`login`, `email`, `password`,`id_droits`) VALUES ('$this->login', '$this->email', '$this->password', 1)";
                $calcul1 = $this->bdd->prepare($requetesql1);
                $calcul1 -> execute();
                echo 'Inscription reussie';
            }else{echo 'Login deja existant';}

            //var_dump($result2);
        }


        public function connect($login, $password){
            $this->password = $password;
            $request = "SELECT*FROM utilisateurs WHERE login = '$this->login' AND password = '$this->password'";
            $calcul = $this->bdd->prepare($request);
            $calcul -> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['user'] = $result;
            var_dump($result);
        }

        public function disconnect(){
            session_destroy();
        }

        public function delete(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "DELETE FROM `utilisateurs` WHERE id = '$this->id' ";
            $calcul = $this->bdd->prepare($request);
            $calcul -> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            session_destroy();
            var_dump($result);
        }

        public function update(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "UPDATE utilisateurs SET  login = '$this->login', email = '$this->email', password = '$this->password', firstname = '$this->firstname', lastname = '$this->lastname' WHERE id = $this->id";
            $calcul = $this->bdd->prepare($request);
            $calcul -> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            var_dump($request);
        }

        public function isConnected(){
            if(isset($_SESSION['user'])){
                echo 'Utilisateur Connecté';
            }else{echo 'Utilisateur non connecté';}
        }

        public function getAllInfos(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "SELECT*FROM utilisateurs WHERE id = '$this->id' ";
            $calcul =$this->bdd->prepare($request);
            $calcul->execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }

        public function getLogin(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "SELECT login FROM utilisateurs WHERE id = '$this->id'";
            $calcul = $this->bdd->prepare($request);
            $calcul-> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }

        public function getEmail(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "SELECT email FROM utilisateurs WHERE id = '$this->id'";
            $calcul = $this->bdd->prepare($request);
            $calcul-> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }

        public function getFirstName(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "SELECT firstname FROM utilisateurs WHERE id = '$this->id'";
            $calcul = $this->bdd->prepare($request);
            $calcul-> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }

        public function getLastname(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "SELECT lastname FROM utilisateurs WHERE id = '$this->id'";
            $calcul = $this->bdd->prepare($request);
            $calcul-> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }

        
    }

    
?>