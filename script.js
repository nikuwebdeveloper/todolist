function taskComplete(id, checkboxId)
{
    let itemId = "item-" + id;
    let checkbox = document.getElementById(checkboxId);
    // sets color if checkbox is checked or not
    if (checkbox.checked == true)
    {
        document.getElementById(itemId).style = "text-decoration:line-through; color: gray";
    }
    else if (checkbox.checked == false)
    {
        document.getElementById(itemId).style = "text-decoration:none; color: black";
    }
}