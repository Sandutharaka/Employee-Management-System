
<div class="popup">
    <div class="popup-content">
        <span class="close-btn">&times;</span>
        <p><?php echo $errorMessage; ?></p>
    </div>
</div>

<script>
    document.querySelector(".close-btn").addEventListener("click", function() {
        document.querySelector(".popup").style.display = "none";
    });
</script>
