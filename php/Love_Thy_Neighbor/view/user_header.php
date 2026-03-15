<!DOCTYPE html>
<html>
<head>
    <title>Love Thy Neighbor</title> 

    <base href="http://localhost:8080/Love_Thy_Neighbor/">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/custom-bootstrap-styles.css">
    <link rel="stylesheet" type="text/css" href="styles/header.css">
    
</head>
<body>
    <main>

<header>
    <h1 id="header">Love Thy Neighbor</h1>
</header>
        <ul id="header_ul">             
        <li>
            <a href="user_manager?action=home">Home</a>
        </li>
        <li>
            <a href="request_manager?action=requests">Requests</a>
        </li>
        <li>
            <a href="">File Report</a>
        </li>
        <li>
            <?php if (isset($_SESSION['businessUser']) && $_SESSION['businessUser']->getIsAdmin() == 1) { ?>
                <a href="user_manager?action=edit_business">Edit Profile</a>
            <?php } else if (!isset($_SESSION['businessUser'])) { ?>
                <a href="user_manager?action=edit_user">Edit Profile</a>
            <?php } else if (isset($_SESSION['businessUser']) && $_SESSION['businessUser']->getIsAdmin() == 0) { ?>
                <a href="user_manager?action=edit_user">Edit Profile</a>
            <?php } ?>
        </li>
        <li>
            <a href="user_manager?action=logout_user">Logout</a>
        </li>
        </ul>

    
     
    
