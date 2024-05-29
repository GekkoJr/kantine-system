<?php
require_once('api/DB.php');
$db = $conn;

// Slettefunksjon
if(isset($_POST['delete_user_id'])) {
    $delete_user_id = $_POST['delete_user_id'];
    $delete_query = "DELETE FROM avdelinger WHERE id = $delete_user_id";
    $result = $conn->query($delete_query);
    // Oppdater siden etter sletting
    echo "<meta http-equiv='refresh' content='0'>";
}

// Legge til funksjon
if(isset($_POST['add_user'])) {
    $new_user_nanv = $_POST['new_user_nanv'];

    // Sjekk om avdeling allerede eksisterer
    $check_query = "SELECT COUNT(*) as count FROM avdelinger WHERE nanv = '$new_user_nanv'";
    $check_result = $conn->query($check_query);
    $row = $check_result->fetch_assoc();
    $category_count = $row['count'];

    if($category_count > 0) {
        // Avdeling eksisterer allerede, vis alerten
        $alert_style = 'block';
        $alert_type = 'yellow';
        $alert_message = "Den avdelingen du prøvde å legge til eksisterer allerede.";
    } else {
        // Avdeling eksisterer ikke, legg til i databasen
        $add_query = "INSERT INTO avdelinger (nanv) VALUES ('$new_user_nanv')";
        $result = $conn->query($add_query);
        // Oppdater siden etter tillegg
        $alert_style = 'block';
        $alert_type = 'green';
        $alert_message = "Avdelingen ble lagt til.";
    }
} else {
    // Skjul alerten hvis ikke lagt til avdeling
    $alert_style = 'hidden';
}

$query = "SELECT * FROM avdelinger";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrer avdelinger</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <nav class="bg-gray-600 border-b-4 border-gray-300">
        <div class="py-5 px-10 lg:max-w-7xl lg:mx-auto flex justify-between items-center">
            <img src="images/kuben_logo.png" class="h-5" alt="Kuben Logo"/>
            <button type="button" class="relative inline-flex items-center p-2 text-sm font-medium text-center text-white bg-gray-700 rounded-md hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/>
                </svg>
                <p class="mx-2">Logg ut</p>
            </button>
        </div>
    </nav>
    <nav class="bg-white border-gray-200 px-10 lg:max-w-7xl lg:mx-auto py-2.5 dark:bg-gray-800">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <div class="justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="administrer_varer.php" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-300 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 hover:text-blue-700 lg:p-0">Varer</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-300 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 hover:text-blue-700 lg:p-0">Bestillinger</a>
                    </li>
                    <li>
                        <a href="administrer_kategori.php" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-300 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 hover:text-blue-700 lg:p-0">Kategori</a>
                    </li>
                    <li>
                        <a href="administrer_ansatte.php" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-300 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 hover:text-blue-700 lg:p-0">Ansatte</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-blue-700 border-b border-gray-300 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 hover:text-blue-700 lg:p-0" aria-current="page">Avdeling</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="min-h-screen pt-10 px-10 lg:max-w-7xl lg:mx-auto">

        <!-- Allerede eksisterer -->
        <div id="alert-border-4" class="flex items-center p-4 mb-4 text-<?= $alert_type ?>-800 border-t-4 border-<?= $alert_type ?>-300 bg-<?= $alert_type ?>-50 dark:text-<?= $alert_type ?>-300 dark:bg-gray-800 dark:border-<?= $alert_type ?>-800 <?= $alert_style ?>" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium">
                <?= $alert_message ?>
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-<?= $alert_type ?>-50 text-<?= $alert_type ?>-500 rounded-lg focus:ring-2 focus:ring-<?= $alert_type ?>-400 p-1.5 hover:bg-<?= $alert_type ?>-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-<?= $alert_type ?>-300 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-4" aria-label="Close">
            <span class="sr-only">Dismiss</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            </button>
        </div>

        <p class="text-xl mb-5 border-b-2 pb-1 border-gray-300">Administrer avdeling</p>
        <section class="bg-gray-50 dark:bg-gray-900 antialiased">
            <div class="mx-auto max-w-screen-2xl">
                <div class="bg-white border border-gray-200 shadow rounded-md w-full md:flex-1 relative">
                    <div class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 dark:border-gray-700">
                        <div class="w-full md:w-1/2">           
                            <form class="flex items-center flex-col md:flex-row" method="post">
                                <div class="relative w-full mr-0 mb-3 md:mb-0 md:mr-3">
                                    <input type="text" name="new_user_nanv" id="new_user_nanv" placeholder="Skriv inn navn på avdeling..." required="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600">
                                </div>
                                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                    <button type="submit" name="add_user" id="createProductButton" data-drawer-target="drawer-form" data-drawer-show="drawer-form" aria-controls="drawer-form" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        <svg class="h-3.5 w-3.5 mr-1.5 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                        </svg>
                                        Legg til avdeling
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
 
                    <div class="overflow-x-auto md:block">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase">
                                <tr>
                                    <th scope="col" class="p-4">Avdeling</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr class="border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">';
                                            echo '<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">' . htmlspecialchars($row["nanv"]) . '</th>';
                                            echo '<td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap flex items-center justify-end">';
                                            echo '<form method="post" class="inline-block">';
                                            echo '<input type="hidden" name="delete_user_id" value="' . $row["id"] . '">';
                                            echo '<button type="submit" class="flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">';
                                            echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">';
                                            echo '<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />';
                                            echo '</svg>';
                                            echo 'Slett';
                                            echo '</button>';
                                            echo '</form>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="2" class="text-center pb-5">Ingen avdelinger tilgjengelig</td></tr>';
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    </div>

    <footer class="flex flex-col mt-20 p-6 items-center bg-gray-800 text-center text-white">
        <p class="flex items-center justify-center">Kantinebestilling system | Kuben videregående skole</p>
    </footer>

</body>
</html>
