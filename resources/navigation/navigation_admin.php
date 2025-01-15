<?php
    $current_page = basename($_SERVER['PHP_SELF']);
    
    $pages = array(
        '../proposal/proposal_admin.php' => 'Event Proposal',
        '../pmfki_acc/pmfki.php' => 'Manage PMFKI',
        '../report/report_menu_admin.php' => 'Event Report',
        '../../auth/signout.php' => 'Sign Out'
    );
    
    foreach ($pages as $page_link => $page_title) {
        $class = ($current_page == $page_link) ? 'active' : '';
        echo '<td><a href="' . $page_link . '" class="' . $class . '">' . $page_title . '</a></td>';
    }
