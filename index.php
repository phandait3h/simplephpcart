<?php
/**
 * Created by PhpStorm.
 * User: FR
 * Date: 12/25/2019
 * Time: 6:41 PM
 */
session_start();
require_once "database.php";
$database = new Database();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>

<?php if (isset($_SESSION['cart-item']) && !empty($_SESSION['cart-item'])) { ?>
    <div class="container">
        <h2>Giỏ hàng</h2>
        <p>Chi tiết giỏ hàng của bạn:</p>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Giá tiền</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Xóa khỏi giỏ hàng</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            foreach ($_SESSION['cart-item'] as $key_cart => $val_cart_item) :  ?>
                <tr>
                    <td><?php echo $val_cart_item['id'] ?></td>
                    <td><?php echo $val_cart_item['product_name'] ?></td>
                    <td><img src="images/<?php echo $val_cart_item['product_image']?>" alt="product" style="width:auto ;height:30px " ;></td>
                    <td><?php echo $val_cart_item['price'] ?></td>
                    <td><?php echo $val_cart_item['quantity'] ?></td>
                    <td><?php
                        $total_item = ($val_cart_item['price'] * $val_cart_item['quantity']);
                        echo number_format($total_item,0,",",".");
                        ?>
                        Vnđ</td>
                    <td>
                        <form action="process.php" name="remove<?php echo $val_cart_item['id'] ?>" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $val_cart_item['id'] ?>">
                            <input type="hidden" name="action" value="remove">
                            <input type="submit" name="submit" class="btn btn-sm btn-outline-secondary" value="Xóa">
                        </form>

                    </td>
                </tr>
                <?php
                $total += ($val_cart_item['price'] * $val_cart_item['quantity']);
            endforeach; ?>
            </tbody>
        </table>
        <div>Tổng hóa đơn thanh toán <strong><?php echo number_format($total,0,",",".");?> Vnđ</strong></div>
    </div>
<?php } else { ?>
    <div class="container">
        <h2>Giỏ hàng</h2>
        <p>Giỏ hàng của bạn đang bị rỗng</p>
    </div>
<?php } ?>
<div class="container" style="margin-top: 50px;">
    <div class="row">
        <?php
        $sql = "SELECT * from products";
        $products = $database->runQuery($sql);
        ?>

        <?php if (!empty($products)) : ?>


            <?php foreach ($products as $product) : ?>

                <div class="col-sm-6">
                    <form action="process.php" name="product<?php echo $product['id']?>" method="post">
                        <div class="card mb-4 shadow-sm">
                            <img src="images/<?php echo $product['product_image']?>" alt="camera" style="width:100% ;height:350px " ;>
                            <div class="card-body">
                                <p class="card-text" style="font-weight: bold">Product : <?php echo $product['product_name']?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-inline">
                                        <input type="text" class="form-control" name="quantity" value="1">
                                        <input type="hidden" name="action" value="add">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']?>">
                                        <label style="margin-left: 10px;">
                                            <input type="submit" name="submit" class="btn btn-sm btn-outline-secondary" value="Thêm vào giỏ hàng"></input>
                                        </label>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>


    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</body>
</html>