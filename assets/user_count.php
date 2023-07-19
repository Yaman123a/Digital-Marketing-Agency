<?php
session_start(); // Start the session to track users

// Function to get the current user count
function getUserCount() {
  return count($_SESSION['active_users']);
}

// Function to update the user count
function updateUserCount() {
  $_SESSION['active_users'][session_id()] = time();
}

// Function to remove inactive users
function clearInactiveUsers() {
  foreach ($_SESSION['active_users'] as $session_id => $last_active_time) {
    if (time() - $last_active_time > 30) {
      unset($_SESSION['active_users'][$session_id]);
    }
  }
}

// Initialize the active users array if it doesn't exist
if (!isset($_SESSION['active_users'])) {
  $_SESSION['active_users'] = [];
}

// Update the user count and clear inactive users
updateUserCount();
clearInactiveUsers();

// Return the current user count as JSON
echo json_encode(['count' => getUserCount()]);
?>
