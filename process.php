<?php
/**
 * Created by PhpStorm.
 * User: FR
 * Date: 12/26/2019
 * Time: 12:16 AM
 */
session_start();
require_once "database.php";
$database = new Database();
if (isset($_POST) && !empty($_POST)) {
    /**
    Check xem $_POST có tồn tại tức là có dữ liệu được gửi đi
     * dồng thời !empty tức là nó sẽ có dữ liệu được gửi liệu
     */
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if (isset($_POST['quantity']) && isset($_POST['product_id'])) {
                    $sql = "SELECT * FROM products where id =". (int)$_POST['product_id'];
                    $product = $database->runQuery($sql);
                    $product = current($product);
                    $product_id = $product['id'];
                    echo '<br> $product';
                    echo "<pre>";
                    print_r($product);
                    echo "</pre>";
                    if (isset($_SESSION['cart-item']) && !empty($_SESSION['cart-item'])) {
                        // giỏ hàng có dữ liệu
                        if (isset($_SESSION['cart-item'][$product_id])) {
                            $exist_cart_item = $_SESSION['cart-item'][$product_id];
                            $exist_quantity = $exist_cart_item['quantity'];
                            $cart_item = array();
                            $cart_item['id'] =$product['id'];
                            $cart_item['product_name'] = $product['product_name'];
                            $cart_item['product_image'] = $product['product_image'];
                            $cart_item['price'] = $product['price'];
                            $cart_item['quantity'] = $exist_quantity + $_POST['quantity'];
                            $_SESSION['cart-item'][$product_id] = $cart_item;
                        } else {
                            $cart_item = array();
                            $cart_item['id'] =$product['id'];
                            $cart_item['product_name'] = $product['product_name'];
                            $cart_item['product_image'] = $product['product_image'];
                            $cart_item['price'] = $product['price'];
                            $cart_item['quantity'] = $_POST['quantity'];
                            $_SESSION['cart-item'][$product_id] = $cart_item;
                        }
                    }
                    else {
                        // giỏ hàng chưa có dữ liệu
                        $_SESSION['cart-item'] = array();
                        $cart_item = array();
                        $cart_item['id'] =$product['id'];
                        $cart_item['product_name'] = $product['product_name'];
                        $cart_item['product_image'] = $product['product_image'];
                        $cart_item['price'] = $product['price'];
                        $cart_item['quantity'] = $_POST['quantity'];
                        $_SESSION['cart-item'][$product_id] = $cart_item;
                    }
                }
                break;
            case 'remove':
                if (isset($_POST['product_id'])) {
                    $product_id = $_POST['product_id'];
                    if (isset($_SESSION['cart-item'][$product_id])) {
                        unset($_SESSION['cart-item'][$product_id]);
                    }
                }
                break;
            default:
                echo "Action không tồn tại";
                die;
        }
    }
}
header("Location: http://localhost:8080/1909ePHP/Homework/simplephpcart/index.php");
die;
?>