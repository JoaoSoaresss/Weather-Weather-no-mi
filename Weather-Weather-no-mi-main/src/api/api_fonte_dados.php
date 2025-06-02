<?php
header('Content-Type: application/json');

function checarStatus($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);

    curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return "offline";
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($httpCode >= 200 && $httpCode < 400) ? "online" : "offline";
}

$fontes = [
    [
        "nome" => "OpenWeatherMap",
        "base_url" => "https://api.openweathermap.org/data/2.5/weather?q=London&appid=16fa71708935f766694b36e5e61e13dc"
    ],
    [
        "nome" => "WeatherAPI",
        "base_url" => "https://api.weatherapi.com/v1/current.json?q=London&key=c249b985c680458fb95152511252205"
    ],
    [
        "nome" => "Open Meteo Archive",
        "base_url" => "https://archive-api.open-meteo.com/v1/archive?latitude=52.52&longitude=13.41&start_date=2024-05-01&end_date=2024-05-02&daily=temperature_2m_max"
    ]
];

foreach ($fontes as &$fonte) {
    $fonte["status"] = checarStatus($fonte["base_url"]);
}

echo json_encode($fontes);
