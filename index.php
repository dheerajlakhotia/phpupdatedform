<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "form";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$name = "";
$email = "";
$mobile = '';
$password = '';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    if ($type == "edit") {
        $id = $_GET['id'];
        $sql = "SELECT * FROM `user` WHERE id='$id'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $name = $row['name'];
                $email = $row['email'];
                $mobile = $row['mobile'];
                $password = $row['password'];
            }
        }
        // Check if an ID is present (indicating an update)
        if (isset($_POST['submit'])) {
            // Get the form data
            $name = $_POST['name'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $password = $_POST['password'];
            $pass = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE user SET name='$name', email='$email', mobile='$mobile', password='$pass' WHERE id='$id'";
            if (!isset($_POST['submit'])){

              if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
                header("location:index.php");
              } else {
                  echo "Error updating record: " . $conn->error;
              }
            }

        } 
    } elseif ($type == "delete") {
        $id = $_GET['id'];
        $sql = "DELETE FROM user WHERE id='$id'";
        if ($conn->query($sql) === TRUE){
            echo "Record Deleted Successfully";
            header("location:index.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
} else {
  
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
  
    if (isset($_POST['submit'])) {
    $name = test_input($_POST['name']);
    $email = test_input($_POST['email']);
    $mobile = test_input($_POST['mobile']);
    $password = test_input($_POST['password']);
    $pass = password_hash($password, PASSWORD_BCRYPT);
  

    if (isset($_POST['submit'])) {
   
    $mobilequery = "SELECT * FROM user WHERE mobile='$mobile'";
    $query = mysqli_query($conn, $mobilequery);
    $mobilecount = mysqli_num_rows($query);
  
    $emailquery = "SELECT * FROM user WHERE email='$email'";
    $query = mysqli_query($conn, $emailquery);
    $emailcount = mysqli_num_rows($query);
  
    if ($emailcount > 0 || $mobilecount > 0) {
    echo '<div class="alert alert-primary alert-dismissible fade show close" role="alert">
      Email or number already exists!
    </div>';
    } else {
    $sql = "INSERT INTO user(name, email, mobile, password) VALUES('$name','$email', '$mobile', '$pass')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
    echo '<div class="alert alert-primary alert-dismissible fade show close my-auto" role="alert">
      Data inserted successfully!
    </div>';
    header("location:index.php");
    exit();
    } else {
    echo "Error: " . $sql . '<br>' . $conn->error;
    }
    }
    }
    }  
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Basic Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script>
  let data = [];


  function isNumberKey(event) {
    const charCode = event.which ? event.which : event.keyCode;
    // Allow only numbers (0-9) and backspace (8)
    return charCode >= 48 && charCode <= 57 || charCode === 8;
  }


  function validationForm() {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var mobile = document.getElementById('mobile').value;
    var password = document.getElementById('password').value;



    function isValidName(name) {

      // Function to check if the name contains at least one non-whitespace character
      function isValidName(name) {
        const namePattern = /\S+/; // At least one non-whitespace character
        return namePattern.test(name);
      }

      if (!isValidName(name)) {
        document.getElementById('valname').innerHTML = "Enter a valid name";
        return false;
      } else {
        document.getElementById('valname').innerHTML = "";
      }
      // Name should contain only letters and spaces
      const namePattern = /^[a-zA-Z\s]+$/;
      return namePattern.test(name);
    }
    if (!name) {
      document.getElementById("valname").innerHTML = "Name must be filled out";
      return false;
    } else if (!isValidName(name)) {
      document.getElementById('valname').innerHTML = "Enter a valid name";
      return false;
    } else {
      document.getElementById('valname').innerHTML = "";
    }
    if (name == "") {
      document.getElementById("valname").innerHTML = "Name must be filled out";
      console.log("name nust be filled out");
      return false;
    } else if (name.length <= 2) {
      document.getElementById('valname').innerHTML = "Enter valid name";
      return false;
    } else {
      document.getElementById('valname').innerHTML = "";
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
    if (mobile == "") {
      document.getElementById("valmob").innerHTML = "Mobile Number must be filled out";
      console.log("Mobile number nust be filled out");
      return false;
    } else if (mobile.length != 10) {
      document.getElementById('valmob').innerHTML = "Enter valid Mobile Number";
      return false;
    } else {
      document.getElementById('valmob').innerHTML = "";
    }

  }
  </script>


  <style>
  body {
    /* background-color: #f2f2f2; */
    background-color: #F6F6F6;
    /* background-color: #f7f7f7; */
  }

  .card {
    background-color: #98DDCA;
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 8px;
    /* Add a subtle shadow */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

    /* Increase the z-index value */
    z-index: 1;
    /* Add 3D look */
    border: 1px solid #ccc;
    border-top: 1px solid #ddd;
    border-left: 1px solid #ddd;
    transform: perspective(1000px) rotateX(2deg);
  }

  .btn-primary {
    background-color: #4285F4;
    border-color: #4285F4;
  }

  .btn-primary:hover {
    background-color: #357AE8;
    border-color: #357AE8;
  }

  .form-control {
    border: 1px solid #ced4da;
    border-radius: 5px;
    padding: 10px 15px;
    transition: border-color 0.2s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-size: 16px;
  }
  </style>

</head>

<body>

  <div class="container">
    <div class="container mr mb-2">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-center text-color">Fill The Form</h4>
              <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                  <label class="lable-color" for="name">Name</label>
                  <input type="text" value="<?php echo $name; ?>" class="form-control my-2" id="name" name="name"
                    placeholder="Enter your name" autocomplete="off" required>
                  <span id="valname"></span>
                </div>
                <div class="form-group">
                  <label class="lable-color" for="email">Email</label>
                  <input type="email" value="<?php echo $email; ?>" class="form-control my-2" id="email" name="email"
                    placeholder="Enter Your Email" autocomplete="chrome-off" required>
                  <span id="valemail"></span>
                </div>
                <div class="form-group">
                  <label class="lable-color" for="mobile">Mobile</label>
                  <input type="text" value="<?php echo $mobile; ?>" class="form-control my-2" id="mobile" name="mobile"
                    placeholder="Enter Your Mobile" autocomplete="chrome-off" required
                    onkeypress="return isNumberKey(event)" required>
                  <span id="valmob"></span>
                </div>
                <div class="form-group">
                  <label class="lable-color" for="password">Password</label>
                  <input type="password" value="<?php echo $password; ?>" id="password" class="form-control my-2"
                    autocomplete="off" name="password" placeholder="Enter your password" required>
                  <span id="valpassword"></span>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary mt-5" id="submit" onclick="return validationForm()"
                    name="submit">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="display-6  text-center">USER DATA</div>

    <table class="table table-primary tabledit-view-mode  table-hover">
      <thead>
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Mobile</th>
          <th scope="col">Password</th>
          <th scope="col">Operation</th>
        </tr>
      </thead>
      <tbody>
        <?php 
						$res = "SELECT * FROM user";
						$result = $conn->query($res);

						if ($result->num_rows > 0){
							while ($row = $result->fetch_assoc()) {?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['mobile']; ?></td>
          <td><?php echo $row['password']; ?></td>
          <td><a href="index.php?id=<?php echo $row['id'];?>&&type=edit"><button
                class="btn btn-primary">Update</button></a>
            <a href="index.php?id=<?php echo $row["id"];?>&&type=delete"><button
                class="btn btn-danger">Delete</button></a>
          </td>
        </tr>
        <?php }} ?>
      </tbody>
    </table>

  </div>


</body>

</html>