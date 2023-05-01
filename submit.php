<?php include 'connection.php';?>
<?php
  session_start();
  $label = $date = $id = $checked = "";
  // submit item
  if(isset($_POST['formSubmit'])) 
  {
    echo "submit";
    $label= $_POST['submitLabel'];
    $date = date("Y-m-d");
    mysqli_query($db, "INSERT INTO to_do_list (label, date) VALUES ('$label', '$date')"); 
  }
  // delete item
  else if (isset($_POST['formDelete'])) 
  {
    echo "delete";
    $id = $_GET['formDelete'];
    $_SESSION["mode"] = "add";
    mysqli_query($db, "DELETE FROM to_do_list WHERE id=$id"); 
  }
  // cancel edit
  else if (isset($_POST['formCancel']))
  {
    echo "cancel";
    $id = $_GET['formEdit'];
    $_SESSION["mode"] = "add";
  }   
  //submit edited item
  else if (isset($_POST['formEditSubmit'])) 
  {
    echo "FORM EDIT SUBMIT";
    $label= $_POST['formLabel'];
    //reset mode
    $_SESSION["mode"] = "add";
    //gets id from specific list item
    $id = $_GET['formEditSubmit'];
    mysqli_query($db, "UPDATE to_do_list SET label = '$label' WHERE id=$id"); 
  }
  // edit item
  else if (isset($_POST['formEdit'])) 
  {
    echo "form edit";
    //gets id from specific list item
    $id = $_GET['formEdit'];
    $_SESSION["editId"] = $id;
    echo $id;
    if (!isset($_SESSION["mode"]))
    {
      $_SESSION["mode"] = "edit";
    }
    else
    {
      if ($_SESSION["mode"] == "add")
      {
        $_SESSION["mode"] = "edit";
      }
      else //if ($_SESSION["mode"] == "edit")
      {
        $_SESSION["mode"] = "add";
      }
    }
  }

  //check box
  else if (isset($_POST['formCheck'])) 
  {
    echo "check box";
    $id = $_GET['formCheck'];
    $results = mysqli_query($db, "SELECT * FROM to_do_list"); 
    while ($row = mysqli_fetch_array($results)) 
    {
      if ($row['id'] == $id)
      {
        if ($row['checked'] == 1)
        {
          mysqli_query($db, "UPDATE to_do_list SET checked=0 WHERE id=$id"); 
        }
        else if ($row['checked'] == 0)
        {
          mysqli_query($db, "UPDATE to_do_list SET checked=1 WHERE id=$id"); 
        }
      }
    }
  }  
  header('location: index.php');
?>