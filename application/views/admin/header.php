<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #343a40;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
        }
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 px-0 sidebar">
                <div class="py-4 px-3 mb-4 text-white">
                    <h5>Administration</h5>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('admin'); ?>">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('admin/directory'); ?>">
                            <i class="fas fa-book"></i> Annuaires
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('admin/auth/logout'); ?>">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main content -->
            <div class="col-md-10 content">
