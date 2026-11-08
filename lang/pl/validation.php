<?php

return [
    'required' => 'Pole :attribute jest wymagane.',
    'email' => 'Pole :attribute musi być poprawnym adresem e-mail.',
    'unique' => 'Taka wartość pola :attribute jest już zajęta.',
    'confirmed' => 'Potwierdzenie pola :attribute nie zgadza się.',
    'regex' => 'Pole :attribute ma nieprawidłowy format.',
    'numeric' => 'Pole :attribute musi być liczbą.',
    'integer' => 'Pole :attribute musi być liczbą całkowitą.',
    'string' => 'Pole :attribute musi być tekstem.',
    'in' => 'Wybrana wartość pola :attribute jest nieprawidłowa.',
    'min' => [
        'string' => 'Pole :attribute musi mieć co najmniej :min znaków.',
        'numeric' => 'Pole :attribute musi wynosić co najmniej :min.',
    ],
    'max' => [
        'string' => 'Pole :attribute może mieć maksymalnie :max znaków.',
    ],

    'attributes' => [
        'name' => 'imię',
        'email' => 'e-mail',
        'password' => 'hasło',
        'phone' => 'telefon',
        'role' => 'rola',
        'description' => 'opis',
        'price' => 'cena',
        'stock' => 'ilość',
        'quantity' => 'ilość',
    ],
];