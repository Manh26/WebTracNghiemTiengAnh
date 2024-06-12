<?php 
include 'connect.php';

$query = '';
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $sql = "SELECT Iddanhmuc, tendanhmuc FROM danhmuc WHERE tendanhmuc LIKE :query";
    $stm = $conn->prepare($sql);
    $searchQuery = '%' . $query . '%';
    $stm->bindParam(':query', $searchQuery, PDO::PARAM_STR);
} else {
    $sql = "SELECT Iddanhmuc, tendanhmuc FROM danhmuc";
    $stm = $conn->prepare($sql);
}



$stm->execute();
$data = $stm->fetchAll(PDO::FETCH_OBJ);


$itemsPerPage =3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;
$sql .= " LIMIT :itemsPerPage OFFSET :offset";
$stm = $conn->prepare($sql);
$stm->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
$stm->bindParam(':offset', $offset, PDO::PARAM_INT);

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrangChu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrangChu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            height: 100vh;
            background-color: #f4f4f9;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
            background-color: #007bff;
        }

        .content {
            display: flex;
            flex: 1;
            margin-top: 10px;
        }

        .left-side {
            width: 30%;
            background-color: #f0f0f0;
            padding: 20px;
            box-sizing: border-box;
        }

        .right-side {
            width: 70%;
            background-color: #ffffff;
            padding: 20px;
            box-sizing: border-box;
            border-left: 1px solid #ccc;
        }

        h1 {
            text-align: center;
        }

        p {
            text-align: justify;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar-brand,
        .navbar-nav .nav-link,
        .navbar-nav .dropdown-item {
            color: #fff !important;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255, 255, 255, 0.5%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        .btn {
            margin-right: 10px;
        }

        .list-group-item.active {
            background-color: #007bff;
            border-color: #007bff;
        }

        .banner-container {
            width: 100%;
            overflow: hidden;
        }

        .banner-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        #back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
        }

        .custom-align-right {
            justify-content: flex-end;
        }
    </style>
</head>

<body>
    <header class="navbar navbar-expand-lg bd-navbar">
        <script>
            function logout() {
                window.location.href = "dangnhap.html";
            }
        </script>
           <script>
window.onload = function() {
	const urlParams = new URLSearchParams(window.location.search);
	const status = urlParams.get('status');
	if (status === 'success') {
		alert('Thao tác thành công!');
	} else if (status === 'fail') {
		alert('Thao tác thất bại. Vui lòng thử lại.');
	}
}
</script>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid justify-content-between">
                <a class="navbar-brand" href="#">ADMIN</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Đề</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tài Khoản
                            </a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search" method="GET" action="">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                    <div class="d-flex align-items-center custom-align-right">
                        <button class="btn btn-light">Đăng Nhập</button>
                        <button class="btn btn-light">Đăng Ký</button>
                        <button class="btn btn-light" onclick="logout()">Đăng Xuất</button>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="banner-container">
        <img src="images/download (1).jpg" alt="Mô tả hình ảnh" title="hình ảnh tượng trưng">
    </div>

    <div class="content">
        <div class="left-side">
            <h1>Danh Mục</h1>
            <ul class="list-group">
                <li class="list-group-item active" aria-current="true">Bài Kiểm Tra</li>
                <li class="list-group-item">Đề</li>
                <li class="list-group-item">Lịch Sử làm bài</li>
                <li class="list-group-item">Đăng Xuất</li>
            </ul>
        </div>
        <div class="right-side">
            <h2 style="text-align: center;">DANH SÁCH ĐỀ</h2>
            <form method="POST" action="themdanhmucadmin.php">
                <div class="mb-3">
                    <label for="iddanhmuc" class="form-label">ID Danh Mục</label>
                    <input type="text" class="form-control" id="iddanhmuc" name="iddanhmuc" required>
                </div>
                <div class="mb-3">
                    <label for="tendanhmuc" class="form-label">Tên Danh Mục</label>
                    <input type="text" class="form-control" id="tendanhmuc" name="tendanhmuc" required>
                </div>
                <button type="submit" class="btn btn-primary">Thêm</button>
            </form>
            <table class="table table-striped table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tên Đề</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $item) {
                    ?>
                        <tr>
                            <td><?php echo $item->Iddanhmuc ?></td>
                            <td><?php echo $item->tendanhmuc ?></td>
                            <td>
                            <a href="xoadanhmuc.php?id=<?php echo $item->Iddanhmuc ?>" class="btn btn-primary">Xóa</a>

                                <a href="trangde.php?id=<?php echo $item->Iddanhmuc ?>" class="btn btn-primary">Sửa</a>

                                <a href="trangdeadmin.php?id=<?php echo $item->Iddanhmuc ?>" class="btn btn-primary">Chọn Đề</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer>
        <!-- Nội dung footer nếu có -->
    </footer>
    <button id="back-to-top" class="btn btn-primary">Quay Lại Đầu Trang</button>
    <script>
        // Show or hide the back-to-top button
        window.onscroll = function() {
            var backToTopButton = document.getElementById('back-to-top');
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                backToTopButton.style.display = "block";
            } else {
                backToTopButton.style.display = "none";
            }
        };

        // Scroll to the top of the page when the button is clicked
        document.getElementById('back-to-top').onclick = function() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        };
    </script>
</body>

</html>
