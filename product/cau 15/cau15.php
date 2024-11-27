<?php
session_start();
include ('connect.php');

    // kiem tra phien lam viec
    if(!isset($_SESSION['status'])||$_SESSION['status']!='login')
    {
        header('location:login.php');
        exit();
    }

    // kiem tra vai tro 
    if($_SESSION['role']!=='Admin')
    {
        echo "<script>alert('ban khong co quyen');
              window.location.href='login.php';
              </script>";
              exit();
    }

    // kiem tra csrf_token
    if(!isset($_SESSION['csrf_token']))
    {
        $_SESSION['csrf_token']=bin2hex(random_bytes(32));
    }

    
    $keyword=trim($_POST['keyword']);
    // truy xuat va hien ket qua 
    $stmt=$conn->prepare('select p.id,p.name,p.price,p.description,c.category_name from products 
                        p join categories c on p.category_id=c.id where p.name like ?');
    $key="%$keyword%";
    $stmt->bind_param('s',$key);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows === 0)
    {
        echo "<script>alert('khong co san pham nao');
        window.location.href='search.html';
        </script>";
        exit();
    }
    $stmt->close();
    $conn->close();
?>
<!DOCTYPE html>
<html lang="vn">
<head>
</head>
<body>
    <h1> danh sach san pham </h1>
    <table border="1">

    <tr>
        <th>id</th>
        <th>Ten San Pham</th>
        <th>gia</th>
        <th>mo ta</th>
        <th>loai san pham</th>
        <th></th>
        <th></th>
    </tr>

 
    <?php while($product=$result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($product['id']); ?> </td>
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td><?php echo htmlspecialchars($product['price']); ?></td>
            <td><?php echo htmlspecialchars($product['description']); ?> </td>
            <td><?php echo htmlspecialchars($product['category_name']); ?></td>
            <td>
                <form method="POST" action="update.php">
                    <input type="hidden" name="productID" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name='csrf_token' value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="submit" value="Cap Nhat">
                </form>
            </td>
            <td>
                <form method="POST" action="delete.php">
                    <input type="hidden" name="productID" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name='csrf_token' value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="submit" value="Xoa">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
        
    </table>
</body>
</html>


        
