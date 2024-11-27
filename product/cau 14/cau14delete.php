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
   
    if (isset($_POST['productID']))
    {
        $productID=trim($_POST['productID']);
        // kiem tra csrf token 
        if ($_SESSION['csrf_token']!==$_POST['csrf_token'])
        {
            echo "token khong hop le";
            exit();
        }

        $stmt=$conn->prepare('delete from products where id=?');
        $stmt->bind_param('i',$productID);
        if ($stmt->execute())
        {
            echo "<script>
                    alert('Sản phẩm đã được xóa thành công');
                    window.location.href='cau14delete.php';
                </script>";
        }
        $stmt->close();
    }else{
            echo ' 
            <!DOCTYPE html>
            <html lang="vi">
            <head>
                <title>Tìm kiếm sản phẩm</title>
                <meta charset="UTF-8"> 
            </head>

            <body>
                <h1> Tìm kiếm sản phẩm</h1>
                <form action="cau14search.php" method ="POST">
                    <label>Tìm kiếm sản phẩm theo tên sản phẩm</label>
                    <input type="text" name="keyword" required>
                    <input type="submit" value="tìm kiếm">
                </form>
            </body>
            </html>';
    }
?>    
