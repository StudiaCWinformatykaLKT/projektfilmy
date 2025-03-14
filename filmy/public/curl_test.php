<?php

$apiKey =
$movieId = 13;

$url = 'https://api.themoviedb.org/3/movie/' . $movieId . '?api_key=' . $apiKey;

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); // Recommended for HTTPS

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo 'cURL Error: ' . curl_error($curl);
} else {
    $movieData = json_decode($response, true); // Decode JSON response into an associative array

    if ($movieData) {
        // Display selected movie information
        echo '<h2>' . $movieData['title'] . '</h2>';
        echo '<p><strong>Overview:</strong> ' . $movieData['overview'] . '</p>';
        echo '<p><strong>Release Date:</strong> ' . $movieData['release_date'] . '</p>';
        echo '<p><strong>Runtime:</strong> ' . $movieData['runtime'] . ' minutes</p>';
        echo '<p><strong>Genres:</strong> ';
        if (isset($movieData['genres']) && is_array($movieData['genres'])) {
            $genres = array_column($movieData['genres'], 'name');
            echo implode(', ', $genres);
        }
        echo '</p>';
        echo '<p><strong>Rating:</strong> ' . $movieData['vote_average'] . '</p>';
        echo '<p><strong>Production Companies:</strong> ';
        if (isset($movieData['production_companies']) && is_array($movieData['production_companies'])){
            $productionCompanies = array_column($movieData['production_companies'], 'name');
            echo implode(', ', $productionCompanies);
        }
        echo '</p>';

        if (isset($movieData['poster_path'])){
            $poster_url = 'https://image.tmdb.org/t/p/w500' . $movieData['poster_path'];
            echo '<img src="' . $poster_url . '" alt="Poster">';
        }

        // Add more information as needed
    } else {
        echo 'Failed to decode JSON response.';
    }
}

curl_close($curl);

?>
