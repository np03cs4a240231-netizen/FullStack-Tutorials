<?php 
require 'header.php'; 
require 'functions.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['portfolio'])) {
    try {
        $newFile = uploadPortfolioFile($_FILES['portfolio']);
        $message = '<p class="success">File uploaded successfully as: ' . htmlspecialchars($newFile) . '</p>';
    } catch (Exception $e) {
        $message = '<p class="error">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
}
?>

<h2>Upload Portfolio File</h2>
<p>Allowed: PDF, JPG, PNG | Max: 2MB</p>
<?php echo $message; ?>

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152"> <!-- 2MB -->
    <label>Select file: <input type="file" name="portfolio" required></label><br><br>
    <button type="submit">Upload</button>
</form>

<?php require 'footer.php'; ?>