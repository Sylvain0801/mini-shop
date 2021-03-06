window.onload =  () => {
  let btnActive = document.querySelectorAll("[type=checkbox].btn-active")
  for(let btn of btnActive) {
    btn.addEventListener("click", function() {
      let xhr = new XMLHttpRequest
      xhr.open("get", `/admin/product/active/${this.dataset.id}`)
      xhr.addEventListener('readystatechange', function() {
        if(xhr.readyState === 4) {
            //Si le status n'est pas 200 (HTTP.OK), on alerte l'utilisateur.
            if(xhr.status !== 200) {
                alert('Une erreur s\'est produite, le produit n\'a pas été mis à jour !')
            } else {
                alert('Le produit a été mis à jour avec succès.')
            }
        }
      })
      xhr.send()
    })
  }
  let btnFirstpage = document.querySelectorAll("[type=checkbox].btn-firstpage")
  for(let btn of btnFirstpage) {
    btn.addEventListener("click", function() {
      let xhr = new XMLHttpRequest
      xhr.open("get", `/admin/product/firstpage/${this.dataset.id}`)
      xhr.addEventListener('readystatechange', function() {
        if(xhr.readyState === 4) {
            //Si le status n'est pas 200 (HTTP.OK), on alerte l'utilisateur.
            if(xhr.status !== 200) {
                alert('Une erreur s\'est produite, le produit n\'a pas été mis à jour !')
            } else {
                alert('Le produit a été mis à jour avec succès.')
            }
        }
      })
      xhr.send()
    })
  }
}