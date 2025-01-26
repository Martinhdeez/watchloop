<?php    
    require_once "../includes/functions.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="../assets/css/layout.css">
    <link rel="stylesheet" href="../assets/css/addItem.css">
    <link rel="favicon" type="image/webp" href="../includes/img/logo.webp">
    <title>Watchloop</title>
</head>
<?php   
    require_once "../includes/layout.php";
?>

<div class="watchDetails">
        <form action="../controllers/createItemController.php" method="post" class="form" enctype="multipart/form-data">
            <h2 class="title">Watch Details</h2>
            <div class="param">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="param">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>
            <div class="param">
                <label for="brand" class="form-label">Brand:</label>
                <input type="text" id="brand" name="brand" class="form-control" required>
            </div>
            <div class="param">
                <label for="condition">Condition: </label>
                <select name="condition" id="condition" class="form-control">
                    <option value="BRANDNEW">Brand new</option>
                    <option value="NEW">New</option>
                    <option value="LIKENEW">Like new</option>
                    <option value="USED">Used</option>
                    <option value="WORNOUT">Worn out</option>
                    <option value="NOTOPERATIONAL">Not operational</option>
                </select>
            </div>

            <div class="param">
                <h3 id="photos">Photos</h3>
                <div>
                    <div class="main_photo">
                        <label for="mainPhoto" class="form-label">Main Photo:</label>
                        <input type="file" name="mainPhoto" id="mainPhoto" class="form-control" required>
                    </div>
                    <div class="photo-grid">
                        <input type="file" name="photo1" id="photo1" class="form-control">
                        <input type="file" name="photo2" id="photo2" class="form-control">
                        <input type="file" name="photo3" id="photo3" class="form-control">
                        <input type="file" name="photo4" id="photo4" class="form-control">
                        <input type="file" name="photo5" id="photo5" class="form-control">
                        <input type="file" name="photo6" id="photo6" class="form-control">
                        <input type="file" name="photo7" id="photo7" class="form-control">
                        <input type="file" name="photo8" id="photo8" class="form-control">
                        <input type="file" name="photo9" id="photo9" class="form-control">
                        <input type="file" name="photo10" id="photo10" class="form-control">
                        <input type="file" name="photo11" id="photo11" class="form-control">
                        <input type="file" name="photo12" id="photo12" class="form-control">
                        <input type="file" name="photo13" id="photo13" class="form-control">
                        <input type="file" name="photo14" id="photo14" class="form-control">
                        <input type="file" name="photo15" id="photo15" class="form-control">
                        <input type="file" name="photo16" id="photo16" class="form-control">
                        <input type="file" name="photo17" id="photo17" class="form-control">
                        <input type="file" name="photo18" id="photo18" class="form-control">
                        <input type="file" name="photo19" id="photo19" class="form-control">
                        <input type="file" name="photo20" id="photo20" class="form-control">
                    </div >
                </div>

            </div>
        
            <button type="submit">Upload watch</button>
        </form>
    </div>
</body>
</html>