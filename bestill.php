<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST['varer']);
}
require_once('api/DB.php');
$db = $conn;

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
            <button type="submit" class="relative inline-flex items-center p-2 text-sm font-medium text-center text-white bg-gray-700 rounded-md hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z"/>
                  </svg>
                <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-blue-600 border-2 border-white rounded-full -top-2 -end-2">4</div>
            </button>
        </div>
    </nav>
    
    <div class="pt-10 sm:px-10 text-center">
        <button class="py-1 px-3 m-1 bg-white rounded-md shadow border border-gray-200 hover:bg-gray-100">Kategori 1</button>
        <button class="py-1 px-3 m-1 bg-white rounded-md shadow border border-gray-200 hover:bg-gray-100">Kategori 2</button>
        <button class="py-1 px-3 m-1 bg-white rounded-md shadow border border-gray-200 hover:bg-gray-100">Kategori 3</button>
        <button class="py-1 px-3 m-1 bg-white rounded-md shadow border border-gray-200 hover:bg-gray-100">Kategori 4</button>
        <button class="py-1 px-3 m-1 bg-white rounded-md shadow border border-gray-200 hover:bg-gray-100">Kategori 5</button>
    </div>
    <div class="min-h-screen pt-5 px-10 lg:max-w-7xl lg:mx-auto">
        <p class="text-xl mb-5 border-b-2 pb-1 border-gray-300">Varer</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <?php
                $query = "SELECT * FROM varer";
                $varer_array = $db->query($query);

                if ($varer_array){
                foreach ($varer_array as $key => $row){
                    $id = $row['id'];
                    $navn = $row['navn'];
                    $beskrivelse = $row['beskrivelse'];
                    $pris = $row['pris'];
                    $allergi = $row['allergi'];
                    $kategori_ID = $row['kategori'];
            ?>
            <div class="flex flex-col bg-white border border-gray-200 shadow rounded-md w-full md:flex-1 relative">
                <div class="flex flex-col justify-between p-4">
                    <p class="text-lg font-bold tracking-tight text-gray-900"><?php echo $navn?></p>
                    <p class="mb-3 text-sm font-semibold text-gray-500"><?php echo $pris?>,00 kr</p>
                    <p class="mb-2 text-sm text-gray-500"><?php echo $beskrivelse?></p>
                    <p class="text-xs text-gray-500 bg-gray-100 py-1 px-2 rounded-md"><?php echo $allergi?></p>
                </div>
                <div class="absolute top-0 right-0" id="minus-button">
                    <svg class="w-10 h-10 p-2 rounded-tr-md text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                    </svg>
                </div>   
                <div class="absolute top-0 right-10" id="input-field">
                    <input id="input" type="text" name="varer[<?php echo $id?>]" min="0" class="w-10 h-10 p-2 text-gray-600 bg-gray-50 border-none text-center" value="1">
                </div>           
                <div class="absolute top-0 right-20" id="pluss-button">
                    <svg class="w-10 h-10 p-2 rounded-bl-2xl text-gray-600 hover:text-gray-700 bg-gray-100 hover:bg-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7"/>
                    </svg>
                </div>
            </div>
                <?php }
                }     
            ?>
        </form>
        </div>

    </div>
</body>

<footer class="flex flex-col mt-20 p-6 items-center bg-gray-800 text-center text-white">
    <p class="flex items-center justify-center">Kantinebestilling system | Kuben videregående skole</p>
</footer>
<script>
    var minus_button = document.getElementById('minus_button');
    var input_field = document.getElementById('input-field');
                let input = document.getElementById('input');
    var pluss_button = document.getElementById('pluss-button');

    input_field.addEventListener('input', () => {
        if (input.value >= 1){
            minus_button.classList.remove('display-none')
            input_field.classList.remove('display-none');
        } else {
            input_field.classList.add('display-none');
            minus_button.classList.add('display-none');
        }
    })

    minus_button.addEventListener('click', () => {
        input.value = input.value - 1
    })

    pluss_button.addEventListener('click', () => {
        input.value = input.value + 1
    })
</script>
</html>
