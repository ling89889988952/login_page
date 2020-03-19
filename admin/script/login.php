<?php

function login($username, $password){

    $pdo = Database::getInstance()->getConnection();
    // check user existance
    $check_exist_query = 'SELECT COUNT(*) FROM tbl_user WHERE user_name = :username';
    $user_set = $pdo->prepare($check_exist_query);
    $user_set->execute(
        array(
            ':username' =>$username,
        )
        ); 

    
    if ($user_set->fetchColumn()>0){
        // If the password did not encrypt, using the method to check the username and password
        $get_user_query  = 'SELECT * FROM tbl_user WHERE user_name = :username AND user_password = :password';
        $user_check      = $pdo->prepare($get_user_query);
        $user_check      ->execute(
            array(
                ':username' =>$username,
                ':password' =>$password,
            )
            );  

        $found_user = $user_check->fetch(PDO::FETCH_ASSOC);

            if($found_user){
               $message = "You are logged in";

               $id =  $found_user['user_id'];
               $_SESSION['user_id'] = $id;
               $_SESSION['user_name'] = $found_user['user_name'];
               $login_count = $found_user ['user_login_count'];

            
                // var_dump($login_count);
                // exit;

                // check the user is the first time login 
                if($login_count < 1){
                    redirect_to('admin/admin_editUser.php');
                } elseif($login_count == 1){
                    // get the login_time 
                    $login_time = $found_user ['user_login_time'];

                    // get the now time
                    date_default_timezone_set("America/Toronto");
                    $now_date = date("Y-m-d H:i:s");
                    
                    // change the now time to strtotime and set the last time = after 12 hour
                    $now = strtotime($now_date);
                    $last = strtotime("$login_time + 12 hours");
                    
                    // compare the now time data <  the data of (late time + 12hours)
                    if($now < $last){

                        // update the login count
                        // In order to user can skip to the admin_login.php directly
                        $update_query = 'UPDATE tbl_user SET user_login_count = user_login_count+1,user_login_time = user_login_time WHERE user_id = :id';
                        $update_set = $pdo->prepare($update_query);
                        $update_set->execute(
                            array(
                                ':id'=>$id
                            )
                            );

                            redirect_to('admin/admin_login.php');


                    }else{
                        $message = 'Your account has been suspended.';
                        session_destroy();
                        

                    }
                    
                }else{
                    redirect_to('admin/admin_login.php');
                }

            

                }else{
                $message = "wrong password";
                
            }

        }else {
        $message ='User does not exist!';
    }

    return $message;  
     
}



function confirm_logged_in(){
    if(!isset($_SESSION['user_id'])){
        redirect_to('../index.php');
    }
}

function logout(){
    session_destroy();
    redirect_to('../index.php');
}


