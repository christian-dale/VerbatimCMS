<style>
hr {
  background-color: #eee;
  border: 0;
  border-radius: 50px;
  height: 1px;
  margin-bottom: 25px;
  margin-top: 25px;
}
</style>

<script>
    window.onload = function() {
        const date = document.createTextNode(new Date().getFullYear());
        document.querySelector(".footerCopyright").appendChild(date);
    };
</script>

<div class="footer">
    <hr>
    <p class="footerCopyright">&copy; Portfolio </p>
</div>
