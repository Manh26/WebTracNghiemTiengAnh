<?php
session_start();
include 'connect.php';
$kh=null;
if (isset($_SESSION['UserID']) === true) {
    $kh = $_SESSION['UserID'];
 }
//  else{
//     echo '<script>alert("chua duoc tao");</script>';
// }
$itemsPerPage = 3;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $itemsPerPage;

$sql = "SELECT COUNT(*) FROM danhmuc";
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $sql .= " WHERE tendanhmuc LIKE :query";
    $stm = $conn->prepare($sql);
    $searchQuery = '%' . $query . '%';
    $stm->bindParam(':query', $searchQuery, PDO::PARAM_STR);
} else {
    $stm = $conn->prepare($sql);
}
$stm->execute();
$totalItems = $stm->fetchColumn();
$totalPages = ceil($totalItems / $itemsPerPage);

$sql = "SELECT Iddanhmuc, tendanhmuc FROM danhmuc";
if (isset($_GET['query'])) {
    $sql .= " WHERE tendanhmuc LIKE :query";
}
$sql .= " LIMIT :itemsPerPage OFFSET :offset";
$stm = $conn->prepare($sql);
if (isset($_GET['query'])) {
    $stm->bindParam(':query', $searchQuery, PDO::PARAM_STR);
}
$stm->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
$stm->bindParam(':offset', $offset, PDO::PARAM_INT);
$stm->execute();
$data = $stm->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrangChu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!DOCTYPE html>
    <html lang="vi">

    <head>

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

            .carousel-custom {
                max-width: 500px;

                margin: auto;
            }

            .carousel-custom img {
                width: 100%;
                height: auto;
                object-fit: cover;
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
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid justify-content-between">
                <a class="navbar-brand" href="#">USER</a>
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
                        <a href="dangnhap.html" class="btn btn-light">Đăng Nhập</a>

                        <button class="btn btn-light">Đăng Ký</button>
                        <button class="btn btn-light" onclick="logout()">Đăng Xuất</button>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/1.jpg" alt="Mô tả hình ảnh" title="hình ảnh tượng trưng" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="images/2.jpg" alt="Mô tả hình ảnh" title="hình ảnh tượng trưng" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="images/3.jpg" alt="Mô tả hình ảnh" title="hình ảnh tượng trưng" class="d-block w-100">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="content">
        <div class="left-side">
            <h1>Danh Mục</h1>
            <ul class="list-group">
                <li class="list-group-item active" aria-current="true">Bài Kiểm Tra</li>
                <li class="list-group-item">Đề</li>
                <a href="lichsulambai.php">
                    <li class="list-group-item">Lịch Sử làm bài</li>
                </a>
                <li class="list-group-item">Đăng Xuất</li>
            </ul>
        </div>
        <div class="right-side">
            <h2 style="text-align: center;">DANH SÁCH ĐỀ</h2>
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
                                <?php
                                if ($kh === null) { ?>
                                    <a href="dangnhap.html" class="btn btn-primary">Chọn</a>
                                <?php   } else {
                                ?>
                                    <a href="trangde.php?id=<?php echo $item->Iddanhmuc; ?>" class="btn btn-primary">Chọn</a>
                                <?php
                                }

                                ?>

                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>&query=<?php echo isset($query) ? $query : ''; ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&query=<?php echo isset($query) ? $query : ''; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>&query=<?php echo isset($query) ? $query : ''; ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <footer>

    </footer>
    <button id="back-to-top" class="btn btn-primary">Quay Lại Đầu Trang</button>
    <script>
        window.onscroll = function() {
            var backToTopButton = document.getElementById('back-to-top');
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                backToTopButton.style.display = "block";
            } else {
                backToTopButton.style.display = "none";
            }
        };


        document.getElementById('back-to-top').onclick = function() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        };
    </script>
</body>


</html>