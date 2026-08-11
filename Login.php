<?php
    session_start();
    if (isset($_SESSION["user"])) {
        header("Location: Dashboard.php");
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <title>CCS Sit-in Monitoring</title>
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
    class="flex font-poppins items-center justify-center dark:bg-gray-900 min-w-screen min-h-screen"
  >
    <div class="grid gap-8">
      <div
        id="back-div"
        class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-[26px] m-4"
      >
        <div class="border-[20px] border-transparent rounded-[20px] dark:bg-gray-900 bg-white shadow-lg xl:p-10 2xl:p-10 lg:p-10 md:p-10 sm:p-2 m-2"
        >
        <h1 class="pt-3 pb-3 font-bold text-3xl dark:text-gray-400 text-center cursor-default">CCS Sit-in Monitoring</h1>
          <img
            class="mx-auto object-top size-30"
            src="../SYS_ARCH/Images/ccs_logo_processed.png"
            alt="CCS Logo"
          />
          <?php
          if (isset($_POST["login"])) {
            $idno = $_POST["id_num"];
            $password = $_POST["password"];
            require_once "db.php";
            $sql = "SELECT * FROM users WHERE id_num = '$idno'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array( $result, MYSQLI_ASSOC );
            if ($user) {
              if (password_verify($password, $user["password"])) {
                session_start();
                $_SESSION["id"] = $user['id'];
                header("Location: Dashboard.php");
                die();
              }else{
                echo "<div class='flex items-center bg-red-500 text-white text-sm font-bold px-4 py-3' role='alert'>
                Wrong password. Try again</div>";
              }
            }else{
              echo "<div class='flex items-center bg-red-500 text-white text-sm font-bold px-4 py-3' role='alert'>
                Wrong ID number. Try again</div>";
            }
          }
          ?>
          <form action="Login.php" method="post" class="space-y-4">
            <div>
              <label for="idno" class="mb-2 dark:text-gray-400 text-lg"
                >ID number</label
              >
              <input
                id="idno"
                class="border dark:bg-indigo-700 dark:text-gray-300 dark:border-gray-700 p-3 shadow-md placeholder:text-base border-gray-300 rounded-lg w-full focus:scale-105 ease-in-out duration-300"
                type="id" name="id_num" placeholder="ID Number"
                
              />
            </div>
            <div>
              <label for="password" class="mb-2 dark:text-gray-400 text-lg"
                >Password</label
              >
              <input
                id="password"
                class="border dark:bg-indigo-700 dark:text-gray-300 dark:border-gray-700 p-3 mb-2 shadow-md placeholder:text-base border-gray-300 rounded-lg w-full focus:scale-105 ease-in-out duration-300"
                type="password" name="password" placeholder="Password"
                
              />
            </div>
            <button
              class="bg-gradient-to-r from-blue-500 to-purple-500 shadow-lg mt-6 p-2 text-white rounded-lg w-full hover:scale-105 hover:from-purple-500 hover:to-blue-500 transition duration-300 ease-in-out"
              type="submit" value="Login" name="login" 
            >
              Log in
            </button>
          </form>
          <div class="flex flex-col mt-4 items-center justify-center text-sm">
            <h3>
              <span class="cursor-default dark:text-gray-300"
                >Don't have account?</span
              >
              <a
                class="group text-blue-400 transition-all duration-100 ease-in-out"
                href="SignUp.php"
              >
                <span
                  class="bg-left-bottom ml-1 bg-gradient-to-r from-blue-400 to-blue-400 bg-[length:0%_2px] bg-no-repeat group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out"
                  >Sign up</span
                >
              </a>
            </h3>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
