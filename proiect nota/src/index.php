<?php
    session_start();
    if (isset($_SESSION["myuser"])) {
        $login_button = '<a href="logout.php" class="btn btn-secondary">Log out</a>';
        if (isset($_SESSION["is_admin"]) && $_SESSION["myuser"] == "admin" && $_SESSION["mypassword"] == "admin") {
            $admin_button = '<a href="zonasecurizata.php" class="btn btn-primary">Go to admin page</a>';
        } else {
            $admin_button = '';
        }
    } else {
        $login_button = '<a href="login.php" class="btn btn-secondary">Log in</a>';
        $admin_button = '';
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Amour Coffee Bar</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Custom Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <script src="js/rightclick.js"></script>
    <script src="js/select.js"></script>
    <body class="d-flex flex-column h-100">
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ro_RO/sdk.js#xfbml=1&version=v19.0" nonce="mdoEQe8g"></script>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ro_RO/sdk.js#xfbml=1&version=v19.0" nonce="d2E4vnw8"></script>
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.php"><span class="fw-bolder text-primary">Home Page</span></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
                            <li class="nav-item"><a class="nav-link" href="schedule.php">Schedule</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                            <?php echo $login_button;?>
                            <?= $admin_button?>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <!-- Header-->
            <header class="py-5">
                <div class="container px-5 pb-5">
                    <div class="row gx-5 align-items-center">
                        <div class="col-xxl-5">
                            <!-- Header text content-->
                            <div class="bg-body rounded-4 p-5">
                                <div class="text-center text-xxl-start">
                                    <div class="fs-3 fw-light text-muted ">We can help you</div>
                                    <h1 class="display-3 fw-bolder mb-5"><span class="text-secondary">Taste the feeling of real coffee</span></h1>
                                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xxl-start mb-3">
                                        <a class="btn btn-secondary btn-lg px-5 py-3 me-sm-3 fs-6 fw-bolder " href="menu.php" id="menu-button">Menu</a>
                                        <script>
                                            const button = document.getElementById("menu-button");
                                            const buttonWidth = button.offsetWidth;
                                            const buttonHeight = button.offsetHeight;
                                            const canvas = document.createElement("canvas");
                                            canvas.width = buttonWidth;
                                            canvas.height = buttonHeight;
                                            const ctx = canvas.getContext("2d");
                                            const gradient = ctx.createLinearGradient(0, 0, buttonWidth, 0);
                                            gradient.addColorStop(0, "lightblue");
                                            gradient.addColorStop(0.5, "pink");
                                            gradient.addColorStop(1, "purple");
                                            ctx.fillStyle = gradient;
                                            ctx.fillRect(0, 0, buttonWidth, buttonHeight);
                                            button.style.backgroundImage = `url(${canvas.toDataURL()})`;
                                        </script>
                                        <a class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder " href="schedule.php">Schedule</a>
                                    </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-xxl-7">
                            <!-- Header profile picture-->
                            <div class="d-flex justify-content-center mt-5 mt-xxl-0">
                                <div class="profile">
                                    <img class="profile-img" src="assets/logo.png" alt="..." />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- About Section-->
            <section class="bg-light py-5">
                <div class="container px-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-xxl-8">
                            <div class="text-center my-5">
                                <h2 class="display-5 fw-bolder"><span class="text-gradient d-inline">About Us</span></h2>
                                <p class="lead fw-light mb-4">Our name is Amour Coffee Bar.</p>
                                <p class="text-muted">Our purpose is to give you the antique taste of real coffee, back from 1945. We serve the real recipe from the creator himself, Hans Kaffnaus</p>
                                <div class="d-flex justify-content-center fs-2 gap-4">
                                    <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="200" data-layout="" data-action="" data-size="" data-share="true"></div>
                                </div>                               
                            </div>
                        </div>
                    </div>
                </div>  
            </section>
        </main>
        <!-- Footer-->
        <footer class="bg-white py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0">Copyright &copy; Your Website 2023</div></div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ro_RO/sdk.js#xfbml=1&version=v20.0" nonce="nxPo1lQf"></script>
    </body>
</html>
