<?php
session_start();
include ('connect.php');
include ('validation.php');

    // tao csrf token neu chua co 
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
    if($result->num_rows===0)
    {
        echo "<script>alert('khong co san pham nao');
        window.location.href='search.html';
        </script>";
        exit();
    }
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
                <form method = "POST" action = "cau14delete.php" >
                    <input type="hidden" name="productID" value="<?php echo $product['id']; ?>" >
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" >
                    <input type="submit" value="Xoa">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
        
    </table>
</body>
</html>

<?php $conn->close(); ?>


        
