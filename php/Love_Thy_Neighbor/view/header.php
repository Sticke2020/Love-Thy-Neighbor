<!DOCTYPE html>
<html>
<head>
    <title>Love Thy Neighbor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="http://localhost:8080/Love_Thy_Neighbor/"> 
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/custom-bootstrap-styles.css">
    <link rel="stylesheet" type="text/css" href="styles/header.css">
</head>

<body>
<main>
        
<!------------------- Title Row -------------------->
<div class="container-fluid text-center py-3 bg-custom-light-yellow shadow-sm">
    <a class="text-decoration-none text-dark fw-bold fs-1"
       href="user_manager?action=home">
        Love Thy Neighbor
    </a>
</div>

<!------------------- Navbar Row -------------------->
<nav class="navbar navbar-expand-lg navbar-dark bg-custom-black border-top">
    <div class="container justify-content-center">

        <!----------------- Mobile Toggle ------------------>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!----------------- Navigation -------------------->
        <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">

            <ul class="navbar-nav gap-5">

                <li class="nav-item fs-4">
                    <a class="nav-link text-custom-white" href="user_manager/index.php?action=sign_up">Sign up</a>
                </li>

                <li class="nav-item fs-4">
                    <a class="nav-link text-custom-white" href="user_manager?action=login_user">Login</a>
                </li>

            </ul>

        </div>
    </div>
</nav>

    
     
    
