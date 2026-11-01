<?php
    //Le connecte à la base de donnée qui s'appelle project en localhost
    function conn_start(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "aqua_db"; 
        $conn = new mysqli($servername, $username, $password, $dbname);
        if($conn->connect_error) {
            die("Connection Failed" . $conn->connect_error);
        }
        return $conn;
    }
    
    //Si utilisateur ne s'est pas connecté via le login ça l'envoie dessus
    function is_connected(){
        if(!isset($_SESSION['user'])){
            header('Location: login.php');
        }
    }

    //Si l'utilisateur n'est pas abonné alors ça affiche un bouton abonné
    //Si l'utilisateur est abonné alors ça affiche un bouton désabonné
    function subButton($randUser){
        $conn=conn_start();
    
        $sub=mysqli_real_escape_string($conn,$_SESSION['user']);
        $subto=mysqli_real_escape_string($conn,$randUser);
    
        $sql="SELECT subto FROM subs WHERE user='$sub'";
        $result=mysqli_query($conn,$sql);
        echo "<div class='bouton'>";
            if(mysqli_num_rows($result)>0){ 
                $verif=false;
                //Vérification des abonnements de user
                    foreach($result as $array){
                        if($subto==$array['subto']){
                            $verif=true;
                        }
                    }
                    //Si user peut s'abonner
                    if(!$verif){    
                        echo "<form action=sub.php method=post id='sub-form'>";
                            echo "<input type=hidden id=subto name=subto value=$subto>";
                            echo "<input type=submit id='sub' value=S'abonner class='abonnes' >";
                        echo "</form>";
                    } else {
                        echo "<form action=unsub.php method=post id='unsub-form'>";
                            echo "<input type=hidden id=subto name=subto value=$subto>";
                            echo "<input type=submit id='unsub' value='Se désabonner' class='desabonnes'>";
                        echo "</form>";
                    }
            } else {
                echo "<form action=sub.php id='sub-form' method=post>";
                    echo "<input type=hidden id='subto' name=subto value=$subto>";
                    echo "<input type=submit id='sub' value=S'abonner class='abonnes'>";
                echo "</form>";
            }
        echo "</div>";
    }

    //Regarde si l'utilisateur est Admin ou non
    function isAdmin($id){
        $conn=conn_start();
        $id=mysqli_real_escape_string($conn,$id);
        
        $sql="SELECT isAdmin FROM users WHERE id='$id'";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
        return $row['isAdmin'];
    }

    //Regarde si l'utilisateur est l'auteur du message ou non
    function isAuthor($message_id, $user_id) {
        $conn = conn_start();
        $message_id = mysqli_real_escape_string($conn, $message_id);
        $user_id = mysqli_real_escape_string($conn, $user_id);
        
        $sql = "SELECT id FROM message WHERE id='$message_id' AND user_id='$user_id'";
        $result = mysqli_query($conn, $sql);
    
        if(mysqli_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }
    }

?>