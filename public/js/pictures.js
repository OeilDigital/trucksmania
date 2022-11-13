window.onload = () => {
    let links = document.querySelectorAll("[data-delete]");

    for (link of links) {
        link.addEventListener(("click"), function (e) {
            e.preventDefault();
            if (confirm("Voulez-vous supprimer cette image ?")) {
                // Requete Ajax vers le href du lien avec méthode delete
                await fetch(this.getAttribute("href"), {
                    method: 'DELETE',
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ "_token": this.dataset.token })
                }).then(
                    // Je récupére la réponse en JSON
                    response => response.json()

                ).then(data => {
                    if (data.success) {
                        this.parentElement.remove()
                    } else {
                        alert(data.error)
                    }
                }).catch(e => alert(e))
            }
        })
    }
}