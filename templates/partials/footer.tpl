<script>
    window.onload = function() {
        const date = document.createTextNode(new Date().getFullYear());
        document.querySelector(".footerCopyright").appendChild(date);
    };
</script>

<div class="footer">
    <p class="footerCopyright">&copy; Portfolio </p>
</div>
