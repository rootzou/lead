<h2>Modifier le bloc HTML</h2>
<form method="post">
  <label for="titre">Titre</label>
  <input type="text" name="titre" value="<?= $bloc['titre']; ?>" required>

  <label for="contenu">Contenu HTML</label>
  <textarea name="contenu" id="editor" rows="5"><?= $bloc['contenu']; ?></textarea>

  <button type="submit">Mettre à jour</button>
</form>

<!-- Ajout de l'éditeur CKEditor -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace('editor');
</script>
