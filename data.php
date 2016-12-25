<?php
// Database details
$db_server   = 'localhost';
$db_username = 'root';
$db_password = 'root';
$db_name     = 'datagrid';

// Get job (and id)
$job = '';
$id  = '';
if (isset($_GET['job'])){
  $job = $_GET['job'];
  if ($job == 'get_companies' || $job == 'get_company'   || $job == 'add_company'   || $job == 'edit_company'  || $job == 'delete_company'){
    if (isset($_GET['id'])){
      $id = $_GET['id'];
      if (!is_numeric($id)){
        $id = '';
      }
    }
  } else {
    $job = '';
  }
}

// Prepare array
$mysql_data = array();

// Valid job found
if ($job != ''){
  // echo "masuk sini";
  // Connect to database
  $db_connection = mysqli_connect($db_server, $db_username, $db_password, $db_name);
  if (mysqli_connect_errno()){
    $result  = 'error';
    $message = 'Failed to connect to database: ' . mysqli_connect_error();
    $job     = '';
  }
  
  // Execute job
  if ($job == 'get_companies'){
    
    // Get companies
    $query = "SELECT * FROM patientdata ORDER BY Name";
    $query = mysqli_query($db_connection, $query);
    if (!$query){
      $result  = 'error';
      $message = 'query error';
    } else {
      $result  = 'success';
      $message = 'query success';
      while ($company = mysqli_fetch_array($query)){
        $functions  = '<div class="function_buttons"><ul>';
        $functions .= '<li class="function_edit"><a data-id="'   . $company['id'] . '" data-name="' . $company['Name'] . '"><span>Edit</span></a></li>';
        $functions .= '<li class="function_delete"><a data-id="' . $company['id'] . '" data-name="' . $company['Name'] . '"><span>Delete</span></a></li>';
        $functions .= '</ul></div>';
        $mysql_data[] = array(
          "id" => $company['id'],
          "Name"  => $company['Name'],
          "ICNO"  => $company['ICNO'],
          "PRNO"  => $company['PRNO'],
          "Address"  => $company['Address'],
          "Occupation"  => $company['Occupation'],
          "Age"  => $company['Age'],
          "Gender"  => $company['Gender'],
          "ContactNo"  => $company['ContactNo'],  
          "Nationality"  => $company['Nationality'],
          "EmergencyContact" => $company['EmergencyContact'],
          "functions" => $functions
        );
      }
    }
    
  } elseif ($job == 'get_company'){
    
    // Get company
    if ($id == ''){
      $result  = 'error';
      $message = 'id missing';
    } else {
      $query = "SELECT * FROM patientdata WHERE id = '" . mysqli_real_escape_string($db_connection, $id) . "'";
      $query = mysqli_query($db_connection, $query);
      if (!$query){
        $result  = 'error';
        $message = 'query error';
      } else {
        $result  = 'success';
        $message = 'query success';
        while ($company = mysqli_fetch_array($query)){
          $mysql_data[] = array(
            "id" => $company['id'],
            "Name"  => $company['Name'],
            "ICNO"  => $company['ICNO'],
            "PRNO"    => $company['PRNO'],
            "Address"    => $company['Address'],
            "Occupation"    => $company['Occupation'],
            "Age"    => $company['Age'],
            "Gender"    => $company['Gender'],
            "ContactNo"    => $company['ContactNo'],  
            "Nationality"    => $company['Nationality'],
            "EmergencyContact"    => $company['EmergencyContact']
          );
        }
      }
    }
  
  } elseif ($job == 'add_company'){
    
    // Add company
    $query = "INSERT INTO patientdata SET ";
    if (isset($_GET['Name'])) { $query .= "Name = '" . mysqli_real_escape_string($db_connection, $_GET['Name']) . "', "; }
    if (isset($_GET['ICNO']))   { $query .= "ICNO   = '" . mysqli_real_escape_string($db_connection, $_GET['ICNO'])   . "', "; }
    if (isset($_GET['PRNO']))      { $query .= "PRNO      = '" . mysqli_real_escape_string($db_connection, $_GET['PRNO'])      . "', "; }
    if (isset($_GET['Address']))  { $query .= "Address  = '" . mysqli_real_escape_string($db_connection, $_GET['Address'])  . "', "; }
    if (isset($_GET['Occupation']))    { $query .= "Occupation    = '" . mysqli_real_escape_string($db_connection, $_GET['Occupation'])    . "', "; }
    if (isset($_GET['Age']))   { $query .= "Age   = '" . mysqli_real_escape_string($db_connection, $_GET['Age'])   . "', "; }
    if (isset($_GET['Gender'])) { $query .= "Gender = '" . mysqli_real_escape_string($db_connection, $_GET['Gender']) . "'";   }
    if (isset($_GET['ContactNo'])) { $query .= "ContactNo = '" . mysqli_real_escape_string($db_connection, $_GET['ContactNo']) . "'";   }
    if (isset($_GET['Nationality'])) { $query .= "Nationality = '" . mysqli_real_escape_string($db_connection, $_GET['Nationality']) . "'";   }
    if (isset($_GET['EmergencyContact'])) { $query .= "EmergencyContact = '" . mysqli_real_escape_string($db_connection, $_GET['EmergencyContact']) . "'";   }
    $query = mysqli_query($db_connection, $query);
    if (!$query){
      $result  = 'error';
      $message = 'query error';
    } else {
      $result  = 'success';
      $message = 'query success';
    }
  
  } elseif ($job == 'edit_company'){
    
    // Edit company
    if ($id == ''){
      $result  = 'error';
      $message = 'id missing';
    } else {
      $query = "UPDATE patientdata SET ";
      if (isset($_GET['Name'])) { $query .= "Name = '" . mysqli_real_escape_string($db_connection, $_GET['Name']) . "', "; }
      if (isset($_GET['ICNO']))   { $query .= "ICNO   = '" . mysqli_real_escape_string($db_connection, $_GET['ICNO'])   . "', "; }
      if (isset($_GET['PRNO']))      { $query .= "PRNO      = '" . mysqli_real_escape_string($db_connection, $_GET['PRNO'])      . "', "; }
      if (isset($_GET['Address']))  { $query .= "Address  = '" . mysqli_real_escape_string($db_connection, $_GET['Address'])  . "', "; }
      if (isset($_GET['Occupation']))    { $query .= "Occupation    = '" . mysqli_real_escape_string($db_connection, $_GET['Occupation'])    . "', "; }
      if (isset($_GET['Age']))   { $query .= "Age   = '" . mysqli_real_escape_string($db_connection, $_GET['Age'])   . "', "; }
      if (isset($_GET['Gender'])) { $query .= "Gender = '" . mysqli_real_escape_string($db_connection, $_GET['Gender']) . "'";   }
      if (isset($_GET['ContactNo'])) { $query .= "ContactNo = '" . mysqli_real_escape_string($db_connection, $_GET['ContactNo']) . "'";   }
      if (isset($_GET['Nationality'])) { $query .= "Nationality = '" . mysqli_real_escape_string($db_connection, $_GET['Nationality']) . "'";   }
      if (isset($_GET['EmergencyContact'])) { $query .= "EmergencyContact = '" . mysqli_real_escape_string($db_connection, $_GET['EmergencyContact']) . "'";   }
      $query .= "WHERE id = '" . mysqli_real_escape_string($db_connection, $id) . "'";
      $query  = mysqli_query($db_connection, $query);
      if (!$query){
        $result  = 'error';
        $message = 'query error';
      } else {
        $result  = 'success';
        $message = 'query success';
      }
    }
    
  } elseif ($job == 'delete_company'){
  
    // Delete company
    if ($id == ''){
      $result  = 'error';
      $message = 'id missing';
    } else {
      $query = "DELETE FROM patientdata WHERE id = '" . mysqli_real_escape_string($db_connection, $id) . "'";
      $query = mysqli_query($db_connection, $query);
      if (!$query){
        $result  = 'error';
        $message = 'query error';
      } else {
        $result  = 'success';
        $message = 'query success';
      }
    }
  
  }
  
  // Close database connection
  mysqli_close($db_connection);

}

// Prepare data
$data = array(
  "result"  => $result,
  "message" => $message,
  "data"    => $mysql_data
);

// print_r($data);

// Convert PHP array to JSON array
$json_data = json_encode($data);
print $json_data;
?>