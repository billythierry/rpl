<?php
    include 'components/connection.php';
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else{
        $user_id = '';
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header("location: home.php");
    }    
?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Green Coffee - home page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <section class="home-section">
            <div class="slider">
                <div class="slider__slider slide1">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Lorem ipsum dolor sit</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, cum? Corrupti placet ex</p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="slider__slider slide2">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>welcome to my shop</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, cum? Corrupti placet ex</p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="slider__slider slide3">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Lorem ipsum dolor sit</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, cum? Corrupti placet ex</p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="slider__slider slide4">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Lorem ipsum dolor sit</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, cum? Corrupti placet ex</p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="slider__slider slide5">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Lorem ipsum dolor sit</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, cum? Corrupti placet ex</p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
                <div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
            </div> 
        </section>
        <!-- home slider end -->
         <section class="thumb">
            <div class="box-container">
                <div class="box">
                    <img src="img/logo tengah ikan 1.png">
                    <h3>Sea Fish</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="img/logo tengah ikan hias 2.png">
                    <h3>Sell Fish</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="img/logo tengah ikan hias 3.png">
                    <h3>Fish Fighter</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="img/logo tengah ikan 4.png">
                    <h3>Unique Fish</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
            </div>
         </section>
         <section class="container">
            <div class="box-container">
                <div class="box">
                    <img src="img/slide3.jpg">
                </div>
                <div class="box">
                    <img src="img/ikan 1.png">
                    <span>Fighter Fish</span>
                    <h1>save up to 50% off</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
         </section>
         <section class="shop">
            <div class="tittle">
                <img src="img/ikan 1.png">
                <h1>Trending Products</h1>
            </div>
            <div class="row">
                <img src="img/cupang.png">
                <div class="row-detail">
                    <img src="img/banner1.png">
                    <div class="top-footer">
                        <h1>Best fish of nature makes you healty and happy</h1>
                    </div>
                </div>
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="img/slide2.jpg">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="img/slide1.jpg">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="img/slide2.jpg">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="img/slide4.jpg">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="img/slide5.jpg">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="img/slide3.jpg">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
         </section>
         <section class="shop-category">
                <div class="box-container">
                    <div class="box">
                        <img src="img/slide2.jpg">
                        <div class="detail">
                            <span>BIG OFFERS</span>
                            <h1>Extra 15% off</h1>
                            <a href="view_products.php" class="btn">shop now</a>
                        </div>
                    </div>
                    <div class="box">
                        <img src="img/slide1.jpg">
                        <div class="detail">
                            <span>new in taste</span>
                            <h1>coffee house</h1>
                            <a href="view_products.php" class="btn">shop now</a>
                        </div>
                    </div>
                </div>
         </section>
         <section class="services">
            <div class="box-container">
                <div class="box">
                    <img src="img/icon2.png">
                    <div class="detail">
                        <h3>great savings</h3>
                        <p>save big every order</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon1.png">
                    <div class="detail">
                        <h3>24*7 support</h3>
                        <p>one-on-one support</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon0.png">
                    <div class="detail">
                        <h3>gift vouchers</h3>
                        <p>vouchers on every festivals</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon.png">
                    <div class="detail">
                        <h3>worldwide delivery</h3>
                        <p>dropship worldwide</p>
                    </div>
                </div>
            </div>
         </section>
         <section class="brand">
            <div class="box-container">
                <div class="box">
                    <img src="img/ikan 1.png">
                </div>
                <div class="box">
                    <img src="img/logo tengah ikan 1.png">
                </div>
                <div class="box">
                    <img src="img/logo tengah ikan hias 2.png">
                </div>
                <div class="box">
                    <img src="img/logo tengah ikan 4.png">
                </div>
                <div class="box">
                    <img src="img/cupang.png">
                </div>
            </div>
         </section>
        <?php include 'components/footer.php'; ?> 
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>