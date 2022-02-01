function tinyMCEonLoad() {
  CKEDITOR.replace( 'post_message' );
}

window.addEventListener("load", tinyMCEonLoad, true);