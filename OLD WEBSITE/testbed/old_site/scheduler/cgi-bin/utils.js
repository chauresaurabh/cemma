// Various JavaScript support routines for the CEMMA site.

// Confirm user delete.
function confirmDelete(username)
{
    var answer = confirm("Are you sure you want to delete user " + username + "?");
    
    if (answer != 0) {
	return true;
    }

    return false;
}
