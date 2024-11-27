<?php 
session_start();
include('connect.php');
    // kiem tra dang nhap
    if (!isset($_SESSION['status'])||$_SESSION['status']!='login')
    {
        header('location:login.php');
        exit();
    }
    // kiem tra vai tro
    if ($_SESSION['role']!=='Admin')
    {
        header('location:login.php');
        exit();
    }
    if (isset($_GET['productID']))
    {
        $productID=trim($_GET['productID']);
        $stmt=$conn->prepare('delete from products where id=?');
        $stmt->bind_param('i',$productID);
        if ($stmt->execute())
        {
            echo "<script>
                    alert('Sản phẩm đã được xóa thành công');
                    window.location.href = document.referrer;
                </script>";
        }
        $stmt->close();
        $conn->close();
    }else{
        header('location:search.html');
    }
?>    
