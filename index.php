<?php include 'connection.php';?>
<?php 
    session_start();
    // if (isset($_SESSION["mode"]))
    // {
    //     echo $_SESSION["mode"];
    // }    
    if (!isset($_SESSION["mode"]))
    {
        $_SESSION["mode"] = "add";
    }
?>
<html>
<?php include 'head.php';?>
<body>
    <!-- main list container -->
    <div class="body-content flex-column">
        <div id="list-container">
            <!-- rename this VVV -->
            <div id="list-add" class="flex-column"> 
                <form action="submit.php" method="POST" enctype="application/x-www-form-urlencoded">
                    <h3>Enter New Task</h3>
                    <input type="text" name="submitLabel" id="label-text" 
                    value="">
                    <input class="button-normal" type="submit" value="Submit" name="formSubmit" id="label-submit">
                </form>
            </div>
            <!-- main list content -->
            <div class="list-item-container flex-column">
                <?php
                    $results = mysqli_query($db, "SELECT * FROM to_do_list"); 
                    while ($row = mysqli_fetch_array($results)) {?>
                    <div id="<?php echo $row['id']; ?>" class="list-item flex-row">
                        <form class="list-item-form" action="submit.php" method="POST" enctype="application/x-www-form-urlencoded">
                            <!-- LABEL -->
                            <div class="list-item-form-label flex-row">
                                <!-- label text -->
                                <p <?php if ($row['checked']==1){echo "style='color:lightgray;'";}; ?>>
                                    <?php echo $row["label"]; ?>
                                </p>
                                <!-- label input -->
                                <input type="text" name="formLabel" 
                                <?php
                                    if ($_SESSION["mode"] != "edit")
                                    {
                                        echo " disabled";
                                        echo " style='background-color: #c9c9c9'";
                                    }
                                    else
                                    {
                                        if ($row['id'] != $_SESSION["editId"])
                                        {
                                            echo " disabled";
                                            echo " style='background-color: #c9c9c9'";
                                        }
                                    }
                                ?>
                                ></input>
                            </div>
                            <div class="list-item-form-buttons flex-row">
                                <!-- CHECK MARK button -->
                                <button class="checkbox" name="formCheck" formaction="submit.php?formCheck=<?php echo $row['id']; ?>">
                                    <?php 
                                        if ($row['checked']==1)
                                        {
                                            echo "&#128937;";
                                        } 
                                        else
                                        {
                                            echo "&check;";
                                        }
                                    ?>
                                </button>

                                <!-- EDIT button -->
                                <button
                                <?php 
                                    if ($_SESSION["mode"] == "edit")
                                    {   
                                        if ($row['id'] == $_SESSION["editId"])
                                        {
                                            echo ' name="formEditSubmit"'; 
                                            echo ' formaction="submit.php?formEditSubmit=';
                                            echo $row['id']; 
                                            echo '"';
                                        }
                                        else
                                        {
                                            echo " disabled";
                                            echo " style='background-color: #c9c9c9; color: lightgray'";
                                        }
                                    }
                                    else
                                    {
                                        echo ' name="formEdit"'; 
                                        echo ' formaction="submit.php?formEdit=';
                                        echo $row['id']; 
                                        echo '"';
                                    }
                                //keep?>> 
                                <?php 
                                    if ($_SESSION["mode"] == "edit")
                                    {
                                        if ($row['id'] != $_SESSION["editId"])
                                        {
                                            echo "Edit";
                                        }
                                        else 
                                        {
                                            echo "Submit";
                                        }
                                    }
                                    else
                                    {
                                        echo "Edit";
                                    }
                                ?>
                                </button>
                                <!-- CANCEL button -->
                                <button class="button-normal" name="formCancel" formaction="submit.php?formCancel=<?php echo $row['id']; ?>"
                                <?php
                                    if (($_SESSION["mode"] != "edit") || ($row['id'] != $_SESSION["editId"]))
                                    {
                                        echo "Edit";
                                        echo " disabled";
                                        echo " style='background-color: #c9c9c9; color: lightgray'";
                                    }
                                ?>
                                >
                                <?php
                                    echo "Cancel";
                                ?>
                                </button>
                                <!-- DELETE button -->
                                <button class="button-normal" name="formDelete" formaction="submit.php?formDelete=<?php echo $row['id']; ?>">
                                    Delete
                                </button>
                            </div>
                            <div class="line-wide"><hr></div>
                        </form>
                        
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
