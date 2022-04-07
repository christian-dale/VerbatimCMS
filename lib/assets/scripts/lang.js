document.querySelectorAll(".btnLang").forEach(el => {
    el.addEventListener("click", event => {
        fetch(`/set-lang?lang=${event.target.dataset.lang}`).then(res => {
            location.reload();
        });
    })
});
