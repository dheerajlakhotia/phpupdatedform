<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "student";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error){
    die("Connection faild". connect_error);
}


$fristname = "";
$lastname = "";
$fname = '';
$mob = '';
$email = '';
$address = '';


if (isset($_GET['type'])){
	$type = $_GET['type'];
	if ($type == "edit"){
		$id = $_GET['id'];
		$sql = "SELECT * FROM `student` WHERE id='$id'";
		$res = $conn->query($sql);
		if ($res->num_rows > 0){
			while ($row = $res->fetch_assoc()) {
				$fristname = $row['Firstname'];
				$lastname = $row['Lastname'];
				$fname = $row['Fathername'];
				$mob = $row['mobile'];
				$email = $row['email'];
				$address = $row['Addres'];
			}
		}
		if (isset($_POST['submit'])) {	
		    $fristname = $_POST['name'];
		    $lastname = $_POST['lname'];
		    $fname = $_POST['fname'];
		    $mob = $_POST['mob'];
		    $email = $_POST['email'];
		    $address = $_POST['address'];

		    $sql = "UPDATE student SET Firstname='$fristname', Lastname='$lastname', Fathername='$fname', mobile='$mob', email='$email', Addres='$address' WHERE id='$id'";
		    if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
				header("location:index.php");
			} else {
				echo "Error updating record: " . $conn->error;
			}
		}
	} elseif ($type == "delete") {	
		$id = $_GET['id'];
		$sql = "DELETE FROM student WHERE id='$id'";
		if ($conn->query($sql) === TRUE){
			echo "Record Delete successfully";
			header("location:index.php");
		}else{
			echo "Error deleting record: " . $conn->error;
		}
	}
}else{
	if (isset($_POST['submit'])){
	    $fristname = $_POST['name'];
	    $lastname = $_POST['lname'];
	    $fname = $_POST['fname'];
	    $mob = $_POST['mob'];
	    $email = $_POST['email'];
	    $address = $_POST['address'];

	    $sql = "INSERT INTO student(Firstname, Lastname, Fathername, mobile, email, Addres) VALUES('$fristname','$lastname', '$fname', '$mob', '$email', '$address')";
	    if ($conn->query($sql)){
	        echo "New Record add successfully";
	        header("location:index.php");
	    }else{
	        echo "Error: " . $sql . '<br>' . $conn->error;
	    }
	}
}
?>


<!DOCTYPE html>
<html>

<head>
  <title>Student Form</title>
  <style>
  * {
    box-sizing: border-box;
  }

  input[type=text],
  [type=email],
  select,
  textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
  }

  label {
    padding: 12px 12px 12px 0;
    display: inline-block;
  }

  button {
    background-color: #04AA6D;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    float: left;
  }

  .edit {
    background-color: #4d4dff;
  }

  .delete {
    background-color: red;
  }

  button:hover {
    background-color: #45a049;
  }

  .container {
    border-radius: 5px;
    background-color: #ddd;
    padding: 20px;
    max-width: 600px;
    margin: auto;
  }

  h1 {
    text-align: center;
  }

  .col-25 {
    float: left;
    width: 25%;
    margin-top: 6px;
  }

  .col-75 {
    float: left;
    width: 75%;
    margin-top: 6px;
  }

  .row:after {
    content: "";
    display: table;
    clear: both;
  }

  @media screen and (max-width: 600px) {

    .col-25,
    .col-75,
    input[type=submit] {
      max-width: 100%;
      width: 100%;
      margin-top: auto;
    }

    .container {
      max-width: 100%;
    }
  }

  #customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  #customers td,
  #customers th {
    border: 1px solid #ddd;
    padding: 8px;
  }

  #customers tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  #customers tr:hover {
    background-color: #ddd;
  }

  #customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
  }
  </style>

  <script>
  let data = [];

  function validationForm() {
    var Frist = document.getElementById('Fristname').value;
    var lname = document.getElementById('lname').value;
    var fname = document.getElementById('fname').value;
    var mob = document.getElementById('mob').value;
    var email = document.getElementById('email').value;
    var add = document.getElementById('address').value;

    if (Frist == "") {
      document.getElementById("valname").innerHTML = "Frist Name must be filled out";
      console.log("frist name nust be filled out");
      return false;
    } else if (Frist.length <= 2) {
      document.getElementById('valname').innerHTML = "Enter valid Frist name";
      return false;
    } else {
      document.getElementById('valname').innerHTML = "";
    }
    if (lname == "") {
      document.getElementById("vallast").innerHTML = "Last Name must be filled out";
      console.log("Last name nust be filled out");
      return false;
    } else if (lname.length <= 2) {
      document.getElementById('vallast').innerHTML = "Enter valid Last name";
      return false;
    } else {
      document.getElementById('vallast').innerHTML = "";
    }
    if (fname == "") {
      document.getElementById("valfname").innerHTML = "Father Name must be filled out";
      console.log("father name nust be filled out");
      return false;
    } else if (fname.length <= 2) {
      document.getElementById('valfname').innerHTML = "Enter valid Father name";
      return false;
    } else {
      document.getElementById('valfname').innerHTML = "";
    }
    if (mob == "") {
      document.getElementById("valmob").innerHTML = "Mobile Number must be filled out";
      console.log("Mobile number nust be filled out");
      return false;
    } else if (mob.length != 10) {
      document.getElementById('valmob').innerHTML = "Enter valid Mobile Number";
      return false;
    } else {
      document.getElementById('valmob').innerHTML = "";
    }
    let i = 0;
    let valid = 0;
    let val = 0;
    while (i < email.length) {
      if (email[i] == '@') {
        val = val + 1;
      } else if (email[i] == ".") {
        valid = valid + 1;
      }
      i = i + 1;
    }
    if (email == "") {
      document.getElementById("valemail").innerHTML = "Email must be filled out";
      console.log("email nust be filled out");
      return false;
    } else if (email.length <= 9) {
      document.getElementById('valemail').innerHTML = "Enter valid Email";
      return false;
    } else if (val != 1) {
      console.log(valid);
      document.getElementById('valemail').innerHTML = "Enter valid Email";
      return false;
    } else if (valid <= 0) {
      document.getElementById('valemail').innerHTML = "Enter valid Email. ";
      return false;
    } else {
      document.getElementById('valemail').innerHTML = "";
    }
    if (add == "") {
      console.log(valid);
      document.getElementById("valadd").innerHTML = "Address must be filled out";
      console.log("address nust be filled out");
      return false;
    } else if (add.length <= 9) {
      document.getElementById('valadd').innerHTML = "Enter valid Address";
      return false;
    } else {
      document.getElementById('valadd').innerHTML = "";
      return true;
    }

  }
  </script>
</head>

<body>
  <div class="container" style="" id="home">

    <h1>Student Information Form</h1>
    <form method="post" style="max-width: 600px;">
      <div class="row">
        <div class="col-25">
          <label>Frist Name : </label>
        </div>
        <div class="col-75">
          <input type="text" value="<?php echo $fristname; ?>" class="form-input" id="Fristname" name="name"
            placeholder="Enter Your Frist Name" autocomplete="off"><br>
          <span id="valname"></span>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <label>Last Name : </label>
        </div>
        <div class="col-75">
          <input type="text" value="<?php echo $lastname; ?>" class="form-input" id="lname" name="lname"
            placeholder="Enter Your Last Name" autocomplete="chrome-off"><br>
          <span id="vallast"></span>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <label>Father Name : </label>
        </div>
        <div class="col-75">
          <input type="text" class="form-input" id="fname" name="fname" placeholder="Enter Your Father Name"
            value="<?php echo $fname; ?>" autocomplete="chrome-off"><br>
          <span id="valfname"></span>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <label>Mobile Number : </label>
        </div>
        <div class="col-75">
          <input type="text" value="<?php echo $mob; ?>" class="form-input" id="mob" name="mob"
            placeholder="Enter Your Mobile" autocomplete="chrome-off"><br>
          <span id="valmob"></span>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <label>Email : </label>
        </div>
        <div class="col-75">
          <input type="email" value="<?php echo $email; ?>" class="form-input" id="email" name="email"
            placeholder="Enter Your Email" autocomplete="chrome-off"><br>
          <span id="valemail"></span>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <label>Address : </label>
        </div>
        <div class="col-75">
          <input type="text" value="<?php echo $address; ?>" class="form-input" id="address" name="address"
            placeholder="Enter Your Address" autocomplete="chrome-off"><br>
          <span id="valadd"></span>
        </div>
      </div>
      <div class="row">
        <button type="submit" name="submit" id="submit" onclick="return validationForm()">Submit</button>
      </div>
    </form>
  </div>

  <div>

    <table id="customers">
      <thead>
        <th>ID</th>
        <th>Frist Name</th>
        <th>Last Name</th>
        <th>Father Name</th>
        <th>Mobile Number</th>
        <th>Email</th>
        <th>Address</th>
        <th>Action</th>
      </thead>
      <tbody>
        <?php 
						$res = "SELECT * FROM student";
						$result = $conn->query($res);

						if ($result->num_rows > 0){
							while ($row = $result->fetch_assoc()) {?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['Firstname']; ?></td>
          <td><?php echo $row['Lastname']; ?></td>
          <td><?php echo $row['Fathername']; ?></td>
          <td><?php echo $row['mobile']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['Addres']; ?></td>
          <td><a href="index.php?id=<?php echo $row['id'];?>&&type=edit"><button class="edit">Edit</button></a>
            <a href="index.php?id=<?php echo $row["id"];?>&&type=delete"><button class="delete">Delete</button></a>
          </td>
        </tr>
        <?php }} ?>
      </tbody>
    </table>
  </div>
</body>

</html>