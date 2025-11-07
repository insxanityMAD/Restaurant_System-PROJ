

<?php 

?>


<!DOCTYPE html>

<head>

</head>

<body >
<h1> Create Account </h1>

<form method = "POST" action ="">

<label> first name </label>
<input type = text name = "firstname">



<label> last name </label>
<input type = text name = "lastname">

<label>new username </label>
<input type = text name = "username">



<label> new password </label>
<input type = password name = "password">


<p1> gender </p1>
<input type="radio" name="gender" value="Male" onclick="uncheckRadio(this)"> Male
<input type="radio" name="gender" value="Female" onclick="uncheckRadio(this)"> Female
<input type="radio" name="gender" value="Other" onclick="uncheckRadio(this)"> Other


<label> full address </label>
<input type = text name = "fulladdress">

<label> email address </label>
<input type = text name = "email">

<labe> contact number </label>
<input type = text name = "contactnumber">

<input type = button name = "submit" > submit </input>

</form>








</html>

<script>
let lastChecked = null;

function uncheckRadio(radio) {
  if (radio === lastChecked) {
    radio.checked = false; // uncheck if clicked again
    lastChecked = null;
  } else {
    lastChecked = radio; // remember which was clicked
  }
}
</script>
