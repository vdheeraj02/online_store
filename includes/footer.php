</main>
<footer class="bg-dark text-light py-3 mt-auto">
  <div class="container text-center small">
    &copy; <?php echo date('Y'); ?> GigaByte Electronics. All rights reserved.
  </div>
</footer>

<script src="/online_store/js/bootstrap.bundle.min.js"></script>
<script src="/online_store/js/validation.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".auto-update-input").forEach(input => {
    input.addEventListener("change", function () {
      this.closest(".auto-update-form").submit();
    });
  });
});
</script>
<script src="/online_store/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
});
</script>

</body>
</html>
