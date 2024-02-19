<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple File Manager</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .btn {
            margin-bottom: 5px;
        }
        .list-group-item {
            word-wrap: break-word;
        }
        .file-content {
            height: 300px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Simple File Manager</a>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <!-- File List Section -->
                <div class="card">
                    <div class="card-header">
                        <h4>File List</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            $dir = "files/"; // Directory to scan
                            $files = scandir($dir);
                            foreach($files as $file) {
                                if ($file != "." && $file != "..") {
                                    echo '<div class="col-md-12 mb-2">';
                                    echo '<div class="list-group-item">';
                                    echo '<a href="?file=' . urlencode($file) . '">' . $file . '</a>';
                                    echo '<div class="btn-group float-right">';
                                    echo '<a href="?action=edit&file=' . urlencode($file) . '" class="btn btn-info btn-sm">Edit</a>';
                                    echo '<a href="?action=rename&file=' . urlencode($file) . '" class="btn btn-warning btn-sm">Rename</a>';
                                    echo '<a href="?action=delete&file=' . urlencode($file) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this file?\')">Delete</a>';
                                    echo '<form action="?action=chmod&file=' . urlencode($file) . '" method="post" class="btn-group">';
                                    echo '<input type="text" name="permission" class="form-control form-control-sm mr-1" placeholder="Permissions" style="max-width: 80px;">';
                                    echo '<button type="submit" class="btn btn-secondary btn-sm">Chmod</button>';
                                    echo '</form>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <!-- Upload File Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Upload File</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Upload File</button>
                        </form>
                    </div>
                </div>
                
                <!-- Create New File Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Create New File</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="filename" placeholder="Enter file name">
                            </div>
                            <button type="submit" class="btn btn-success btn-block" name="create">Create File</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <?php
                if(isset($_GET['file']) && file_exists("files/" . $_GET['file'])) {
                    echo '<div class="card">';
                    echo '<div class="card-header">';
                    echo '<h4>File Preview</h4>';
                    echo '</div>';
                    echo '<div class="card-body">';
                    echo '<div class="file-content">';
                    echo htmlspecialchars(file_get_contents("files/" . $_GET['file']));
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<hr>';
                    if(isset($_GET['action']) && $_GET['action'] == 'edit') {
                        echo '<div class="card">';
                        echo '<div class="card-header">';
                        echo '<h4>Edit File</h4>';
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<form action="" method="post">';
                        echo '<input type="hidden" name="filename" value="' . $_GET['file'] . '">';
                        echo '<div class="form-group">';
                        echo '<textarea class="form-control" name="filecontent" rows="10">' . htmlspecialchars(file_get_contents("files/" . $_GET['file'])) . '</textarea>';
                        echo '</div>';
                        echo '<button type="submit" class="btn btn-primary" name="edit">Save Changes</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                    }
                    elseif(isset($_GET['action']) && $_GET['action'] == 'rename') {
                        echo '<div class="card">';
                        echo '<div class="card-header">';
                        echo '<h4>Rename File</h4>';
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<form action="" method="post">';
                        echo '<input type="hidden" name="old_filename" value="' . $_GET['file'] . '">';
                        echo '<div class="form-group">';
                        echo '<input type="text" class="form-control" name="new_filename" value="' . $_GET['file'] . '" placeholder="Enter new file name">';
                        echo '</div>';
                        echo '<button type="submit" class="btn btn-warning" name="rename">Rename File</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2024 Javatech.id. All rights reserved.
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Code for handling file operations
?>
