    </div><!-- container end -->
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            let flashMsg = document.getElementById('msg-flash');
            if (flashMsg) {
                let bsAlert = new bootstrap.Alert(flashMsg);
                bsAlert.close();
            }
        }, 5000);
    </script>
</body>
</html>
