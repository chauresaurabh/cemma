<?

$userId = $_GET['userId'];


?>
<form id="addPolicyForm" action="UpdateUserComments.php">
      <textarea id="user_comments" name="user_comments" cols="50" rows="10"></textarea>
      <input type="submit" value="Add Comments">
      <input type="hidden"  name="userId" value=<?= $userId ?> />
</form>