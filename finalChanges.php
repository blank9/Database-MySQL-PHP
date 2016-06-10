<?php
$name=$rollno=$dept=$email=$address=$aboutme="";
            $Ename=$Edept=$Eemail=$Eaddress="";
            $pwd="";
            $error=TRUE;
            $servername="localhost";
            $username="joy";
            $password="password";
            $dbname="mydb";
            $conn=new mysqli($servername,$username,$password,$dbname);
            if($conn->connect_error)
            {
                die("Connection Failed: ".$conn->connect_error);
            }
            else
                echo "Connected!<br>";
            

            $stmt=$conn->prepare("UPDATE student 
                SET Name=?,Department=?,Email=?,Address=?,Aboutme=?
                WHERE Rollno=?;");
            $stmt->bind_param("ssssss",$name,$dept,$email,$address,$aboutme,$rollno);

            if($_SERVER["REQUEST_METHOD"]=="POST")
            {
                if(empty($_POST["name"]))
                {
                    $Ename="Name can't be empty";
                    $error=TRUE;
                }
                else
                {
                    $name=validate($_POST["name"]);
                    if(!preg_match("/^[a-zA-Z ]*$/",$name))
                    {
                        $Ename="Only alphabets and spaces allowed in name";
                        $error=TRUE;
                    }
                    else
                    {
                        $error=FALSE;
                    }
                }
                
                $dept=$_POST["department"];
                if(empty($_POST["email"]))
                {
                    $Eemail="Email can't be empty";
                    $error=TRUE;
                }
                else
                {
                    $email=validate($_POST["email"]);
                    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
                    {
                        $Eemail="Improper email format";
                        $error=TRUE;
                    }
                    else
                    {
                        $error=FALSE;   
                    }
                }
                if(empty($_POST["address"]))
                {
                    $Eaddress="Address can't be empty";
                    $error=TRUE;
                }
                else
                {
                    $address=htmlspecialchars($_POST["address"]);
                    $error=FALSE;
                }

                $aboutme=htmlspecialchars($_POST["aboutme"]);
                $rollno=$_POST["rollno1"];


            }
            if(!$error)
            {
                if($stmt->execute())
                {
                    echo "<br>Successfully Edited!!";
                }
                else
                {
                    print_r(mysqli_error_list($conn));
                }
            }
            else
            {
                echo "Invalid Data";
            }
            function validate($data)
            {
                $data=trim($data);
                $data=stripslashes($data);
                $data=htmlspecialchars($data);
                return $data;
            }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
        body{
             font-family: "Comic Sans MS";
       }
       button{
            background-color: lightgrey;
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px;
            outline: none;
            font-size: 20px;
            box-shadow:1px 1px 0 grey;
            cursor: pointer;
      }
      button:active{
                box-shadow:0px 0px 0 grey;
                transform: translateY(1px);
                transform:translateX(1px);
     }
    </style>
    </head>
    <body>
        <br><br><a href="index.php"><button>RETURN</button></a>
    </body>
</html>
