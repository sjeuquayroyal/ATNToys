<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.82.0">
    <title>Update Product</title>
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
    include_once("connection.php");
    function bind_Category_List($conn,$selectedValue)
    {
        $sqlstring = "select * from brand";
        $result = pg_query($conn, $sqlstring);
        echo "<select name='BrandList' class='form-control'>
		<option value='0'>Choose category</option>";
        while ($row = pg_fetch_array($result, PG_ASSOC)) {
            if($row['BrandID']==$selectedValue){
                echo "<option value='" . $row['BrandID'] . "'selected>" . $row['brandname'] . "</option>";
            }
            else{
                echo "<option value='" . $row['BrandID'] . "'>" . $row['brandname'] . "</option>";
            }
        }
        echo "</select>";
    }
    ?>
    <?php
    if (isset($_POST["btn_update"])) {
        $proid = $_POST["proid"];
        $proname = $_POST["proname"];
        $price = $_POST["price"];
        $stock = $_POST["stock"];
        $brand = $_POST["brandlist"];
        $pic = $_FILES['img'];
        $description = $_POST['description'];

        if (trim($proid) == "") {
            echo "<script type='text/javascript'>alert('ProductID can not be empty');</script>";
        }
        else if (trim($proname) == "") {
            echo "<script type='text/javascript'>alert('ProductName can not be empty');</script>";
        }
        else if (trim($brand) == "") {
            echo "<script type='text/javascript'>alert('Brand can not be empty');</script>";
        }
        else if (trim($description) == "") {
            echo "<script type='text/javascript'>alert('Description can not be empty');</script>";
        }
        else if (!is_numeric($price)) {
            echo "<script type='text/javascript'>alert('Price must be a number');</script>";
        }
        else if (!is_numeric($stock)) {
            echo "<script type='text/javascript'>alert('Stock must be a number');</script>";
        } else {
            if ($pic['type'] == "image/jpg" || $pic['type'] == "image/jpeg" || $pic['type'] == "image/png" || $pic['type'] == "image/gif") {
                if ($pic['size'] < 614400) {
                    $sq = "select * from product where productid!='$proid' and productname='$proname'";
                    $result = pg_query($conn, $sq);
                    if (pg_num_rows($result) == 0) {
                        copy($pic['tmp_name'], "product-imgs/" . $pic['name']);
                        $filePic = $pic['name'];
                        $sqlstring = "UPDATE `product` SET
                        `productname`='$proname',`price`='$price',`Img`='$filePic',`Stock`='$stock',
                        `description`='$description',`brandid`='$brand'WHERE productid='$proid'";
                        pg_query($conn, $sqlstring) or die(pg_error($conn));
                        echo "<script type='text/javascript'>alert('Update Product Successful');</script>";
                        echo "<script> location.href='admin_product.php'; </script>";
                        exit;
                    } else {
                        echo "<script type='text/javascript'>alert('Duplicate product Name');</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('Size of image too big');</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert('Image format is not correct');</script>";
            }
        }
    }
    ?>
    <!-- <script type="text/javascript" src="check_add_customer.js"></script> -->
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
    <?php
	if (isset($_GET["id"])) {
		$id = $_GET["id"];
		$sqlsring = "select * from product where ProductID='$id'";
		$result = pg_query($conn, $sqlsring);
		$row = pg_fetch_array($result, PGSQL_ASSOC);
		$proname = $row["productname"];
        $proid = $row["productid"];
		$price = $row['price'];
		$pic = $row['img'];
		$stock= $row['stock'];
        $brand= $row['brandid'];
		$desciption = $row['description'];
	?>
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
            <a class="nav-link active" aria-current="page" href="admin_product.php">
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
            <a class="nav-link" href="admin_orderdetail.php">
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

                <h2>Update Product</h2>
                <div class="btn-cancel">
                    <a class="btn btn-danger" href="admin_product.php" role="button"><i class="fas fa-times"></i><Span> Cancel</Span></a>
                </div>
                <form name="add_product" method="post" enctype="multipart/form-data" role="form">
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="proid">PoductID</label>
                                <input name="proid" type="text" id="proid" class="form-control" placeholder="productid" value="<?php echo $proid;?>" readonly/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="img">Image</label>
                                <input type="file" name="img" id="img" class="form-control" value="<?php echo $pic;?>" />
                                <img src='product-imgs/<?php echo $pic; ?>' border='0' width="50" height="50" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="proname">PoductName</label>
                                <input name="proname" type="text" id="proname" class="form-control" placeholder="productname" value="<?php echo $proname;?>"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="brand">Brand</label>
                                <div> <?php bind_Category_List($conn,$brand); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="price">Price</label>
                                <input name="price" type="number" id="price" class="form-control" placeholder="price" value="<?php echo $price;?>"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="stock">Stock</label>
                                <input name="stock" type="number" id="stock" class="form-control" placeholder="stock" value="<?php echo $stock;?>"/>
                            </div>
                        </div>
                    </div>

                    <!-- Text input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="description">Description</label>
                        <textarea name="description" id="" class="form-control" cols="30" rows="7" placeholder="description"><?php echo $desciption;?></textarea>
                    </div>
                    <!-- Submit button -->
                    <div class="btn-func">
                        <button name="btn_update" type="submit" class="btn btn-primary">Update</button>
                        <button type="submit" class="btn btn-primary">RESET</button>
                    </div>
                </form>
            </main>
        </div>
    </div>
    <?php
	} else {
		echo '<meta http-equiv="refresh" content="0;URL=admin_product.php"?>';
	}
	?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>
