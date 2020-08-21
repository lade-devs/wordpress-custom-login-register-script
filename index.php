<?php
// Template Name: Custom Home Page
// Template Post Type: page

get_header();

?>
<!--- 
    This template is used as a custom home page which displays login and register form
    === Feel free to tweak the forms to suit your taste ===
  -->

  <style tyle="text/css">
        .formInput{
            padding:10px;
        }
  </style>

  <form method="Post">
        <div class="formInput">
            <input type="email" name="emailLogin" placeholder="Enter Email Address">
        </div>
        <div class="formInput">
            <input type="password" name="passwordLogin" placeholder="Enter Password">
        </div>
        <div class="formInput">
            <input type="submit" name="submitLogin" value="Login">
        </div>
  </form>

   <form method="Post">
        <div class="formInput">
            <input type="text" name="fullnameRegister" placehoder="Enter Full Name">
        </div>
        <div class="formInput">
            <input type="email" name="emailRegister" placeholder="Enter Email Address">
        </div>
        <div class="formInput">
            <input type="password" name="passwordRegister" placeholder="Enter Password">
        </div>
        <div class="formInput">
            <input type="submit" name="submitRegister" value="Register">
        </div>
   </form>     


   <?php
        # Handles Login Form
        if(isset($_POST['submitLogin'])){
                   $emailLogin = sanitize_email($_POST['emailLogin']);
                   $passwordLogin =  esc_attr($_POST['passwordLogin']);

                   loginFunc($emailLogin,$passwordLogin);
                }

        # Handles Registration Form
        if(isset($_POST['submitRegister'])){

                    $fullnameRegister = sanitize_text_field($_POST['fullnameRegister']);
                    $emailRegister    = sanitize_email($_POST['emailRegister']);
                    $passwordRegister = esc_attr($_POST['passwordRegister']);

                    registerFunc($fullnameRegister,$emailRegister,passwordRegister);

                }        
    ?>