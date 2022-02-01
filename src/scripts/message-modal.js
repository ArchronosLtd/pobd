function messageModalOnLoad() {
  var messageModal = new bootstrap.Modal(document.getElementById('message-modal'));
  
  messageModal.show();
}

window.addEventListener("load", messageModalOnLoad, true);