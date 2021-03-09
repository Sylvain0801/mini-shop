window.onload =  () => {
  let btnActiveFav = document.querySelectorAll(".star-favourite")
  for(let btn of btnActiveFav) {
    btn.addEventListener("click", function() {
      let xhr = new XMLHttpRequest
      if (btn.hasAttribute('checked')) {
        xhr.open("get", `/product/favourite/remove/${this.dataset.id}`)
        xhr.addEventListener('readystatechange', function() {
          if(xhr.readyState === 4) {
            if(xhr.status !== 200) {
              alert('Une erreur s\'est produite, le produit n\'a pas été supprimé de vos favoris !')
              } else {
                btn.removeAttribute('checked')
                btn.setAttribute('title', 'Ajouter ce produit à vos favoris')
              }
          }
        })
      } else {
        xhr.open("get", `/product/favourite/add/${this.dataset.id}`)
        xhr.addEventListener('readystatechange', function() {
          if(xhr.readyState === 4) {
            if(xhr.status !== 200) {
              alert('Une erreur s\'est produite, le produit n\'a pas été ajouté à vos favoris !')
              } else {
                btn.setAttribute('checked', '')
                btn.setAttribute('title', 'Supprimer ce produit de vos favoris')
              }
          }
        })
      }
      xhr.send()
    })
  }
}