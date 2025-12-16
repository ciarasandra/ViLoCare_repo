<?php
// footer.php
?>
<footer class="footer">
    <div class="container-fluid"><!-- fixed typo: contiainer-fluid -->
        <div class="row text-muted">
            <div class="col-6 text-start">
                <p class="mb-0">
                    <strong>ViLoCare Admin System</strong> &copy; <?php echo date("Y"); ?>
                </p>
            </div>
            <div class="col-6 text-end">
                <p class="mb-0">Built with AdminKit 3.3.0</p>
            </div>
        </div>
    </div>
</footer>  
</div><!-- end .main -->
</div><!-- end .wrapper -->
<!-- Optionally add Bootstrap JS (if not already included in header or elsewhere) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/app.js"></script>
<script>
    function setTheme(theme){
        if(theme === 'dark'){
            document.body.classList.add('dark');
        }
        else{
            document.body.classList.remove('dark');
        }
    }
</script>
</body>
</html>