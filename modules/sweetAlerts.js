// sweetAlerts.js

const defaultOptions = {
  title: null,
  text: null,
  icon: null,
  confirmButtonText: 'OK',
  cancelButtonText: 'Cancelar',
  showCancelButton: false,
  timer: null,
  allowOutsideClick: false,
  allowEscapeKey: true,
};

const showAlert = (options = {}, onConfirm = null, onCancel = null) => {
  const { html, text } = options;
  const baseOptions = {
    ...defaultOptions,
    ...options,
    text: html ? undefined : text, 
  };

  Swal.fire(baseOptions).then((result) => {
    if (result.isConfirmed && onConfirm) onConfirm();
    else if (result.dismiss && onCancel) onCancel(result.dismiss);
  });
};


// Éxito, acepta texto, título y opciones (p. ej. redirectUrl)
const success = (text, title = null, options = {}) => {
  const { redirectUrl, reloadOnSuccess = false, ...rest } = options;
  showAlert(
    { title, text, icon: 'success', ...rest },
    () => {
       if (redirectUrl) {
        window.location.href = redirectUrl;
      } else if (reloadOnSuccess) {
        window.location.reload();
      }
      
    }
  );
};

// Error
const error = (text, title = null, options = {}) => {
  showAlert({ title, text, icon: 'error', ...options });
};

// Warning
const warning = (text, title = null, options = {}) => {
  showAlert({ title, text, icon: 'warning', ...options });
};

// Confirmación con callbacks para sí y no, más opciones
const confirm = (text, onConfirm, onCancel = () => {}, title = null, options = {}) => {
  Swal.fire({
    title,
    text,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí',
    cancelButtonText: 'No',
    ...options,
  }).then((result) => {
    if (result.isConfirmed) onConfirm();
    else if (result.dismiss === Swal.DismissReason.cancel) onCancel();
  });
};

// Input prompt para pedir datos, retorna una promesa con el valor o null
const inputPrompt = (title, inputType = 'text', options = {}) => {
  return Swal.fire({
    title,
    input: inputType,
    showCancelButton: true,
    confirmButtonText: 'Enviar',
    cancelButtonText: 'Cancelar',
    ...options,
  }).then((result) => {
    if (result.isConfirmed) return result.value;
    else return null;
  });
};

export default {
  showAlert,
  success,
  error,
  warning,
  confirm,
  inputPrompt,
};
