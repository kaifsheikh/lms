<?php include HEADER; ?>

<h1>Accountant Approval</h1>

<?php if (!empty($message)): ?>
    <p style="color: green;">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
    </p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p style="color: red;">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
    </p>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0">

    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Current Status</th>
            <th>Registered At</th>
            <th>Change Status</th>
        </tr>
    </thead>

    <tbody>

        <?php if ($result && $result->num_rows > 0): ?>

            <?php while ($row = $result->fetch_assoc()): ?>

                <?php
                $status = $row['status'];

                $color = 'orange';

                if ($status === 'approved') {
                    $color = 'green';
                } elseif ($status === 'rejected') {
                    $color = 'red';
                }
                ?>

                <tr>

                    <td>
                        <?= (int)$row['id']; ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['full_name'], ENT_QUOTES, 'UTF-8'); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['contact'], ENT_QUOTES, 'UTF-8'); ?>
                    </td>

                    <td>
                        <span style="color: <?= $color; ?>;">
                            <?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8'); ?>
                    </td>

                    <td>

                        <form method="POST" action="" style="display:inline;">

                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8'); ?>"
                            >

                            <input
                                type="hidden"
                                name="user_id"
                                value="<?= (int)$row['id']; ?>"
                            >

                            <select name="status">

                                <option value="pending"
                                    <?= ($status === 'pending') ? 'selected' : ''; ?>>
                                    Pending
                                </option>

                                <option value="approved"
                                    <?= ($status === 'approved') ? 'selected' : ''; ?>>
                                    Approved
                                </option>

                                <option value="rejected"
                                    <?= ($status === 'rejected') ? 'selected' : ''; ?>>
                                    Rejected
                                </option>

                            </select>

                            <button type="submit">
                                Update
                            </button>

                        </form>

                    </td>

                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="7">
                    No accountants found.
                </td>
            </tr>

        <?php endif; ?>

    </tbody>

</table>

<?php include FOOTER; ?>