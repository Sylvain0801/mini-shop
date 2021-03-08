window.onload =  () => {
  let btnAddFav = document.querySelectorAll(".icon-star-empty")
  for(let btn of btnAddFav) {
    btn.addEventListener("click", function() {
      let xhr = new XMLHttpRequest
      xhr.open("get", `/product/favourite/add/${this.dataset.id}`)
      xhr.addEventListener('readystatechange', function() {
        if(xhr.readyState === 4) {
            //Si le status n'est pas 200 (HTTP.OK), on alerte l'utilisateur.
            if(xhr.status !== 200) {
                alert('Une erreur s\'est produite, le produit n\'a pas été ajouté à vos favoris !')
            } else {
              btn.classList.remove('icon-star-empty')
              btn.classList.add('icon-star-full')
              alert('Le produit a bien été ajouté à vos favoris.')
            }
        }
      })
      xhr.send()
    })
  }
  let btnRemoveFav = document.querySelectorAll(".icon-star-full")
  for(let btn of btnRemoveFav) {
    btn.addEventListener("click", function() {
      let xhr = new XMLHttpRequest
      xhr.open("get", `/product/favourite/remove/${this.dataset.id}`)
      xhr.addEventListener('readystatechange', function() {
        if(xhr.readyState === 4) {
          //Si le status n'est pas 200 (HTTP.OK), on alerte l'utilisateur.
          if(xhr.status !== 200) {
            alert('Une erreur s\'est produite, le produit n\'a pas été supprimé de vos favoris !')
          } else {
              btn.classList.remove('icon-star-full')
              btn.classList.add('icon-star-empty')
              alert('Le produit a été supprimé de vos favoris.')
            }
        }
      })
      xhr.send()
    })
  }
}