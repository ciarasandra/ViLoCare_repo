<?php
// ui-typography.php - Typography page for ViLoCare
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ViLoCare - Typography</title>
  <link href="css/app.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet" />
</head>
<body>
<div class="wrapper">
  <!-- Sidebar: include your existing sidebar here -->
  <!-- Main content -->
  <div class="main">
    <!-- Navbar: include your existing navbar here -->
    <main class="content">
      <div class="container-fluid p-4">
        <h1 class="h3 mb-4">Typography</h1>
        <div class="row">
          <div class="col-12 col-lg-6 mb-4">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Headings</h5>
                <h6 class="card-subtitle text-muted">All HTML headings, &lt;h1&gt; through &lt;h6&gt;, are available.</h6>
              </div>
              <div class="card-body">
                <h1>This is a heading h1</h1>
                <h2>This is a heading h2</h2>
                <h3>This is a heading h3</h3>
                <h4>This is a heading h4</h4>
                <h5>This is a heading h5</h5>
                <h6>This is a heading h6</h6>
              </div>
            </div>
            <div class="card mt-4">
              <div class="card-header">
                <h5 class="card-title mb-0">Coloured Text</h5>
                <h6 class="card-subtitle text-muted">Contextual text classes.</h6>
              </div>
              <div class="card-body">
                <p class="text-primary">This line of text contains the text-primary class.</p>
                <p class="text-secondary">This line of text contains the text-secondary class.</p>
                <p class="text-success">This line of text contains the text-success class.</p>
                <p class="text-danger">This line of text contains the text-danger class.</p>
                <p class="text-warning">This line of text contains the text-warning class.</p>
                <p class="text-info">This line of text contains the text-info class.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6 mb-4">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Inline Text</h5>
                <h6 class="card-subtitle text-muted">Styling for common inline HTML5 elements.</h6>
              </div>
              <div class="card-body">
                <p>You can use the <code>&lt;mark&gt;</code> tag to <mark>highlight</mark> text.</p>
                <p><del>This line of text can be treated as deleted text.</del></p>
                <p><ins>This line of text can be treated as an addition to the document.</ins></p>
                <p><strong>Bold text using the strong-tag</strong></p>
                <p><em>Italicized text using the em-tag</em></p>
              </div>
            </div>
            <div class="card mt-4">
              <div class="card-header">
                <h5 class="card-title mb-0">Blockquotes</h5>
                <h6 class="card-subtitle text-muted">For quoting blocks of content from another source within your document.</h6>
              </div>
              <div class="card-body">
                <blockquote class="blockquote">
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                  <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                </blockquote>
                <blockquote class="blockquote text-end">
                  <p>This is a reversed blockquote.</p>
                  <footer class="blockquote-footer">Another Source</footer>
                </blockquote>
              </div>
            </div>
            <div class="card mt-4">
              <div class="card-header">
                <h5 class="card-title mb-0">Lists</h5>
                <h6 class="card-subtitle text-muted">Unordered and ordered lists.</h6>
              </div>
              <div class="card-body">
                <ul>
                  <li>Lorem ipsum dolor sit amet</li>
                  <li>Consectetur adipiscing elit</li>
                </ul>
                <ol>
                  <li>Lorem ipsum dolor sit amet</li>
                  <li>Consectetur adipiscing elit</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Footer -->
    <!-- include footer here if needed -->
  </div>
</div>
<script src="js/app.js"></script>
</body>
</html>