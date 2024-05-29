<?php
require_once('api/DB.php');
$db = $conn;

$query = "SELECT id, name FROM kategorier";
$categories = $db->query($query);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

<div class="min-h-screen pt-10 px-10 lg:max-w-7xl lg:mx-auto">
<p class="text-xl mb-5 border-b-2 pb-1 border-gray-300">Din bestilling er mottatt! #284824</p>
<section class="bg-gray-50 dark:bg-gray-900 antialiased">
    <div class="mx-auto max-w-screen-2xl">
        <div class="bg-white border border-gray-200 shadow rounded-md w-full md:flex-1 relative">
            <div class="overflow-x-auto hidden md:block">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="p-4">Vare</th>
                            <th scope="col" class="p-4">Beskrivelse</th>
                            <th scope="col" class="p-4">Pris (NOK)</th>
                            <th scope="col" class="p-4">Antall</th>
                            <th scope="col" class="p-4">Allergi</th>
                            <th scope="col" class="p-4">Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="flex items-center mr-3">
                                    Baguette
                                </div>
                            </th>
                            <td class="px-4 py-3">Melk, egg og nøtter</td>
                            <td class="px-4 py-3">29,00 kr</td>
                            <td class="px-4 py-3">3</td>
                            <td class="px-4 py-3">blabla</td>
                            <td class="px-4 py-3">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Kategori</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
             <!-- Mobilbredde -->
             <div class="grid grid-cols-1 mx-5 gap-4 md:hidden">
                <div class="my-5">
                    <div class="bg-white space-y-3 rounded-lg border border-gray-200 relative">
                        <div class="flex items-center text-sm p-4 rounded-t-lg bg-gray-100">
                            <div class="text-gray-700">Baguette</div>
                            <div class="absolute top-4 right-4">
                        </div>
                    </div>
                    <div class="px-5 pb-4 text-sm text-gray-700 font-semibold space-y-2">
                        <p>Beskrivelse: <span class="text-gray-500 font-normal">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam facilisis sed quam ac fringilla.</span></p>
                        <p>Pris: <span class="text-gray-500 font-normal">29,00 kr</span></p>
                        <p>Antall: <span class="text-gray-500 font-normal">3</span></p>
                        <p>Allergi: <span class="text-gray-500 font-normal">Melk, egg og nøtter</span></p>
                        <p>Kategori: <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Kategori 1</span></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
</div>
</body>
</html>
