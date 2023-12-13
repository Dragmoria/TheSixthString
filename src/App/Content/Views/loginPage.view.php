
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

</style>

<div class="container-sm mb-custom mt-custom me-custom ms-custom" >   
    <form class="card p-1 bg-card-custom" style="height: 500px;" method="POST" action="/Account" onsubmit="return validatePasswords()">
        <div class="container ms-3 mt-3">
        <h1 style="color:#EFE3C4">Sixt</h1>
            <div class="container mt-5">
                <input type="form-check-text" class="rounded-pill bg-beige-color" id="username" name="username" placeholder="username"></input>
            </div>
        </div>
    </form>
</div>