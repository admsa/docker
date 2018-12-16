<a href="<?php echo BASE_URL . '?page=logout'; ?>">Logout</a>
<div>
  <table>
    <tr>
      <td>ID</td>
      <td>Email</td>
      <td>Firstname</td>
      <td>Lastname</td>
      <td>Action</td>
    </tr>

    <?php foreach($users as $user) { ?>
      <tr>
        <td><?php echo $user->id; ?></td>
        <td><?php echo $user->email; ?></td>
        <td><?php echo $user->firstname; ?></td>
        <td><?php echo $user->lastname; ?></td>
        <td><a href="<?php echo BASE_URL . '?page=dashboard&action=delete&id=' . $user->id ?>">delete</a></td>
      </tr>
    <?php } ?>
  </table>
  <?php $links = ceil($count / $per_page); ?>

  <?php for ($i = 0; $i < $links; $i++) { ?>
    <a href="<?php echo BASE_URL . "?page=dashboard&limit=$per_page&offset=" . ($i * $per_page) ; ?>"><?php echo $i + 1; ?></a>
  <?php } ?>
</div>