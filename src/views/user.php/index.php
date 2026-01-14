<h1>Liste des utilisateurs</h1>
<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
