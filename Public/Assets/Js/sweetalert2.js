// SweetAlert2 personalizado para confirmaciones
function confirmAction(title, text, confirmButtonText = "Sí, continuar") {
  return new Promise((resolve) => {
    if (confirm(`${title}\n${text}`)) {
      resolve(true)
    } else {
      resolve(false)
    }
  })
}

function showSuccess(title, text) {
  alert(`${title}\n${text}`)
}

function showError(title, text) {
  alert(`Error: ${title}\n${text}`)
}
