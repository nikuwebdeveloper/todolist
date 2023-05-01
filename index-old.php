<?php include 'connection.php';?>
<?php 
    session_start();
    if (isset($_SESSION["mode"]))
    {
        echo $_SESSION["mode"];
    }
   // $_SESSION["editId"] = "";
    
?>
<html>
<?php include 'head.php';?>
<body>
    <div class="body-container flex-column">
        <div id="list-entry flex-column">
            <form action="submit.php" method="POST" enctype="application/x-www-form-urlencoded">
                <h3>Enter Label</h3>
                <input type="text" name="submitLabel" id="label-text" 
                value="">
                <input type="submit" value="Submit" name="formSubmit" id="label-submit">
            </form>
        </div>
        <!-- main list -->
        <div class="list-container flex-column">
            <?php
                $results = mysqli_query($db, "SELECT * FROM to_do_list"); 
                while ($row = mysqli_fetch_array($results)) {?>
                <div id="<?php echo $row['id']; ?>" class="list-item flex-row">
                    <!-- checkbox -->
                    <div class="list-item-checkbox">
                        <form action="submit.php?formCheck=<?php echo $row['id']; ?>" method="POST" enctype="application/x-www-form-urlencoded">
                            <button name="formCheck">Done</button>
                        </form>
                    </div>
                    <!-- label -->
                    <div class="list-item-label flex-column"<?php if ($row['checked']==1){echo "style='color:gray;'";}; ?>>
                        <?php if (isset($_SESSION["mode"]))
                        {
                            if ($_SESSION["mode"] == "edit")
                            {  
                                //echo $_SESSION["editId"];
                                // when in edit mode, show text field for editing text
                                if ($_SESSION["editId"] == $row['id'])
                                {
                                    echo '<form class="flex-row" action="submit.php?formEditSubmit=';
                                    echo $row['id'];
                                    echo '" method="POST" enctype="application/x-www-form-urlencoded">';
                                    
                                    //echo '</form>';

                                    //echo '<form class="form-edit-hidden" action="submit.php" method="POST" enctype="application/x-www-form-urlencoded">';
                                    echo '<input type="text" name="submitLabel" id="label-text" value="'; 
                                    echo $row["label"];
                                    echo '">';
                                    echo '<input type="submit" value="Submit" name="formEditSubmit" id="label-submit">';
                                    echo '</form>';
                                }
                                // also show normal labels of items. required due to issue with unset session variables
                                else
                                {   
                                    echo '<p id="item-<?php echo $row["id"] class="list-item-name">';
                                    echo $row['label'];
                                    echo '</p>';
                                }
                            } 
                            // show normal labels of items
                            else if ($_SESSION["mode"] == "add")
                            {
                                
                                echo '<p id="item-<?php echo $row["id"] class="list-item-name">';
                                echo $row['label'];
                                echo '</p>';
                            }
                        }
                        // also show normal labels of items. required due to issue with unset session variables
                        else
                        {
                            echo '<p id="item-<?php echo $row["id"] class="list-item-name">';
                            echo $row['label'];
                            echo '</p>';
                        }?>
                        <p class="list-item-date">
                            <?php echo $row['date']; ?>
                        </p>
                    </div>
                    <!-- left-side buttons -->
                    <div class="list-item-buttons">
                        <!-- delete -->
                        <!-- set delete to invisible if in edit mode  -->
                        <form action="submit.php?formDelete=<?php echo $row['id']; ?>" method="POST" style="<?php if (isset($_SESSION["mode"])){if ($_SESSION["mode"] == "edit"){echo 'display: none';}}?>" enctype="application/x-www-form-urlencoded">
                            <button name="formDelete">Delete</button>
                        </form>
                        <!-- edit -->
                        <?php           
                            if (isset($_SESSION["mode"]))
                            {
                                //when in edit mode, show Submit button to submit edited text
                                if ($_SESSION["mode"] == "edit")
                                {  
 
                                }
                                else if ($_SESSION["mode"] != "edit")
                                {
                                    echo '<form action="submit.php?formEdit=';
                                    echo $row['id'];
                                    echo '" method="POST" enctype="application/x-www-form-urlencoded">';
                                    echo '<button name="formEdit">Edit</button>';
                                    echo '</form>';
                                }
                            }
                            else //mode is unset (should be initial)
                            {   
                                echo '<form action="submit.php?formEdit=';
                                echo $row['id'];
                                echo '" method="POST" enctype="application/x-www-form-urlencoded">';
                                echo '<button name="formEdit">Edit</button>';
                                echo '</form>';
                            }
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
