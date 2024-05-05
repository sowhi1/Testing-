<?php

session_start();
$errors=array();
  $errors1=array();
error_reporting(0);
header('X-XSS-Protection: 1; mode=block');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Disable PHP exposition
@ini_set('expose_php', 'off');


include ('config.php');
  $pass=md5(uniqid());
                        $pass2=sha1($pass.uniqid());
                        $password1=md5($password.uniqid());
                        $randy=password_hash($password1, PASSWORD_BCRYPT);
                        $password2=password_hash($randy, PASSWORD_ARGON2I);
                        $password3=md5(uniqid().$password2);  
						
/*----------------------------------------------- Login Start-------------------------------------- */

if (isset($_POST['login'])){

  $username=strip_tags(htmlspecialchars($_POST['username']));
  $password=strip_tags(htmlspecialchars($_POST['password']));

 //$password=password_hash($password, PASSWORD_ARGON2I);
//$password=sha1($password);
  //$password=password_hash($password, PASSWORD_DEFAULT);
  //$password= password_hash($password, PASSWORD_BCRYPT);
  //$password=password_hash($password, PASSWORD_DEFAULT);

  /*  if (empty($username)) {
      echo 
      "<script>window.open('index.php?uname=Please Enter Username','_self')</script>";
      exit();
    }
    if (empty($password)) {
      echo 
      "<script>window.open('index.php?upass=Please Enter Password','_self')</script>";
      exit();
    }  */




$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'users/?username='.$username,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);

curl_close($curl);


$response_data = json_decode($response);

// All user data exists in 'result' object
$user_data_u = $response_data->results;

// Traverse array and print employee data
foreach ($user_data_u as $user_log) {
  $data_user = array(
  'uname' => $user_log->username,
  'staff_name' => $user_log->staff_name,
  'password'=>$user_log->password
  );
}
$password6 = password_verify($password, $data_user['password']);

    if ($data_user['uname'] == $username && $data_user['password']==$password6 ){

        $_SESSION['username'] = $username;
        $_SESSION['staff_name'] = $data_user['staff_name'];
        $_SESSION['success'] = "you are logged in";
         $_SESSION['login_time'] = time();
		 
		 echo '  <script>Swal.fire({
       
	   html: `<strong>Login successful <br>Please wait while you are being redirected</strong>`,
	  icon: "success",
	  buttonsStyling: false,
	  confirmButtonText: "Close",
	  customClass: {
		  confirmButton: "btn btn-success btn-md"
	  }
  });</script>';
       //echo "<script>window.open('login.php?loc=Login Successfull!!!Please Wait you will be redirected ','_self')</script>";
      echo "<script>window.location.href='dashboard';</script>";
  
 } elseif ($data_user['uname'] != $username) {
 echo '<div class="alert alert-danger">Invalid credentials</div> ';
    //array_push($errors, "Username is Incorrect");
  } elseif ($data_user['password'] != $password6) {
 echo '<div class="alert alert-danger"> Invalid credentials</div> ';
    //array_push($errors, "Password is Incorrect");
  } 
}

/*----------------------------------------------- Login End-------------------------------------- */


/* --------------------------------Add Staff Start---------------------------- */

if (isset($_POST['sub_staff'])) {
    
   $pname=$_POST['fname'];
    $pname1=$_POST['lname'];
    $pdec=$_POST['role'];
     $ed=$_POST['semail'];
     $ed1=$_POST['sphone'];
    $support=$_POST['support_ad'];
    $image=$_POST['image'];
   
    $pname=ucfirst($pname);
    $pname1=ucfirst($pname1);
	
   $username12 = strstr($ed, '@', true); 
//echo $user;
   $username=$_SESSION['username'] ;
   
   $username1=$username12.mt_rand(01,99);

	$pass="password";

    $password=password_hash($pass, PASSWORD_ARGON2I);



 $curl5 = curl_init();

curl_setopt_array($curl5, array(
  CURLOPT_URL => $url.'users/?username='.$username1,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response5 = curl_exec($curl5);

curl_close($curl5);


$response_data5 = json_decode($response5);

// All user data exists in 'result' object
$user_data5 = $response_data5->results;

// Traverse array and print employee data
foreach ($user_data5 as $user5) {
  $funame=$user5->username;

}

if($funame == $username1){
	
	 echo '
      <script>Swal.fire({
           
             html: `<strong>Error!!!</strong> <br />There was a username conflict. Please re-submit the form again to generate another username.`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
	
	
}else{

    
    
    
   



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'staff/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('fname' => $pname,'lname' => $pname1,'staff_role' => $pdec,'staff_email' => $ed,'creator' =>$_SESSION['staff_name'],'phonenumber'=>$ed1,'is_ticket_master'=>$support,'image'=>$image),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$array = json_decode($response, true);
$staff = $array['id'];
curl_close($curl);



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'users/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username'=>$username1,'password' => $password,'creator' => $_SESSION['staff_name'],'staff'=>$staff),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);
$httpCode2 = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

   if ($httpCode >= 200 && $httpCode < 300 && $httpCode2 >= 200 && $httpCode2 < 300) {
   

      echo '<script>Swal.fire({
       
        html: `<strong>Success!!!</strong><br />Member successfully added`,
       icon: "success",
       buttonsStyling: false,
       confirmButtonText: "Close",
       customClass: {
           confirmButton: "btn btn-success btn-md"
       }
    });</script>
     <script type="text/javascript">
  $("#exampleModalLg").modal("hide");
</script>
    <script type="text/javascript">
        window.location.reload();  
    </script>';
        } else {
    
          echo '
      <script>Swal.fire({
           
             html: `<strong>Failed!!!</strong> <br />We encountered an error. Please try again later or contact Faab Systems Ghana Ltd for further assitance.' . $httpCode . '/'.$httpCode2.'`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
        }

}

}


/* -------------------------------Add Staff End-------------------- */



if (isset($_POST['add_user'])) {
    
   $username1=$_POST['username1'];
   $staff=$_POST['staff'];
    $username=$_SESSION['username'] ;
    $pass="password";

    $password=password_hash($pass, PASSWORD_ARGON2I);
   //$password=sha1($pass);
   //$password=password_hash($pass, PASSWORD_BCRYPT);
   //$password= password_hash($pass, PASSWORD_BCRYPT);
    //$password=password_hash($pass, PASSWORD_DEFAULT);
    
   // $sd=$_POST['sd'];
    //$ed=$_POST['ed'];

/*  if (empty($username1)) {
      echo 
      "<script>window.open('../../view/auth/add_user?last=Please Enter Username','_self')</script>";
      exit();
  } */


     /* $curl56 = curl_init();

curl_setopt_array($curl56, array(
  CURLOPT_URL => $url.'users/?username='.$username,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response56 = curl_exec($curl56);

curl_close($curl56);


$response_data5 = json_decode($response5);

// All user data exists in 'result' object
$user_data56 = $response_data56->results;
$user_data55 = $response_data56->count;

// Traverse array and print employee data
foreach ($user_data56 as $user56) {



} */


   $curl5 = curl_init();

curl_setopt_array($curl5, array(
  CURLOPT_URL => $url.'users/?username='.$username1,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response5 = curl_exec($curl5);

curl_close($curl5);


$response_data5 = json_decode($response5);

// All user data exists in 'result' object
$user_data5 = $response_data5->results;
$user_data55 = $response_data5->count;

// Traverse array and print employee data
foreach ($user_data5 as $user5) {

  if ($user5->username ==$username1) {
    // code...
  
  $funame=$user5->fullname;
  $uname=$user5->username;
}

}

    
   
    
if ($uname == $username1) {

  echo "<script>window.open('../../view/auth/add_user?loc1=Username Already Exist','_self')</script>";
}else{

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'users/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username'=>$username1,'password' => $password,'creator' => $_SESSION['username'],'staff'=>$staff),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode >= 200 && $httpCode < 300) {

echo "<script>window.open('../../view/auth/add_user?loc=User has been Successfully Created','_self')</script>";
}else{
  echo "<script>window.open('../../view/auth/add_user?loc1=User cannot be added','_self')</script>";


}
}
}




if (isset($_POST['sub_team'])) {
    
    
   $pass=md5(uniqid());
                        $pass2=sha1($pass.uniqid());
                        $password1=md5($password.uniqid());
                        $randy=password_hash($password1, PASSWORD_BCRYPT);
                        $password2=password_hash($randy, PASSWORD_ARGON2I);
                        $password3=md5(uniqid().$password2);  

/*     $curl5 = curl_init();

curl_setopt_array($curl5, array(
  CURLOPT_URL => $url.'users/?username='.$username,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response5 = curl_exec($curl5);

curl_close($curl5);


$response_data5 = json_decode($response5);

// All user data exists in 'result' object
$user_data5 = $response_data5->results;

// Traverse array and print employee data
foreach ($user_data5 as $user5) {
  $funame=$user5->fullname;

} */
for($i=0;$i<count($_POST['slno']);$i++){
                  
				  $pid=$_POST['staff'][$i];
					$pdec=$_POST['role'][$i];
					$p_id=$_POST['project_id'][$i];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'team/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('name'=>$pid,'role' => $pdec,'project' => $p_id,'creator' => $_SESSION['username']),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

}
if ($httpCode >= 200 && $httpCode < 300) {

echo "<script>window.open('../../view/team/add_team?userid=".$password2."&dat9=".$randy.$pass2."&comp=".$password3."&user=".$p_id."&data=".$password1."&daty=".$pass2.$pass2."&loc=Team Member(s) has been Successfully added','_self')</script>";
}else{
  echo "<script>window.open('../../view/team/add_team?userid=".$password2."&dat9=".$randy.$pass2."&comp=".$password3."&user=".$p_id."&data=".$password1."&daty=".$pass2.$pass2."&loc1=Team Member(s) could not be added','_self')</script>";

}


}


/* ------------------------------------Add New Project Start----------------------- */

if (isset($_POST['sub_add_project'])) {
    
    $pname= $_POST['pname'];    
    $pdec=$_POST['pdec'];
    $sd=$_POST['sd'];
    $ed=$_POST['ed'];
    $image=$_POST['card1'];
  

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'projects/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('name' => $pname,'start_date' => $sd,'end_date' => $ed,'description' => $pdec, 'image' => $image,'status'=>'1','creator'=>$_SESSION['staff_name']),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

   if ($httpCode >= 200 && $httpCode < 300) {
   

      echo '<script>Swal.fire({
       
        html: `<strong>Success!!!</strong><br />Project successfully created`,
       icon: "success",
       buttonsStyling: false,
       confirmButtonText: "Close",
       customClass: {
           confirmButton: "btn btn-success btn-md"
       }
    });</script>
     <script type="text/javascript">
  $("#exampleModalLg").modal("hide");
</script>
    <script type="text/javascript">
        window.location.reload();  
    </script>';
        } else {
    
          echo '
      <script>Swal.fire({
           
             html: `<strong>Failed!!!</strong> <br />We encountered an error. Please try again later or contact Faab Systems Ghana Ltd for further assitance.' . $httpCode . '`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
        }
  


}

/* ------------------------------------Add New Project End----------------------- */

if (isset($_POST['sub_mile'])) {
    
    $cd=$_POST['cd'];
    $mile=$_POST['mile'];
    $stat1=$_POST['stat1'];
    $stat2=$_POST['stat2'];
    $p_id=$_POST['p_id'];
    $prio=$_POST['prio'];
    
    /**$usrmail=mysqli_real_escape_string($db,$_POST['usrmail']);
    $rela=mysqli_real_escape_string($db,$_POST['rela']);
    $funame=mysqli_real_escape_string($db,$_POST['funame']);
    $usradd1=mysqli_real_escape_string($db,$_POST['usradd1']);
    $homet1=mysqli_real_escape_string($db,$_POST['homet1']);
    $phone1=mysqli_real_escape_string($db,$_POST['phone1']);
    $sch=mysqli_real_escape_string($db,$_POST['sch']);
    $inst=mysqli_real_escape_string($db,$_POST['inst']);
    $yr=mysqli_real_escape_string($db,$_POST['yr']);
    $sub_met=mysqli_real_escape_string($db,$_POST['sub_met']);
    $supp=mysqli_real_escape_string($db,$_POST['supp']);
    $info1=mysqli_real_escape_string($db,$_POST['info1']); 
    $date= date('l')." ".date("d-m-Y H:i:s");
    // $uname=$_SESSION['username'];   **/

  

   /*  if ($stat2=="") {
      $stat2="";
    }
     */
    
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'tasks/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('name' => $mile,'end_date' => $cd,'status' => $stat1,'project' => $p_id,'user' =>$stat2,'priority'=>$prio),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response3 = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode >= 200 && $httpCode < 300) {
  $errorResponse1 = substr($response3, strpos($response3, "\r\n\r\n") + 1);
  $errorResponse = substr($errorResponse1, 0,-3);

 echo '<div class="alert alert-success"><h4> Issue Successfully Added</h4></div>
 <script type="text/javascript">
    window.location.reload();  
</script>
 ';
}else{
 echo '<div class="alert alert-danger"> An Error occured trying to add issue '.$httpCode.'</div> ';

}

/* $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode >= 200 && $httpCode < 300) {

echo "<script>window.open('../../view/milestone/add_mile?userid=".$password2."&dat9=".$randy.$pass2."&comp=".$password3."&user=".$p_id."&data=".$password1."&daty=".$pass2.$pass2."&updated=Issue has been Successfully added','_self')</script>";
}else{
	$errorResponse1 = substr($response, strpos($response, "\r\n\r\n") + 120);
  $errorResponse = substr($errorResponse1, 0,-3);
  echo "<script>window.open('../../view/milestone/add_mile?userid=".$password2."&dat9=".$randy.$pass2."&comp=".$password3."&user=".$p_id."&data=".$password1."&daty=".$pass2.$pass2."&deleted=Issue could not be added','_self')</script>";

} */


    
    
  }


  if (isset($_POST['sub_iss'])) {
    
    
    $mile=$_POST['mile_id'];
   
    $idec=$_POST['idec'];
    $istat=$_POST['stat2'];
    
    /**$usrmail=mysqli_real_escape_string($db,$_POST['usrmail']);
    $rela=mysqli_real_escape_string($db,$_POST['rela']);
    $funame=mysqli_real_escape_string($db,$_POST['funame']);
    $usradd1=mysqli_real_escape_string($db,$_POST['usradd1']);
    $homet1=mysqli_real_escape_string($db,$_POST['homet1']);
    $phone1=mysqli_real_escape_string($db,$_POST['phone1']);
    $sch=mysqli_real_escape_string($db,$_POST['sch']);
    $inst=mysqli_real_escape_string($db,$_POST['inst']);
    $yr=mysqli_real_escape_string($db,$_POST['yr']);
    $sub_met=mysqli_real_escape_string($db,$_POST['sub_met']);
    $supp=mysqli_real_escape_string($db,$_POST['supp']);
    $info1=mysqli_real_escape_string($db,$_POST['info1']); **/
   





    
   
    
       $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'issues/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('task' => $mile,'description' => $idec,'status'=>$istat),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode >= 200 && $httpCode < 300) {

 echo '<div class="alert alert-success"><h4> Action Successfully Added</h4></div> ';
}else{
 echo '<div class="alert alert-danger"> An Error occured trying to add action</div> ';

}

/* $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode >= 200 && $httpCode < 300) {

echo "<script>window.open('../../view/issue/add_issue?userid=".$password2."&dat9=".$randy.$pass2."&comp=".$password3."&user=".$mile."&data=".$password1."&daty=".$pass2.$pass2."&updated=Action has been Successfully added','_self')</script>";
}else{
	$errorResponse1 = substr($response, strpos($response, "\r\n\r\n") + 120);
  $errorResponse = substr($errorResponse1, 0,-3);
  echo "<script>window.open('../../view/issue/add_issue?userid=".$password2."&dat9=".$randy.$pass2."&comp=".$password3."&user=".$mile."&data=".$password1."&daty=".$pass2.$pass2."&deleted=Action could not be added','_self')</script>";

} */
    
    
    
    
  } 

/* ---------------------Update Staff start------------------------------------- */

if (isset($_POST['update_staff'])) {
    
    $pname=$_POST['sfname'];
    $pname1=$_POST['slname'];
    $pdec=$_POST['srole'];
     $ed=$_POST['ssemail'];
     $ed1=$_POST['ssphone'];
    $support=$_POST['staff_ad'];
    $staff_id=$_POST['staff_id'];



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'staff/'.$staff_id.'/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PATCH',
  CURLOPT_POSTFIELDS => array('fname' => $pname,'lname' => $pname1,'staff_role' => $pdec,'staff_email' => $ed,'phonenumber'=>$ed1,'is_ticket_master'=>$support),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
 if ($httpCode >= 200 && $httpCode < 300) {
   

      echo '<script>Swal.fire({
       
        html: `<strong>Success!!!</strong><br />Staff successfully updated`,
       icon: "success",
       buttonsStyling: false,
       confirmButtonText: "Close",
       customClass: {
           confirmButton: "btn btn-success btn-md"
       }
    });</script>
     <script type="text/javascript">
  $("#exampleModalLg").modal("hide");
</script>
    <script type="text/javascript">
        window.location.reload();  
    </script>';
        } else {
    
          echo '
      <script>Swal.fire({
           
             html: `<strong>Failed!!!</strong> <br />We encountered an error. Please try again later or contact Faab Systems Ghana Ltd for further assitance.' . $httpCode . '`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
        }

}

/* ---------------------Update Staff end------------------------------------- */



/* ---------------------Update Project start------------------------------------- */

if (isset($_POST['update_project'])) {
    
    $pname= $_POST['pname1'];    
    $pdec=$_POST['pdec1'];
    $stat=$_POST['stat1'];
    $sd=$_POST['sd1'];
    $ed=$_POST['ed1'];
    $pro_id=$_POST['project_id'];
	
	
	 $curl5 = curl_init();

  curl_setopt_array($curl5, array(
    CURLOPT_URL => $url . 'tasks/?project='. $pro_id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'username: ' . $ap_user . '',
      'password: ' . $ap_pass . '',
      'Authorization: Token ' . $tok . ''
    ),
  ));

  $response5 = curl_exec($curl5);

  curl_close($curl5);


  $response_data5 = json_decode($response5);

  // All user data exists in 'result' object
  $user_data5 = $response_data5->results;

 $count = 0;

// Traverse array and count records where status is not equal to 8
foreach ($user_data5 as $user5) {
    $pro_stat = $user5->status;
    if ($pro_stat != 8) {
        $count++;
    }
}


	if($stat == "8" && $count > 0){
	
	 echo '
      <script>Swal.fire({
           
             html: `<strong>Sorry!!!</strong> <br />There is/are <b>'.$count.'</b> uncompleted milestone(s).Please check and make sure all milestones are completed.`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
        
	
}else{

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'projects/'.$pro_id.'/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PATCH',
  CURLOPT_POSTFIELDS => array('name' => $pname,'start_date' => $sd,'end_date' => $ed,'description' => $pdec,'status' =>$stat),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
 if ($httpCode >= 200 && $httpCode < 300) {
   

      echo '<script>Swal.fire({
       
        html: `<strong>Success!!!</strong><br />Project successfully updated`,
       icon: "success",
       buttonsStyling: false,
       confirmButtonText: "Close",
       customClass: {
           confirmButton: "btn btn-success btn-md"
       }
    });</script>
     <script type="text/javascript">
  $("#exampleModalLg").modal("hide");
</script>
    <script type="text/javascript">
        window.location.reload();  
    </script>';
        } else {
    
          echo '
      <script>Swal.fire({
           
             html: `<strong>Failed!!!</strong> <br />We encountered an error. Please try again later or contact Faab Systems Ghana Ltd for further assitance.' . $httpCode . '`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
        }
}
}

/* ---------------------Update Project end------------------------------------- */



/* ---------------------Update Milestone start------------------------------------- */

if (isset($_POST['update_mile'])) {
    
    $m_name= $_POST['pname12'];    
    $m_stat=$_POST['stat12'];
    
    $cd=$_POST['cd'];
    $member=$_POST['member'];
    
    $m_id=$_POST['mile_id2'];


 $curl5 = curl_init();

  curl_setopt_array($curl5, array(
    CURLOPT_URL => $url . 'issues/?task='. $m_id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'username: ' . $ap_user . '',
      'password: ' . $ap_pass . '',
      'Authorization: Token ' . $tok . ''
    ),
  ));

  $response5 = curl_exec($curl5);

  curl_close($curl5);


  $response_data5 = json_decode($response5);

  // All user data exists in 'result' object
  $user_data5 = $response_data5->results;

 $count = 0;

// Traverse array and count records where status is not equal to 3
foreach ($user_data5 as $user5) {
    $pro_stat = $user5->status;
    if ($pro_stat != 3) {
        $count++;
    }
}


	if($stat == "3" && $count > 0){
	
	 echo '
      <script>Swal.fire({
           
             html: `<strong>Sorry!!!</strong> <br />There is/are <b>'.$count.'</b> unresolved issue(s).Please check and make sure all issues are resolved.`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
        
	
}else{
   


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'tasks/'.$m_id.'/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PATCH',
  CURLOPT_POSTFIELDS => array('name' => $m_name,'end_date' => $cd,'status' =>$m_stat,'user'=>$member),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);
//echo $response;
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

 if ($httpCode >= 200 && $httpCode < 300) {
   

      echo '<script>Swal.fire({
       
        html: `<strong>Success!!!</strong><br />Milestone successfully updated`,
       icon: "success",
       buttonsStyling: false,
       confirmButtonText: "Close",
       customClass: {
           confirmButton: "btn btn-success btn-md"
       }
    });</script>
     <script type="text/javascript">
  $("#exampleModalLg").modal("hide");
</script>
    <script type="text/javascript">
        window.location.reload();  
    </script>';
        } else {
    
          echo '
      <script>Swal.fire({
           
             html: `<strong>Failed!!!</strong> <br />We encountered an error. Please try again later or contact Faab Systems Ghana Ltd for further assitance.' . $httpCode . '`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
        }
}
}
/* ---------------------Update Milestone end------------------------------------- */

/* ---------------------Update Issue Start------------------------------------- */

if (isset($_POST['update_issue'])) {
    
    $idec= $_POST['pname123'];    
     $is_stat=$_POST['stat112'];
    
   /** $cd=$_POST['cd']; **/
    
    $issue_id=$_POST['iss_id2'];
    $member=$_POST['member2'];


  $curl5 = curl_init();

  curl_setopt_array($curl5, array(
    CURLOPT_URL => $url . 'actions/actions/?issue='.$issue_id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'username: ' . $ap_user . '',
      'password: ' . $ap_pass . '',
      'Authorization: Token ' . $tok . ''
    ),
  ));

  $response5 = curl_exec($curl5);

  curl_close($curl5);


  $response_data5 = json_decode($response5);

  // All user data exists in 'result' object
  $user_data5 = $response_data5->results;

 $count = 0;

// Traverse array and count records where status is not equal to 3
foreach ($user_data5 as $user5) {
    $pro_stat4 = $user5->status;
    if ($pro_stat4 != 3) {
        $count++;
    }
}


	if($stat == "3" && $count > 0){
	
	 echo '
      <script>Swal.fire({
           
             html: `<strong>Sorry!!!</strong> <br />There is/are <b>'.$count.'</b> unresolved action(s).Please check and make sure all actions are resolved.`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
        
	
}else{
   



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'issues/'.$issue_id.'/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PATCH',
  CURLOPT_POSTFIELDS => array('description' => $idec,'status'=>$is_stat,'user'=>$member),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);
//echo $response;
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

 if ($httpCode >= 200 && $httpCode < 300) {
   

      echo '<script>Swal.fire({
       
        html: `<strong>Success!!!</strong><br />Issue successfully updated`,
       icon: "success",
       buttonsStyling: false,
       confirmButtonText: "Close",
       customClass: {
           confirmButton: "btn btn-success btn-md"
       }
    });</script>
     <script type="text/javascript">
  $("#exampleModalLg").modal("hide");
</script>
    <script type="text/javascript">
        window.location.reload();  
    </script>';
        } else {
    
          echo '
      <script>Swal.fire({
           
             html: `<strong>Failed!!!</strong> <br />We encountered an error. Please try again later or contact Faab Systems Ghana Ltd for further assitance.' . $httpCode . '`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
        }
}
}

/* ---------------------Update Issue end------------------------------------- */




/* ---------------------Update Action Start------------------------------------- */

if (isset($_POST['update_action'])) {
    
    $idec= $_POST['pname1123'];    
     $is_stat=$_POST['stat1112'];
    
   /** $cd=$_POST['cd']; **/
    
    $issue_id=$_POST['act_id2'];
    $member=$_POST['member12'];


  


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'actions/actions/'.$issue_id.'/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PATCH',
  CURLOPT_POSTFIELDS => array('description' => $idec,'status'=>$is_stat,'user'=>$member),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);
//echo $response;
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

 if ($httpCode >= 200 && $httpCode < 300) {
   

      echo '<script>Swal.fire({
       
        html: `<strong>Success!!!</strong><br />Action successfully updated`,
       icon: "success",
       buttonsStyling: false,
       confirmButtonText: "Close",
       customClass: {
           confirmButton: "btn btn-success btn-md"
       }
    });</script>
     <script type="text/javascript">
  $("#exampleModalLg").modal("hide");
</script>
    <script type="text/javascript">
        window.location.reload();  
    </script>';
        } else {
    
          echo '
      <script>Swal.fire({
           
             html: `<strong>Failed!!!</strong> <br />We encountered an error. Please try again later or contact Faab Systems Ghana Ltd for further assitance.' . $httpCode . '`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
        }

}

/* ---------------------Update Action end------------------------------------- */


/* -----------------Initial Password reset start----------------- */


if (isset($_POST['sub_change'])) {

  $username = $_SESSION['username'];

  $sd = $_POST['password'];
  $ed = $_POST['password1'];

  $curl5 = curl_init();

  curl_setopt_array($curl5, array(
    CURLOPT_URL => $url . 'users/?username=' . $_SESSION['username'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'username: ' . $ap_user . '',
      'password: ' . $ap_pass . '',
      'Authorization: Token ' . $tok . ''
    ),
  ));

  $response5 = curl_exec($curl5);

  curl_close($curl5);


  $response_data5 = json_decode($response5);

  // All user data exists in 'result' object
  $user_data5 = $response_data5->results;

  // Traverse array and print employee data
  foreach ($user_data5 as $user5) {
  }


    $password = password_hash($sd, PASSWORD_ARGON2I);
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url . 'users/' . $user5->id . '/',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'PATCH',
      CURLOPT_POSTFIELDS => array('password' => $password, 'password_reset_code' => "1"),
      CURLOPT_HTTPHEADER => array(
        'username: ' . $ap_user . '',
        'password: ' . $ap_pass . '',
        'Authorization: Token ' . $tok . ''
      ),
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    //echo $response;



    if ($httpCode >= 200 && $httpCode < 300) {
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $url . 'payroll/audit-trails/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('process_id' => "Initial Password Change", 'ip_address' => $_SERVER['REMOTE_ADDR'], 'browser' => $_SERVER['HTTP_USER_AGENT'], 'company' => $_SESSION['company1'], 'user_id' => $_SESSION['u_id']),
        CURLOPT_HTTPHEADER => array(
          'username: ' . $ap_user . '',
          'password: ' . $ap_pass . '',
          'Authorization: Token ' . $tok . ''
        ),
      ));

      $response = curl_exec($curl);


      curl_close($curl);

      echo '<script>Swal.fire({
       
        html: `<strong>Success!!!</strong><br />You have successfully verified your account.Please wait while we redirect you`,
       icon: "success",
       buttonsStyling: false,
       confirmButtonText: "Close",
       customClass: {
           confirmButton: "btn btn-success btn-md"
       }
    });</script>
    
    <script type="text/javascript">
        window.location.reload();  
    </script>';
        } else {
    
          echo '
      <script>Swal.fire({
           
             html: `<strong>Failed!!!</strong> <br />We encountered an error. Please try again later or contact Faab Systems Ghana Ltd for further asssitance.' . $httpCode . '`,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
                confirmButton: "btn btn-danger btn-md"
            }
        });</script>
    
      ';
        }
  
}

/* -----------------Initial Password reset start----------------- */



/*--------------------- Admin reset user password------------------ */
if (isset($_POST['urline_id'])) {



    $t_id = $_POST['urline_id'];
    $d_id = $_POST['uremp_a'];
	
	
	$pass="password";

    $password=password_hash($pass, PASSWORD_ARGON2I);
	

    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'users/'.$t_id.'/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PATCH',
  CURLOPT_POSTFIELDS => array('password' => $password,'password_reset_code'=>"0"),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
 

    if ($httpCode >= 200 && $httpCode < 300) {
       

        // Process the response data here
        echo '  <script>Swal.fire({
       
    html: `<strong>Success!!!</strong><br /><b>' . $d_id . '</b> password has successfully been reset `,
   icon: "success",
   buttonsStyling: false,
   confirmButtonText: "Close",
   customClass: {
       confirmButton: "btn btn-success btn-md"
   }
});</script>

<script type="text/javascript">
    window.location.reload();  
</script>
';
    } else {
        $errorResponse1 = substr($response, strpos($response, "\r\n\r\n") + 120);
        $errorResponse = substr($errorResponse1, 0, -3);
        echo '  <script>Swal.fire({
       
         html: `<strong>Failed!!!</strong> <br />We encountered an error. Please try again later or contact Faab Systems Ghana Ltd for further asssitance.'.$httpCode.'`,
        icon: "error",
        buttonsStyling: false,
        confirmButtonText: "Close",
        customClass: {
            confirmButton: "btn btn-danger btn-md"
        }
    });</script>';
    }
}

/*--------------------- Admin reset user password End------------------ */


 if (isset($_POST['sub_change1'])) {
    
    $username=$_SESSION['username'] ;  
   
    $sd=$_POST['password'];
    $ed=$_POST['password1'];
    $op=$_POST['op'];

    //$op1=sha1($op);

$curl5 = curl_init();

curl_setopt_array($curl5, array(
  CURLOPT_URL => $url.'users/?username='.$username,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response5 = curl_exec($curl5);

curl_close($curl5);


$response_data5 = json_decode($response5);

// All user data exists in 'result' object
$user_data5 = $response_data5->results;

// Traverse array and print employee data
foreach ($user_data5 as $user5) {
  $funame=$user5->password;

}
   if (empty($op)) {
      echo 
      "<script>window.open('../../view/auth/ch_ps?sex2=Please Enter Current Password','_self')</script>";
      exit(); 
    }  
    if (empty($sd)) {
      echo 
      "<script>window.open('../../view/auth/ch_ps?sex=Please Enter Password','_self')</script>";
      exit(); 
    }
    if (empty($ed)) {
      echo 
      "<script>window.open('../../view/auth/ch_ps?sex1=Please Confirm Password','_self')</script>";
      exit(); 
    } 
   
$op1 = password_verify($op, $funame);

 $uppercase = preg_match('@[A-Z]@', $sd);
    $lowercase = preg_match('@[a-z]@', $sd);
    $number    = preg_match('@[0-9]@', $sd);
    $specialChars = preg_match('@[^\w]@', $sd);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($sd) < 8) {

      echo "<script>window.open('../../view/auth/ch_ps?error=Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character','_self')</script>";
      
    }
    if ($sd != $ed) {
      echo "<script>window.open('../../view/auth/ch_ps?error=The Two Passwords do not match','_self')</script>";
    }
    if($funame!=$op1){

      echo "<script>window.open('../../view/auth/ch_ps?error=Your Current Password is Incorrect','_self')</script>";
    }

   else{
      $password=password_hash($sd, PASSWORD_ARGON2I);
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url.'users/'.$user5->id.'/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PATCH',
  CURLOPT_POSTFIELDS => array('password' => $password),
  CURLOPT_HTTPHEADER => array(
    'username: '.$ap_user.'',
    'password: '.$ap_pass.'',
    'Authorization: Token '.$tok.''
  ),
));

$response = curl_exec($curl);

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode >= 200 && $httpCode < 300) {
echo "<script>window.open('../../view/auth/ch_ps?changed=Password Change Successful','_self')</script>";
}else{
  echo "<script>window.open('../../view/auth/ch_ps?error=Your Current Password is Incorrect','_self')</script>";


}


   }

} 
if (isset($_GET['logout'])) {
     session_destroy();
    unset($_SESSION['username']);
    
    //header('refresh:2; url= home.php'). "<b style= color:green;>"."logged in as "."$user->first_name "." "."$user->last_name "."</b>";
     echo "<script>window.open('../auth/?loc=1','_self')</script>";  
  }


  if (isset($_GET['logout1'])) {
    session_destroy();
    unset($_SESSION['username']);
    
    //header('refresh:2; url= home.php'). "<b style= color:green;>"."logged in as "."$user->first_name "." "."$user->last_name "."</b>";
    echo "<script>window.open('index.php?loc0=Session Expired Due to Inactivity','_self')</script>";
  }

?>

