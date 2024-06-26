<?php
// Sjekk for POST-forespørsel
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST['varer']);
}

// Inkluder databaseforbindelse
require_once('api/DB.php');
$db = $conn;

// Hent kategorier fra databasen
$query = "SELECT * FROM kategorier";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form method="post" action="/api/order/new.php">
    <nav class="bg-gray-600 border-b-4 border-gray-300">
        <div class="py-5 px-10 lg:max-w-7xl lg:mx-auto flex justify-between items-center">
            <img src="images/kuben_logo.png" class="h-6" alt="Kuben Logo"/>
            <button type="submit" class="relative inline-flex items-center p-2 px-4 text-sm font-medium text-center text-white bg-gray-700 rounded-md hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                Bekreft bestilling
                <div id="totalQuantity" class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-blue-600 border-2 border-white rounded-full -top-2 -end-2">0</div>
            </button>
        </div>
    </nav>

    <div class="pt-10 sm:px-10 text-center">
        <?php
        // Sjekk om det er rader i resultatsettet
        if ($result && $result->num_rows > 0) {
            // Iterer gjennom hver rad i resultatsettet
            while ($row = $result->fetch_assoc()) {
                $kategori_navn = $row['name'];
                // Generer en knapp for hver kategori
                echo '<button type="button" class="py-1 px-3 m-1 bg-white rounded-md shadow border border-gray-200 hover:bg-gray-100">' . $kategori_navn . '</button>';
            }
        } else {
            // Hvis ingen kategorier ble funnet i databasen
            echo "Ingen kategorier tilgjengelig";
        }
        ?>
    </div>
    <div class="min-h-screen pt-5 px-10 lg:max-w-7xl lg:mx-auto">
        <p class="text-xl mb-5 border-b-2 pb-1 border-gray-300">Varer</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <?php
            // Hent varer fra databasen
            $query = "SELECT * FROM varer";
            $varer_array = $db->query($query);

            if ($varer_array) {
                foreach ($varer_array as $key => $row) {
                    $id = $row['id'];
                    $navn = $row['navn'];
                    $beskrivelse = $row['beskrivelse'];
                    $pris = $row['pris'];
                    $allergi = $row['allergi'];
                    $kategori_ID = $row['kategori'];
                    ?>
                    <div class="flex flex-col bg-white border border-gray-200 shadow rounded-md w-full md:flex-1 relative">
                        <div class="flex flex-col justify-between p-4">
                            <p class="text-lg font-bold tracking-tight text-gray-900"><?php echo $navn; ?></p>
                            <p class="mb-3 text-sm font-semibold text-gray-500"><?php echo $pris; ?>,00 kr</p>
                            <p class="mb-2 text-sm text-gray-500"><?php echo $beskrivelse; ?></p>
                            <p class="text-xs text-gray-500 bg-gray-100 py-1 px-2 rounded-md"><?php echo $allergi; ?></p>
                        </div>
                        <div class="absolute top-0 right-0 flex">
                            <button type="button" class="minus-button w-10 h-10 p-2 rounded-bl-2xl text-gray-600 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 hidden">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>
                                </svg>
                            </button>
                            <input type="text" name="varer[<?php echo $id; ?>]" class="w-10 h-10 p-2 text-gray-600 bg-gray-50 border-none text-center quantity-input hidden" value="0" readonly>
                            <button type="button" class="pluss-button w-10 h-10 p-2 text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-bl-2xl">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7v14"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
    </div>
    </div>
</form>
</body>

<footer class="flex flex-col mt-20 p-6 items-center bg-gray-800 text-center text-white">
    <p class="flex items-center justify-center">Kantinebestilling system | Kuben videregående skole</p>
</footer>
<script>
    function updateTotalQuantity() {
        let total = 0;
        document.querySelectorAll('.quantity-input').forEach(input => {
            const value = parseInt(input.value);
            total += value;

            const minusButton = input.previousElementSibling;
            const plusButton = input.nextElementSibling;
            if (value > 0) {
                input.classList.remove('hidden');
                minusButton.classList.remove('hidden');
                plusButton.classList.remove('rounded-bl-2xl');
            } else {
                input.classList.add('hidden');
                minusButton.classList.add('hidden');
                plusButton.classList.add('rounded-bl-2xl');
            }
        });
        const totalQuantityElement = document.getElementById('totalQuantity');
        totalQuantityElement.textContent = total;
        totalQuantityElement.style.display = total > 0 ? 'flex' : 'none';
    }

    document.querySelectorAll('.pluss-button').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            input.value = parseInt(input.value) + 1;
            updateTotalQuantity();
        });
    });

    document.querySelectorAll('.minus-button').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.nextElementSibling;
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                updateTotalQuantity();
            }
        });
    });

    // Initialize the total quantity on page load
    updateTotalQuantity();
</script>