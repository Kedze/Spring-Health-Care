<?php 
  include 'connect-database.php';

  if(isset($_GET['reference']) && !empty($_GET['reference'])){
    $ref = $_GET['reference'];

    $curl = curl_init();
  
      curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($ref),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer sk_test_095d5e7ae7121e851b3a4e8767b44a31a5fe5745",
        "Cache-Control: no-cache",
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    

    $result = json_decode($response);
    $status = $result->data->status;
    
    $firstName = $result->data->metadata->first_name;
    $lastName = $result->data->metadata->last_name;
    $name = $lastName." ".$firstName;
    $department = $result->data->metadata->dep;
    $telephone = $result->data->metadata->tel;
    $email = $result->data->metadata->email;

    date_default_timezone_set('Africa/Accra');
    $Date_time = date('m/d/Y h:i a', time()); 

    $stmt = "INSERT INTO customer_details (status, reference, fullname, date_purchased, email) VALUES ('$status', '$ref', '$name', '$Date_time' ,'$email')";
    /*$stmt->bind_param("sssss", $status, $ref, $name, $Date_time, $email);
    $stmt->execute();*/
    if ($db->query($stmt) !== TRUE) {
      #code...
      echo 'There was a problem inserting data into the database';
    }else{
      header("Location: success.php?status=success");
      exit; 
    }

    $stmt->close();
    $db->close();

  }else {
    echo '
      <script type="text/javascript">
        alert("There was an error");
        window.location = "./";
      </script>
    ';
  }
?>