<div class="container">
<style>
#editor h1, #editor h2, #editor h3, #editor h4, #editor h5, #editor h6, #editor a, #editor * {font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif !important;}
</style>
	<div id="editor" contenteditable style="width:100%;border:1px solid rgba(0,0,0,0.1);outline:0;height:100%;padding:20px;font-family: font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif !important;"></div>
</div>
<script>
	(function() {
    var editorKey = 'html5-notepad';
    var editor = document.getElementById('editor');
    var cache = localStorage.getItem(editorKey);

    if (cache) {
      editor.innerHTML = cache;
    }

    function autosave() {
      var newValue = editor.innerHTML;
      if (cache != newValue) {
        cache = newValue;
        localStorage.setItem(editorKey, cache);
      }
    }

    editor.addEventListener('input', autosave);
  })();

</script>