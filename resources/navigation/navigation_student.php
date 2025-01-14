<?php
    $current_page = basename($_SERVER['PHP_SELF']);
    
    $pages = array(
        '../event/eventboard.php' => 'Event Board',
        '../event/joined_event.php' => 'Joined Event',
        '../feedback/feedback.php' => 'Feedback',
        '../profile/student_profile.php' => 'Profile',
        '../../auth/signout.php' => 'Sign Out'
    );
    
    foreach ($pages as $page_link => $page_title) {
        $class = ($current_page == $page_link) ? 'active' : '';
        echo '<td><a href="' . $page_link . '" class="' . $class . '">' . $page_title . '</a></td>';
    }
