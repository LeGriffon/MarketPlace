
<nav id ="mainNavbar" class="navbar navbar-dark navbar-expand-md py-0 fixed-top">
    <a href="index.php" class="navbar-brand">
    <img src="imgs/logo/Heidelberg-h-01.svg" width="30" height="30" class="d-inline-block align-top" alt="">
    HyperKar
    </a>
    <button class="navbar-toggler" data-toggle="collapse" data-target="#navLinks" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navLinks">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
            <a href="index.php" class="nav-link">HOME</a>
            </li>
            <li class="nav-item">
            <a href="about.php" class="nav-link">ABOUT</a>
            </li>
            <li class="nav-item">
            <a href="products.php" class="nav-link">PRODUCTS</a>
            </li>
            <li class="nav-item">
            <a href="news.php" class="nav-link">NEWS</a>
            </li>
            <li class="nav-item">
            <a href="contact.php" class="nav-link">CONTACT</a>
            </li>
            <li class="nav-item">
            <a href="admin.php" class="nav-link">ADMIN</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
            <?php
            if(isset($_SESSION['UserData']['Username'])){
                echo '<a href="userpage.php" class="nav-link">WELCOME BACK, ' . strtoupper($_SESSION['UserData']['Username']) . '</a>';
            }
            else{
                echo '<a href="login.php" class="nav-link">LOGIN</a>';
            }
            ?>
            </li>
            <li class="nav-item">
            <?php
            if(isset($_SESSION['UserData']['Username'])){
                echo '<a href="html/secure/logout.php" class="nav-link">LOG OUT</a>';
            }
            else{
                echo '<a href="signup.php" class="nav-link">SIGN UP</a>';
            }
            ?>
            </li>
        </ul>
    </div>
</nav>