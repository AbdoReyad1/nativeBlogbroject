<?php


abstract class User
{

    public $id;
    public $name;
    public $email;
    public $phone;
    public $image;
    protected $password;
    public $created_at;
    public $updated_at;

    function    __construct($id,$name,$email,$password,$phone,$image,$created_at,$updated_at)
    {


        $this->id=$id;
        $this->name=$name;
        $this->email=$email;
        $this->password=$password;
        $this->phone=$phone;
        $this->image=$image;

        $this->created_at=$created_at;
        $this->updated_at=$updated_at;

    }








    public static function login($email,$password){
        $user =null;
        $qry="SELECT * FROM USERS WHERE email='$email' AND password='$password' ";
        require('config.php');
        $cn =mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        if ($arr = mysqli_fetch_assoc($rslt)) {

            switch ($arr["role"]) {
                case 'subscriber':
                    $user = new subscriber($arr["id"],$arr["name"],$arr["email"],$arr["password"],$arr["phone"],$arr["image"],$arr["created_at"],$arr["updated_at"]);

                    break;
                    case 'admin':
                        $user = new Admin($arr["id"],$arr["name"],$arr["email"],$arr["password"],$arr["phone"],$arr["image"],$arr["created_at"],$arr["updated_at"]);

                
            
                    break;
            }
        }
        
        mysqli_close($cn);
        return $user;
    }

}


class Subscriber extends User{


    
    public $role = "subscriber";
  
    



    
    public static function register($name,$email,$password,$phone){
           $qry = "INSERT INTO USERS (name,email,password,phone)
           VALUES ('$name' , '$email' , '$password' , '$phone')";
           require_once('config.php');
           $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
           $rslt = mysqli_query($cn,$qry);
           mysqli_close($cn);
           return $rslt;


        
    }

    public function store_post ($title,$content,$imageName,$user_id){

        $qry="INSERT INTO POSTS (title,content,image,user_id) VALUES('$title','$content','$imageName','$user_id')";

        require_once('config.php');
        $cn=mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function store_comment ($comment,$post_id,$user_id){

        $qry="INSERT INTO comments (comment,post_id,user_id) VALUES('$comment','$post_id',user_id)";

        require_once('config.php');
        $cn=mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function my_posts($user_id){
    $qry = "SELECT * FROM POSTS WHERE USER_ID = $user_id ";
    require_once('config.php');
    $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
    $rslt = mysqli_query($cn,$qry);
    $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
    mysqli_close($cn);
    return $data;

    }
    
    public function update_profile_pic ($imagepath,$user_id){
        $qry = "UPDATE TABLE USERS SET IMAGE = '$imagepath' WHERE id=$user_id ";
        require_once('config.php');
    $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
    mysqli_close($cn);
    $rslt = mysqli_query($cn,$qry);
    return $rslt;

    } 

    public function get_post_comment($post_id){
        $qry= "SELECT * FROM COMMENTS WHERE POST_ID=$post_id  ";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
          $rslt = mysqli_query($cn,$qry);  
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;


} 
}
class Admin extends User {

    public $role = "admin";
   

        
   
}





