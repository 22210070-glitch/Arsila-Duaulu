<?php
@$page = $_GET['q'];
if (!empty($page)) {
    switch ($page) {

        case 'beranda':
            include './pages/beranda/beranda.php';
            break;
    }
} else {
    include './pages/beranda/beranda.php';
}