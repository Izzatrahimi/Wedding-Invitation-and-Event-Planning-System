<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <!-- custom css file link  -->
  <link rel="stylesheet" href="style2.css">

</head>
<body>

  <!-- header section starts  -->

  <header>

    <a href="../index.html" class="logo">WED GALA</a>

    <div id="menu-bar" class="fas fa-bars"></div>

    <nav class="navbar">
      <a href="../index.html">Home</a>
      <a href="#vendor">Vendor</a>
      <a href="#team">Team</a>
      <a href="#contact">Contact</a>
      <a href="signup.php">Register</a>
    </nav>

  </header>

  <!-- header section ends  -->

  <!-- login section starts  -->

  <section class="section1">

    <div class="container">
      <h1 class="header">Login Form</h1>

      <form method="POST" action="process.php">

        <div class="input-field">
          <input type="text" name="username" required>
          <label>Username</label>
        </div>

        <div class="input-field">
          <input class="pswrd" type="password" name="password" required>
          <span class="show">SHOW</span>
          <label>Password</label>
        </div>

        <div class="forgot">
          <a href="#">Forgot password?</a>
        </div>

        <div class="button">
          <div class="inner"></div>
          <button type="submit" name="login">LOGIN</button>
        </div>

      </form>

      <div class="auth">
        Or login with
      </div>

      <div class="links">

        <div class="facebook">
          <i class="fab fa-facebook-square"><span>Facebook</span></i>
        </div>

        <div class="google">
          <i class="fab fa-google-plus-square"><span>Google</span></i>
        </div>

      </div>

      <div class="signup">

        <h2>Don't have an account yet? 
          <a href="signup.php">Create account</a> 
        </h2>

      </div>

    </div>

    <script>
      var input = document.querySelector('.pswrd');
      var show = document.querySelector('.show');
      show.addEventListener('click', active);
      function active(){
        if(input.type === "password"){
          input.type = "text";
          show.style.color = "#1DA1F2";
          show.textContent = "HIDE";
        }else{
          input.type = "password";
          show.textContent = "SHOW";
          show.style.color = "#111";
        }
      }
    </script>

  </section>



  <!-- footer section  -->

  <div class="footer"> created by <span>Muhd Izzat</span> | all rights reserved! </div>


  <script> 

    let menu = document.querySelector('#menu-bar');
    let navbar = document.querySelector('.navbar');

    menu.addEventListener('click', () =>{
      menu.classList.toggle('fa-times');
      navbar.classList.toggle('nav-toggle');
    });

    window.onscroll = () =>{
      menu.classList.remove('fa-times');
      navbar.classList.remove('nav-toggle');
    }

  </script>


</body>
</html>