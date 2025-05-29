// Funciones principales de la aplicación
document.addEventListener("DOMContentLoaded", () => {
  // Inicializar tooltips si Bootstrap está disponible
  if (typeof bootstrap !== "undefined") {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl))
  }

  // Manejar formulario de citas
  const citaForm = document.getElementById("citaForm")
  if (citaForm) {
    initCitaForm()
  }

  // Auto-hide alerts
  const alerts = document.querySelectorAll(".alert")
  alerts.forEach((alert) => {
    setTimeout(() => {
      alert.style.opacity = "0"
      setTimeout(() => {
        alert.remove()
      }, 300)
    }, 5000)
  })
})

function initCitaForm() {
  const especialidadSelect = document.getElementById("especialidad_id")
  const medicoSelect = document.getElementById("medico_id")

  if (especialidadSelect && medicoSelect) {
    especialidadSelect.addEventListener("change", function () {
      const especialidadId = this.value

      // Limpiar opciones de médicos
      medicoSelect.innerHTML = '<option value="">Seleccione un médico</option>'

      if (especialidadId) {
        fetch(`/api/medicos-especialidad?especialidad_id=${especialidadId}`)
          .then((response) => response.json())
          .then((medicos) => {
            medicos.forEach((medico) => {
              const option = document.createElement("option")
              option.value = medico.id
              option.textContent = `Dr. ${medico.nombre} ${medico.apellido}`
              medicoSelect.appendChild(option)
            })
          })
          .catch((error) => {
            console.error("Error al cargar médicos:", error)
          })
      }
    })
  }

  // Validar fecha mínima (no permitir fechas pasadas)
  const fechaInput = document.getElementById("fecha")
  if (fechaInput) {
    const today = new Date().toISOString().split("T")[0]
    fechaInput.setAttribute("min", today)
  }
}

// Función para confirmar eliminación
function confirmDelete(message = "¿Está seguro de que desea eliminar este elemento?") {
  return confirm(message)
}

// Función para mostrar notificaciones
function showNotification(message, type = "info") {
  const notification = document.createElement("div")
  notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`
  notification.style.top = "20px"
  notification.style.right = "20px"
  notification.style.zIndex = "9999"
  notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `

  document.body.appendChild(notification)

  setTimeout(() => {
    notification.remove()
  }, 5000)
}

// Función para validar formularios
function validateForm(formId) {
  const form = document.getElementById(formId)
  if (!form) return false

  const requiredFields = form.querySelectorAll("[required]")
  let isValid = true

  requiredFields.forEach((field) => {
    if (!field.value.trim()) {
      field.classList.add("is-invalid")
      isValid = false
    } else {
      field.classList.remove("is-invalid")
    }
  })

  return isValid
}
