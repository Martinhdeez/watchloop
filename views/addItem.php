<?php    
require_once "../includes/header.php";
  
?>
<link rel="stylesheet" href="../assets/css/addItem.css">
</head>
<body>
<?php   
  require_once "../includes/functions.php"; 
  require_once "../includes/layout.php";
?>
<div id="content">
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
            <div class ="param">
                <label for="price" class="form-label">Price: </label>
                <input type="number" id="price" name="price" class="form-control" placeholder="Enter price in €" required>
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
                        <input type="file" name="photos[]" id="photo1" class="form-control">
                        <input type="file" name="photos[]" id="photo2" class="form-control">
                        <input type="file" name="photos[]" id="photo3" class="form-control">
                        <input type="file" name="photos[]" id="photo4" class="form-control">
                        <input type="file" name="photos[]" id="photo5" class="form-control">
                        <input type="file" name="photos[]" id="photo6" class="form-control">
                        <input type="file" name="photos[]" id="photo7" class="form-control">
                        <input type="file" name="photos[]" id="photo8" class="form-control">
                        <input type="file" name="photos[]" id="photo9" class="form-control">
                        <input type="file" name="photos[]" id="photo10" class="form-control">
                        <input type="file" name="photos[]" id="photo11" class="form-control">
                        <input type="file" name="photos[]" id="photo12" class="form-control">
                        <input type="file" name="photos[]" id="photo13" class="form-control">
                        <input type="file" name="photos[]" id="photo14" class="form-control">
                        <input type="file" name="photos[]" id="photo15" class="form-control">
                        <input type="file" name="photos[]" id="photo16" class="form-control">
                        <input type="file" name="photos[]" id="photo17" class="form-control">
                        <input type="file" name="photos[]" id="photo18" class="form-control">
                        <input type="file" name="photos[]" id="photo19" class="form-control">
                        <input type="file" name="photos[]" id="photo20" class="form-control">
                        <input type="file" name="photos[]" id="photo21" class="form-control">
                    </div >
                </div>

            </div>
        
            <button type="submit">Upload watch</button>
        </form>
    </div>

</div>

</body>
</html>