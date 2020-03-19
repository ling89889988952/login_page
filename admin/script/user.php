<?php
function createUser($username,$password,$email){

    $pdo = Database::getInstance()->getConnection();  
    // check the $username whether exist or not in database
    $check_user_exist = 'SELECT * FROM tbl_user WHERE user_name = :username';
    $check_exist = $pdo->prepare($check_user_exist);
    $check_exist->execute(
        array(
            ':username' =>$username,
        )
        ); 
    $row = $check_exist->fetch(PDO::FETCH_ASSOC);

    // The $username do not exist
    if (!$row){
    // encrypted the password, based on the post password
        $create_user_query  = 'INSERT INTO tbl_user (user_name, user_password, user_email, user_login_count)';
        $create_user_query .= ' VALUES(:username, :password, :email, :login_count)';
        $create_user_set   = $pdo->prepare($create_user_query);
        $create_user_result = $create_user_set ->execute(
            array(
                ':username'    =>  $username,
                ':password'    =>  $password,
                ':email'       =>  $email,
                ':login_count' =>  '0',
            )
            );


        if($create_user_result){
            // sent the mail to the user and redirect to the admin_login page
            $message= 'Your account has been successfully created';
            redirect_to('admin_login.php');

        } else{
            return 'error!';
        }
    
}else{
    
    $message= 'The username is exist, please change your username';
}
return $message;
}


function getSingleUser($id){
    $pdo = Database::getInstance()->getConnection();  
    // TODO: execute the proper SQL query to fetch the user data 
    $find_user_data  = 'SELECT * FROM tbl_user WHERE user_id =:id';
    $query_user_data =  $pdo->prepare($find_user_data);
    $get_user_result = $query_user_data ->execute(
                        array(
                            ':id' =>$id,
                        )
                        );

    if($get_user_result){
        // TODO: if the execute is successful, return the user data
        // Otherwise, return an error messages
        return ($query_user_data);
        

    }else{
        return  "There have some problem";
    
}
}


function editUser($id,$username,$password,$email,$login_date){
    // TODO:Set the database connection
    $pdo = Database::getInstance()->getConnection();  
    // TODO:Run the proper SQL query to update tbl_user with proper values
    $update_user_data   = 'UPDATE tbl_user SET user_name=:username, user_password =:password, user_email = :email , user_login_count =user_login_count+1, user_login_time=:login_time WHERE user_id =:id';
    $update_user_set    = $pdo->prepare($update_user_data);
    $update_user_result = $update_user_set->execute(
                array(
                ':id'         =>  $id,
                ':username'   =>  $username ,
                ':password'   =>  $password,
                ':email'      =>  $email,
                ':login_time' =>  $login_date
                )
                );
    
    // TODO:if everything goes well, redirect user to index.php
    // Otherwise, return some error message
                if($update_user_result){
                    redirect_to('admin_logout.php');
                }else{
                    return ' wrong';
                }
    
    }