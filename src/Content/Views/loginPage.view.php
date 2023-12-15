
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<style> 
    body{
    background-color: #2C231E;
    }

    .bg-beige-color{
        background-color:#EFE3C4;
        border-color:#EFE3C4
      }
      .bg-beige-color:focus,select:focus{
        border-color:#FCB716;
        box-shadow: 0 0 0 0.2rem #FCB716;
    
      }
      .bg-card-custom{
       background-color: #1C1713;
      }

      .custom-input-height {
        height: calc(3.5 * 1em); /* Adjust the multiplier as needed */
      }

      .mt-custom {
        margin-top: 10rem !important;
      }
      .mb-custom{
        margin-bottom: 10rem !important;
      }
      .ms-custom{
        padding-right: 25rem !important;
      }
      .me-custom{
        padding-left: 25rem !important;
      }
      .line-hyper{ 
        content:"";
        display:block;
        width: calc(10 * 1.05 * 1em);
        max-width:100%;
        border-bottom: 0.1em solid #EFE3C4;

      }

</style>

<div class="container-sm card p-1 bg-card-custom" mb-custom mt-custom me-custom ms-custom" >   
    <form class= style="height: 500px;" method="POST" action="/Account">
        <div class="container ms-3 mt-3">
            <h2 style="color:#EFE3C4">Sixth</h2>
            <h1 style="color:#EFE3C4">Inloggen</h1>
        </div>
            <div class="container col-auto ms-5 me-5 mb-2 mt-5">
              <div class="row">
                <input type="form-check-text"  class="form-control custom-input-height  bg-beige-color" id="email" name="email" placeholder="    E-mailadres" required></input>
              </div>
            </div>
            <div class="container col-auto ms-5 me-5 mb-2 mt-2">
              <div class="row">  
                <input type="password"  class="form-control custom-input-height  bg-beige-color" id="password" name="password" placeholder="    Wachtwoord" required></input>
              </div>
            </div>
            <div class="container col-auto mt-1">
              <div class="row">
                <div class="col-auto ms-4 me-4 text-center">
                    <a href="#" class="text-decoration-none" style="color:#EFE3C4">Wachtwoord vergeten?</a>
                  <div class="line-hyper"></div>
                </div>
              </div>
            </div>
            <div class="container col-auto mt-5">
              <div class="row">
                <div class="col-auto ms-3 text-center">
                <a href="/Register" id="registerButton" name="registerButton" class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color" style="width: 150px;background-color:#FCB716;border-color:#FCB716" value="Register" >Registreren</a>
                </div>
                <div class="col-auto me-3 text-center">
                <button type="submit" id="loginButton" name="loginButton" class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color" style="width: 150px;background-color:#FCB716;border-color:#FCB716" value="Login" >Inloggen</button>
                </div>
              </div>
            </div>
    </form>
</div>




<script>
        function ChangeURL() {
            // Get the current URL
            var currentURL = window.location.href;
            // Replace the path with '/Register'
            var newURL = currentURL.replace('Login', 'Register');

            // Perform the redirection
            window.location.href = newURL;
            return false;
        }
    </script>