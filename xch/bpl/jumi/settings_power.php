<?php
defined('_JEXEC') or die;

try {
	// Get the Joomla application instance
	$app = JFactory::getApplication();

	// Set the MIME type and document type
	$document = JFactory::getDocument();
	$document->setMimeEncoding('text/html');
	$document->setType('html');

	// Get the database instance
	$db = JFactory::getDbo();

	// Handle form submission for updating user details
	$input = $app->input;
	if ($input->getMethod() == 'POST' && $input->get('action') == 'update_user') {
		$userId = $input->post->getInt('user_id');
		$fullname = $input->post->getString('fullname');
		$email = $input->post->getString('email');
		$contact = $input->post->getString('contact', '{}');
		$address = $input->post->getString('address');

		// Update user details in the database
		$query = $db->getQuery(true)
			->update($db->quoteName('network_users'))
			->set([
				$db->quoteName('fullname') . ' = ' . $db->quote($fullname),
				$db->quoteName('email') . ' = ' . $db->quote($email),
				$db->quoteName('contact') . ' = ' . $db->quote($contact),
				$db->quoteName('address') . ' = ' . $db->quote($address)
			])
			->where($db->quoteName('id') . ' = ' . $userId);
		$db->setQuery($query);
		$db->execute();

		// Redirect to avoid form resubmission
		$app->enqueueMessage('User details updated successfully!', 'success');
		$app->redirect(JUri::current());
	}

	// Fetch all users from the database
	$query = $db->getQuery(true)
		->select('*')
		->from($db->quoteName('network_users'));
	$db->setQuery($query);
	$users = $db->loadObjectList();

	// Heredoc for HTML content
	$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Network Users</title>

  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <div class="container mt-5">
    <h1 class="mb-4">Network Users</h1>

    <!-- Display success/error messages -->
HTML;

	// Display Joomla messages as dismissible alerts
	$messages = $app->getMessageQueue(true);
	if (!empty($messages)) {
		foreach ($messages as $message) {
			$html .= <<<HTML
            <div class="alert alert-{$message['type']} alert-dismissible fade show" role="alert">
              {$message['message']}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
HTML;
		}
	}

	$html .= <<<HTML
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
HTML;

	// Loop through users and display their details
	foreach ($users as $user) {
		$html .= <<<HTML
          <tr>
            <td>{$user->id}</td>
            <td>{$user->username}</td>
            <td>{$user->fullname}</td>
            <td>{$user->email}</td>
            <td>{$user->contact}</td>
            <td>{$user->address}</td>
            <td>
              <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{$user->id}">
                Edit
              </button>
            </td>
          </tr>
HTML;
	}

	$html .= <<<HTML
        </tbody>
      </table>
    </div>
  </div>
HTML;

	// Add modals for editing user details
	foreach ($users as $user) {
		$html .= <<<HTML
<!-- Edit User Modal for User ID {$user->id} -->
<div class="modal fade" id="editUserModal{$user->id}" tabindex="-1" aria-labelledby="editUserModalLabel{$user->id}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel{$user->id}">Edit User: {$user->username}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <input type="hidden" name="action" value="update_user">
          <input type="hidden" name="user_id" value="{$user->id}">
          <div class="mb-3">
            <label for="fullname{$user->id}" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname{$user->id}" name="fullname" value="{$user->fullname}" required>
          </div>
          <div class="mb-3">
            <label for="email{$user->id}" class="form-label">Email</label>
            <input type="email" class="form-control" id="email{$user->id}" name="email" value="{$user->email}" required>
          </div>
          <div class="mb-3">
            <label for="contact{$user->id}" class="form-label">Contact</label>
            <input type="text" class="form-control" id="contact{$user->id}" name="contact" value='{$user->contact}'>
          </div>
          <div class="mb-3">
            <label for="address{$user->id}" class="form-label">Address</label>
            <textarea class="form-control" id="address{$user->id}" name="address">{$user->address}</textarea>
          </div>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
HTML;
	}

	$html .= <<<HTML
  <!-- Bootstrap 5 JS and Popper.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

  <!-- Auto-dismiss alerts after 5 seconds -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Select all alert elements
      const alerts = document.querySelectorAll('.alert');

      // Loop through each alert and set a timeout to dismiss it
      alerts.forEach(function (alert) {
        setTimeout(function () {
          // Use Bootstrap's alert method to close the alert
          bootstrap.Alert.getOrCreateInstance(alert).close();
        }, 5000); // 5000 milliseconds = 5 seconds
      });
    });
  </script>
</body>
</html>
HTML;

	// Output the HTML directly
	echo $html;

	// Close the Joomla application to prevent further processing
	$app->close();

} catch (Exception $e) {
	echo "Error: " . $e->getMessage();
}
?>