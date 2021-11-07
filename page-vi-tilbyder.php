<?php
add_action( 'wp_enqueue_scripts', 'enqueue_important_files' );
function enqueue_important_files() {
/*hent parent stylesheet i parenttemaets mappe*/
wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
?>

<?php

get_headers();
?>
<template>
    <article class="kasse_1">
        <p class="beskrivelse_1"></p>
    </article>

</template> 

<section id="primary" class="content-area">
    <main id="main" class="site-main">
    
    <section id="kursus_indhold"></section>
    </main>

<script>
        let kurser = [];
        const side = document.querySelector("#kursus_indhold");
        const indhold = document.querySelector("template");
        document.addEventListener("DOMContentLoaded", start);

        function start() {
            getJson();
        }


    const url = "http://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/wp-json/wp/v2/vi-tilbyder?per_page=100";
    async function getJson () {
        let response = await fetch(url);
        kurser = await response.json();
        visKurser();
        console.log(Kurser);
    }

    function visKurser () {
        console.log(kurser);
        kurser.forEach(kursus => {
            const klon = indhold.cloneNode(true).content;
            klon.querySelector(".beskrivelse_1").textContent = kursus.beskrivelse;

            side.appendChild(klon);

        })
    }


    </script>


