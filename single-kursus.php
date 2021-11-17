

<?php
get_header();
?>

<style>
    p, h3{
        font-family: Galvji;
    }
    h4, p, h2 {
        color: black;
    }

    h3 {
        font-size: 24px;
    }

    p{
        font-size: 15px;
    }

 

    .book {
        color: black;
    }

    .book:focus {
        background-image: none;
    background-color: #FAD8E8;
    }

    #kasse1 {
        background-color: #F2EFEB;
    }

    #kasse2, #kasse5, #kasse6 {
        background-color: #C4D2C7;
    }

    #kasse3 {
        background-color: #EBE0D8;
    }

    #kasse3 {
        background-color: #EBE0D8;
    }

    .enkeltKursus {
        display: grid;
        grid-template-columns: 1fr 1fr;
    
    }

    #kasse1{
        grid-column: 1/2;
    grid-row: 1;
    padding: 6rem;
    }

    #kasse2{
        grid-column: 2/3;
    grid-row: 1;
    padding: 6rem;
    }

    #kasse3, #kasse4, #kasse5, #kasse6 {
        padding: 6rem;
    }

    #kasse7 {
        grid-column: 1/3;
        background-color: #F2EFEB;
    }

    .span {
        font-weight: bold;
    }

    .skema {
        padding-left: 15rem;
        padding-right: 15rem;
    }

    @media(max-width: 500px) {

.enkeltKursus {
    /* padding: 4vw; */
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: repeat(7, 1fr);
    
}

#kasse1{
        grid-column: 1;
    grid-row: 1;
    padding: 6vw;
    }

    #kasse2{
        grid-column: 1;
    grid-row: 2;
    padding: 6vw;
    }

    #kasse3{
        grid-column: 1;
    grid-row: 3;
    padding: 6vw;
    }

    #kasse4{
        grid-column: 1;
    grid-row: 4;
    padding: 6vw;
    }

    #kasse5{
        grid-column: 1;
    grid-row: 5;
    padding: 6vw;
    }
    #kasse6{
        grid-column: 1;
    grid-row: 6;
    padding: 6vw;
    }

    #kasse7{
        grid-column: 1;
    grid-row: 7;
    padding: 6vw;
    }

    .skema {
        padding: 0;
    }
}

</style>

    <section id="primary" class="content-area">
        <main id="single" class="site-main">
        <button class="luk">Tilbage</button>
        <section class="indhold">
            <article class="enkeltKursus">
                
                <div id="kasse1">
                <h2 class="navn"></h2>
                <h3 class="kategori"></h3>
                <p class="kortbeskrivelse"></p>
                </div>
                <div id="kasse2">
                <p class="klassetrin"> <span class="span">Henvendelse: </span></p> 
                <p class="varighed"><span class="span">Varighed: </span></p>
                <p class="deltagere"><span class="span">Antal deltagere: </span></p>
                <h3>Indhold:</h3>
                <p class="indhold1"></p>
                <p class="pris"></p>
                <button class="book">BOOK HER</button>
                </div>
                <div id="kasse3">
                <h3 class="overskrift1"></h3>
                <p class="beskrivelse1"></p>
                </div>
                <div id="kasse4">
                <h3 class="overskrift2"></h3>
                <p class="beskrivelse2"></p>
                </div>
                <div id="kasse5">
                <h3 class="overskrift3"></h3>
                <p class="beskrivelse3"></p>
                </div>
                <div id="kasse6">
                <h3 class="overskrift4"></h3>
                <p class="beskrivelse4"></p>
                </div>
                <div id="kasse7">
                <!-- billede af kalender -->
                <img class ="skema" src="http://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/wp-content/uploads/2021/11/skema.png" alt="">
                </div>
            </article>
        </section>
    </main>

    <script>
        //find parametre (variabler) i url'en
       // let urlParams = new URLSearchParams(window.location.search);
        //returner værdien for variablen "id" 
       // let id = urlParams.get("id");
        let kursus;
        document.addEventListener("DOMContentLoaded", getJson);

        async function getJson() {
            console.log("id er", <?php echo get_the_ID() ?>);
            //hent en enkelt ret udfra id'et
            let jsonData = await fetch('https://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/wp-json/wp/v2/kursus/<?php echo get_the_ID() ?>');
            kursus = await jsonData.json();
            console.log("kursus", kursus);
            visKursus();
            
        }
        //vis data om retten
        function visKursus() {
            document.querySelector(".navn").innerHTML = kursus.navn;
            document.querySelector(".kategori").innerHTML = kursus.kategori;
            // kasse1
            document.querySelector(".kortbeskrivelse").innerHTML = kursus.beskrivelse;
            
            document.querySelector(".klassetrin").innerHTML += kursus.klassetrin;
            document.querySelector(".varighed").innerHTML += kursus.varighed;
            document.querySelector(".deltagere").innerHTML += kursus.antal_deltagere;
            document.querySelector(".indhold1").innerHTML += kursus.indhold;
            document.querySelector(".pris").innerHTML = kursus.pris;
            // kasse2
            // kasse3
            document.querySelector(".overskrift1").innerHTML = kursus.overskrift_1;
            document.querySelector(".beskrivelse1").innerHTML = kursus.beskrivelse_1;
            // kasse4
            document.querySelector(".overskrift2").innerHTML = kursus.overskrift_2;
            document.querySelector(".beskrivelse2").innerHTML = kursus.beskrivelse_2;
            // kasse5
            if (kursus.overskrift_3 != ""){
                document.querySelector(".overskrift3").innerHTML = kursus.overskrift_;
            document.querySelector(".beskrivelse3").innerHTML = kursus.beskrivelse_3;
            
            }
            else {document.querySelector("#kasse5").style.display = "none"}


            // book her knap
            document.querySelector(".book").addEventListener("click", () => {
                location.href = "https://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/booking/";
             })


            document.querySelector(".overskrift3").innerHTML = kursus.overskrift_3;
            document.querySelector(".beskrivelse3").innerHTML = kursus.beskrivelse_3;


            // kasse6
            if (kursus.overskrift_4 != ""){
                document.querySelector(".overskrift4").innerHTML = kursus.overskrift_4;
            document.querySelector(".beskrivelse4").innerHTML = kursus.beskrivelse_4;
            
            }
            else {document.querySelector("#kasse6").style.display = "none"}

            document.querySelector(".overskrift4").innerHTML = kursus.overskrift_4;
            document.querySelector(".beskrivelse4").innerHTML = kursus.beskrivelse_4;

            // book her knap
            document.querySelector(".book").addEventListener("click", () => {
                location.href = "https://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/booking/";
             })
        }


        document.querySelector(".luk").addEventListener("click", () => {
            //link tilbage til den foregående side på "luk" knappen
            history.back();
        })
    </script>

        
    </section><!-- #primary -->

<?php

get_footer(); ?>
<?php get_sidebar();?>


