<!DOCTYPE html>
<html>
<head>
    <title>Love Thy Neighbor</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="http://localhost:8080/Love_Thy_Neighbor/">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/custom-bootstrap-styles.css">
    <link rel="stylesheet" type="text/css" href="styles/header.css">
    <link rel="stylesheet" type="text/css" href="styles/fx.css">
    
</head>

<body>
<main>

<div class="custom-border-outset shadow">
    <!-------------------- Title Row ------------------------>
    <div class="container-fluid text-center py-3 bg-custom-blue border-0">
        <a class="text-decoration-none text-custom-white fw-bold fs-1"
        href="user_manager?action=home">
            Love Thy Neighbor
        </a>
    </div>

    <!---------------------- Navbar Row -------------------------->
    <nav class="navbar navbar-expand-lg navbar-dark bg-custom-black border-0">
        <div class="container justify-content-center">

            <!--------------- Mobile Toggle ------------------>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!---------------- Navigation --------------------->
            <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">

                <ul class="navbar-nav gap-5">

                    <li class="nav-item fs-4">
                        <a class="nav-link text-custom-white" href="user_manager?action=home">Home</a>
                    </li>

                    <li class="nav-item fs-4">
                        <a class="nav-link text-custom-white" href="user_manager?action=users">Users</a>
                    </li>

                    <li class="nav-item fs-4">
                        <a class="nav-link text-custom-white" href="request_manager?action=requests">Requests</a>
                    </li>

                    <li class="nav-item fs-4">
                        <a class="nav-link text-custom-white" href="report_manager?action=file_report">File Report</a>
                    </li>

                    <li class="nav-item fs-4">
                        <?php if (isset($_SESSION['businessUser']) && $_SESSION['businessUser']->getIsAdmin() == 1) { ?>
                            <a class="nav-link text-custom-white" href="user_manager?action=edit_business">Edit Profile</a>
                        <?php } else { ?>
                            <a class="nav-link text-custom-white" href="user_manager?action=edit_user">Edit Profile</a>
                        <?php } ?>
                    </li>

                    <li class="nav-item fs-4">
                        <a class="nav-link text-danger fw-semibold"
                        href="user_manager?action=logout_user">
                            Logout
                        </a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</div>
    
     
    
