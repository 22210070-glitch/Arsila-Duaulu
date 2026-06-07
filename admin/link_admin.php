<?php
@$page = $_GET['q'];
if (!empty($page)) {
    switch ($page) {

        case 'beranda':
            include './pages/beranda/beranda.php';
            break;

        case 'section1':
            include './pages/section1/section1.php';
            break;

        case 'add_section1':
            include './pages/section1/add_section1/add_section1.php';
            break;

        case 'edit_section1':
            include './pages/section1/edit_section1/edit_section1.php';
            break;

        case 'delete_section1':
            include './pages/section1/delete_section1/delete_section1.php';
            break;

        case 'section2':
            include './pages/section2/section2.php';
            break;

        case 'add_section2':
            include './pages/section2/add_section2/add_section2.php';
            break;

        case 'edit_section2':
            include './pages/section2/edit_section2/edit_section2.php';
            break;

        case 'delete_section2':
            include './pages/section2/delete_section2/delete_section2.php';
            break;

        case 'section3':
            include './pages/section3/section3.php';
            break;

        case 'add_section3':
            include './pages/section3/add_section3/add_section3.php';
            break;

        case 'edit_section3':
            include './pages/section3/edit_section3/edit_section3.php';
            break;

        case 'delete_section3':
            include './pages/section3/delete_section3/delete_section3.php';
            break;

        case 'upload_zip':
            include './pages/upload_zip/upload_zip.php';
            break;

        case 'add_upload_zip':
            include './pages/upload_zip/add_upload_zip/add_upload_zip.php';
            break;

        case 'delete_upload_zip':
            include './pages/upload_zip/delete_upload_zip/delete_upload_zip.php';
            break;

        case 'run_kmeans':
            include './pages/upload_zip/run_kmeans/run_kmeans.php';
            break;
    }
} else {
    include './pages/beranda/beranda.php';
}
