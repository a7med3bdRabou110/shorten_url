//! Select All Required Elements
const form = document.querySelector('.wrapper form'),
  fullURL = form.querySelector('input'),
  shortenURL = form.querySelector('button'),
  blurEffect = document.querySelector('.blur-effect'),
  popupBox = document.querySelector('.popup-box'),
  shorten = popupBox.querySelector('input'),
  form2 = popupBox.querySelector('form'),
  saveBtn = popupBox.querySelector('button'),
  copyBtn = popupBox.querySelector('.copy-icon'),
  infoBox = popupBox.querySelector('.info-box')

//! Prevent form from Submitting
form.onsubmit = (e) => {
  e.preventDefault()
}

shortenURL.onclick = () => {
  // Let's Start Ajax
  let xhr = new XMLHttpRequest()
  xhr.open('POST', 'php/php-controller.php', true)
  xhr.onload = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let data = xhr.response
      if (data.length <= 5) {
        blurEffect.style.display = 'block'
        popupBox.classList.add('show')

        let domain = 'localhost/shorten-url/'
        shorten.value = domain + data

        copyBtn.onclick = () => {
          shorten.select()
          document.execCommand('copy')
        }

        form2.onsubmit = (e) => {
          e.preventDefault()
        }

        saveBtn.onclick = () => {
          let xhr2 = new XMLHttpRequest()
          xhr2.open('POST', 'php/save-url.php', true)
          xhr2.onload = () => {
            if (xhr2.readyState == 4 && xhr2.status == 200) {
              let data = xhr2.response
              if (data === 'Success') {
                location.reload()
              } else {
                infoBox.innerText = data
                infoBox.classList.add('error')
              }
            }
          }
          let short_url = shorten.value
          let hidden_url = data
          xhr2.setRequestHeader(
            'Content-type',
            'application/x-www-form-urlencoded'
          )
          xhr2.send('shorten_url=' + short_url + '&hidden_url=' + hidden_url)
        }
      } else {
        alert(data)
      }
    }
  }

  // Let's Send form data to php file

  let formData = new FormData(form)

  xhr.send(formData)
}
