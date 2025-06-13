    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    <script>
        alertify.set("notifier", "position", "top-right");
        <?php if (isset($_SESSION["success"])): ?>
            alertify.success("<?= $_SESSION["success"] ?>");
            <?php unset($_SESSION["success"]); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION["error"])): ?>
            alertify.error("<?= $_SESSION["error"] ?>");
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>
    </script>
</body>
</html>
