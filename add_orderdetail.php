<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.82.0">
    <title>Add OrderDetail</title>
     <!-- WebIcon -->
  <link rel="icon" href="assets/img/Logo_T&M.png">
    <script src="https://kit.fontawesome.com/a2c5b72efa.js" crossorigin="anonymous"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <?php
if(isset($_POST["btn_add"]))
{
    include_once('connection.php');
    $orderid=$_POST["orderid"];
    $proid=$_POST["proid"];
    $quality=$_POST["quality"];
    if (trim($orderid) == "") {
        echo "<script type='text/javascript'>alert('OrderID can not be empty');</script>";
    }
    else if (trim($proid) == "") {
        echo "<script type='text/javascript'>alert('ProductID can not be empty');</script>";
    }
    else if (trim($quality) == "") {
      echo "<script type='text/javascript'>alert('Quality can not be empty');</script>";
  }
  else if (!is_numeric($quality)){
    echo "<script type='text/javascript'>alert('Quality must be a number');</script>";
}
    else{
    $sq="select * from `orderdetail` where orderid=$orderid and ProductID='$proid'";
    $res=pg_query($conn,$sq) or die(pg_error($conn));
    if(pg_num_rows($res)==0){
        pg_query($conn,"INSERT INTO `orderdetail`(`orderid`, `productid`, `quality`) VALUES ('$orderid','$proid','$quality')")
        or die(pg_error($conn));
        echo "<script type='text/javascript'>alert('Add OrderDetail Successful');</script>";
        echo "<script> location.href='admin_orderdetail.php'; </script>";
        exit;
    }
    else{
        echo "<script type='text/javascript'>alert('Duplicate orderid and productid');</script>";
        echo "<script> location.href='add_orderdetail.php'; </script>";
        exit;
    }
}
}
 ?>
    <!-- Custom styles for this template -->
    <link href="admin.css" rel="stylesheet">
    <link rel="stylesheet" href="btn.css">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow nav-color">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">ATN Store</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="admin_login.html"><i class="fas fa-sign-out-alt"></i>Sign Out</a>
    </li>
  </ul>
</header>

<div class="container-fluid">
  <div class="row">
  <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="admin_order.php">
              <i class="fas fa-list-alt">&nbsp;</i>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="admin_product.php">
              <i class="fas fa-box-open"></i>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_customer.php">
              <i class="fas fa-user-friends"></i>
              Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_feedback.php">
              <i class="fas fa-comment">&nbsp;</i>
              Feedback
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_brand.php">
            <i class="fas fa-cubes">&nbsp;</i>
              Brand
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="admin_orderdetail.php">
            <i class="fas fa-list-alt"></i>
              OrderDetail
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Admin</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>

      <h2>Add OrderDetail</h2>
      <div class="btn-cancel">
      <a class="btn btn-danger" href="admin_orderdetail.php" role="button"><i class="fas fa-times"></i><Span> Cancel</Span></a>
    </div>
        <form name="add_customer" method="post" action="">
              <!-- Text input -->
              <div class="form-outline mb-4">
                <label class="form-label" for="orderid">OrderID</label>
                <input name="orderid" type="number" id="orderid" class="form-control" placeholder="orderid" />
              </div>
              <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="proid">ProductID</label>
                                <input name="proid" type="text" id="proid" class="form-control" placeholder="productid" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="quality">Quality</label>
                                <input name="quality" type="number" id="quality" class="form-control" placeholder="quality"/>
                            </div>
                        </div>
                </div>
            <!-- Submit button -->
            <div class="btn-func">
                <button name="btn_add"  type="submit" class="btn btn-primary">ADD</button>
                <button  type="reset" class="btn btn-primary">RESET</button>
            </div>
          </form>
    </main>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>

