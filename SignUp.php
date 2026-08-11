<?php
    session_start();
    if (isset($_SESSION["user_id"])) {
        header("Location: Dashboard.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  
    <title>CCS Sit-in Registration</title>
    <link rel="icon" type="image/png" href="Images/favicon-32x32.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Raleway:wght@100..900&display=swap"
      rel="stylesheet"
    />
  </head>

  <body
    class="flex font-poppins items-center justify-center dark:bg-gray-900 min-w-screen min-h-screen">
      <div class="grid gap-8">
        <div
        id="back-div"
        class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-[26px] m-4">
        <div
        class="border-[20px] border-transparent rounded-[20px] dark:bg-gray-900 bg-white shadow-lg xl:p-10 2x1:p-10 lg:p-10 md:p-10 sm:p-2 m-2"
        >
          <img
            class="mx-auto object-top size-30"
            src="../SYS_ARCH/Images/ccs_logo_processed.png"
            alt="CCS Logo"
          />
          <?php
          if (isset($_POST["submit"])) {
            $idno = $_POST["id_number"];
            $lastname = $_POST["last_name"];
            $firstname = $_POST["first_name"];
            $middlename = $_POST["middle_name"];
            $email = $_POST["email"];
            $level = $_POST["year_level"];
            $course = $_POST["course"];
            $password = $_POST["password"];
            $repeatpassword = $_POST["repeat_password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();

            if (empty($idno) OR empty($lastname) OR empty($firstname) OR empty($email) OR empty($level) OR empty($course) OR empty($password) OR empty($repeatpassword)) {
              array_push($errors,"All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              array_push($errors,"Email is not valid");
            }
            if (strlen($password)<6) {
              array_push($errors,"Password must be at least 6 characters");
            }
            if ($password!==$repeatpassword) {
              array_push($errors,"Password does not match");
            }
            require_once "db.php";
            $sql = "SELECT * FROM users WHERE id_num = '$idno' OR email = '$email'";
            $result = mysqli_query($conn,$sql);
            if ($result) {
              while ($row = mysqli_fetch_assoc($result)) {
                  if ($row['id_num'] == $idno) {
                      array_push($errors, "ID number already exists!");
                  }
                  if ($row['email'] == $email) {
                      array_push($errors, "Email already exists!");
                  }
              }
            }

            if (count($errors)>0) {
              foreach ($errors as $error) {
                echo "<div class='flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3' role='alert'>
                <svg class='fill-current w-4 h-4 mr-2' xmlns= 'http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z'/></svg>
                $error</div>";

              }
            }else{
             $sql = "INSERT INTO users (id_num, user_Lname, user_Fname, user_Mname, email, year_level, course, password) VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )";
             $stmt = mysqli_stmt_init($conn);
             $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
             if ($prepareStmt) {
              mysqli_stmt_bind_param($stmt,"issssiss",$idno, $lastname, $firstname, $middlename, $email, $level, $course, $passwordHash);
              mysqli_stmt_execute($stmt);
              echo "<div class='flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3' role='alert'>
                Successfully registered!</div>";
             }else{
                die("Something went wrong");
             }
            }
            /*header("Location: Login.php");
            exit();*/

          }
          ?>
          <form action="SignUp.php" class="grid grid-cols-2 gap-4" method="post" >
            <div>
              <label for="id-number" class="mb-2 dark:text-gray-400 text-lg"
                >ID Number</label
              >
              <input
                id="id-number"
                class="border dark:bg-indigo-700 dark:text-gray-300 dark:border-gray-700 p-2 shadow-md placeholder:text-base border-gray-300 rounded-lg w-full"
                type="text" name="id_number"
                placeholder="ID Number"
                required
              />
            </div>
            <div>
              <label for="last-name" class="mb-2 dark:text-gray-400 text-lg"
                >Last Name</label
              >
              <input
                id="last-name"
                class="border dark:bg-indigo-700 dark:text-gray-300 dark:border-gray-700 p-2 shadow-md placeholder:text-base border-gray-300 rounded-lg w-full"
                type="text" name="last_name"
                placeholder="Last Name"
                required
              />
            </div>
            <div>
              <label for="first-name" class="mb-2 dark:text-gray-400 text-lg"
                >First Name</label
              >
              <input
                id="first-name"
                class="border dark:bg-indigo-700 dark:text-gray-300 dark:border-gray-700 p-2 shadow-md placeholder:text-base border-gray-300 rounded-lg w-full"
                type="text" name="first_name"
                placeholder="First Name"
                required
              />
            </div>
            <div>
              <label for="middle-name" class="mb-2 dark:text-gray-400 text-lg"
                >Middle Name</label
              >
              <input
                id="middle-name"
                class="border dark:bg-indigo-700 dark:text-gray-300 dark:border-gray-700 p-2 shadow-md placeholder:text-base border-gray-300 rounded-lg w-full"
                type="text" name="middle_name"
                placeholder="Middle Name"
                
              />
            </div>
            <div>
              <label for="email" class="mb-2 dark:text-gray-400 text-lg"
                >Email</label
              >
              <input
                id="email"
                class="border dark:bg-indigo-700 dark:text-gray-300 dark:border-gray-700 p-2 shadow-md placeholder:text-base border-gray-300 rounded-lg w-full"
                type="email" name="email"
                placeholder="Email"
                required
              />
            </div>
            <div>
              <label for="year-level" class="mb-2 dark:text-gray-400 text-lg"
                >Year Level</label
              >
              <select
                id="year-level" 
                class="border dark:bg-indigo-700 dark:text-gray-300 dark:border-gray-700 p-2 shadow-md border-gray-300 rounded-lg w-full"
                name="year_level" required
              >
                <option value="" disabled selected hidden>Select Year Level</option>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
                <option value="4">4th Year</option>
              </select>
            </div>
            <div>
              <label for="course" class="mb-2 dark:text-gray-400 text-lg"
                >Course</label
              >
              <select
                id="course" 
                class="border dark:bg-indigo-700 dark:text-gray-300 dark:border-gray-700 p-3 shadow-md border-gray-300 rounded-lg w-full"
                name="course" required
              >
                <option value="" disabled selected hidden>Select Course</option>
                <option value="BSIT">BS Information Technology</option>
                <option value="BSCS">BS Computer Science</option>
                <option value="BSIS">BS Information System</option>
              </select>
            </div>
            <div>
              <label for="password" class="mb-2 dark:text-gray-400 text-lg"
                >Password</label
              >
              <input
                id="password"
                class="border dark:bg-indigo-700 dark:text-gray-300 dark:border-gray-700 p-3 shadow-md placeholder:text-base border-gray-300 rounded-lg w-full"
                type="password" name="password"
                placeholder="Password"
              />
            </div>
            <div>
              <label
                for="confirm-password"
                class="mb-2 dark:text-gray-400 text-lg"
                >Confirm Password</label
              >
              <input
                id="confirm-password"
                class="border dark:bg-indigo-700 dark:text-gray-300 dark:border-gray-700 p-3 shadow-md placeholder:text-base border-gray-300 rounded-lg w-full"
                type="password" name="repeat_password"
                placeholder="Confirm Password"
                required
              />
            </div>
            <div class="col-span-2">
              <button
                class="bg-gradient-to-r from-blue-500 to-purple-500 shadow-lg mt-6 p-2 text-white rounded-lg w-full hover:scale-105 hover:from-purple-500 hover:to-blue-500 transition duration-300 ease-in-out"
                type="submit" value="Register" name="submit"
              >
                Sign Up
              </button>
            </div>
          </form>
          <div class="flex flex-col mt-5 items-center justify-center text-base">
              <h3 class="text-center">
                <span class="cursor-default dark:text-gray-300 text-base">
                  Already have an account?
                </span>
                <a
                  class="group text-blue-400 transition-all duration-100 ease-in-out"
                  href="Login.php"
                >
                  <span
                    class="bg-left-bottom ml-1 bg-gradient-to-r from-blue-400 to-blue-400 bg-[length:0%_2px] bg-no-repeat group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out"
                  >
                    Login
                  </span>
                </a>
              </h3>
            </div>
        </div>
      </div>
    </div>
    </div>
  </body>
</html>
