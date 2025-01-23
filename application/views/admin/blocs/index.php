<h2>Liste des blocs HTML</h2>
<a href="<?php echo site_url('BlocController/create'); ?>">Ajouter un bloc</a>
<table border="1">
  <thead>
    <tr>
      <th>ID</th>
      <th>Titre</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($blocs as $bloc): ?>
      <tr>
        <td><?= $bloc['id']; ?></td>
        <td><?= $bloc['titre']; ?></td>
        <td>
          <a href="<?php echo site_url('BlocController/edit/'.$bloc['id']); ?>">Modifier</a>
          <a href="<?php echo site_url('BlocController/delete/'.$bloc['id']); ?>" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
