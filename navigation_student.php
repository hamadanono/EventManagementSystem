<?php
// Get the current page filename without extension
$current_page = basename($_SERVER['PHP_SELF']);

// Define an associative array with page names and corresponding links
$pages = array(
    'eventboard.php' => 'Event Board',
    'dummyjoin.php' => 'Joined Event',
    // Add more pages as needed
    'feedback.php' => 'Feedback',
    'signout.php' => 'Sign Out'
);

// Output the navigation links
foreach ($pages as $page_link => $page_title) {
    $class = ($current_page == $page_link) ? 'active' : '';
    echo '<td><a href="' . $page_link . '" class="' . $class . '">' . $page_title . '</a></td>';
}
?>
