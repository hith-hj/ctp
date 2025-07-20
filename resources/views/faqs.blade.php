<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Click To Pick | FAQS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Click To Pick" name="keywords">
    <meta content="Click To Pick" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <style>
        url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');


        *, *::before, *::after{
            box-sizing: border-box;
        }

        body{
            font-family: 'Lato', sans-serif;
            background-color: #ded2ff;
            color: #42225e;
        }

        h1{
            margin: 50px 0 30px;
            text-align: center;
        }

        .faq-container{
            max-width: 600px;
            margin: 0 auto;
        }

        .faq{
            background-color: transparent;
            border: 1px solid #A555EC;
            border-radius: 10px;
            padding: 30px;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
            transition: all .4s ease;
        }

        .faq.active{
            background-color: #FFF8C9;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .faq-title{
            margin: 0 35px 0 0;
        }

        .faq-text{
            display: none;
            margin: 30px 0 0;
        }

        .faq.active .faq-text{
            display: block;
        }

        .faq-toggle {
            background-color: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            position: absolute;
            top: 30px;
            right: 30px;
            height: 30px;
            width: 30px;
        }

        .chevron, .close{
            width: 12px;
            height:12px;
        }

        .faq-toggle .close{
            display: none;
        }

        .faq.active .faq-toggle .close{
            display: block;
        }

        .faq.active .faq-toggle .chevron{
            display: none;
        }

        .faq.active .faq-toggle{
            background-color: #A555EC;
            border-radius: 50%;
            color:#ffffd9;
        }
    </style>
</head>
<body>
    
<h1>Frequently Asked Questions</h1>
<div class='faq-container'>
    <div class="faq">
        <h4 class="faq-title"><a href="/" class="link text-underline">{{__('home')}}</a></h4>
    </div>
    <div class="faq">
        <h3 class="faq-title">Lorem fistrum tiene musho peligro condemor?</h3>
        <p class="faq-text">No te digo trigo por no llamarte Rodrigor ese pedazo de caballo blanco caballo negroorl a peich.</p>
        <button class='faq-toggle'>
            <svg class="chevron w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 8">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 5.326 5.7a.909.909 0 0 0 1.348 0L13 1"/>
            </svg>

            <svg class="close w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    <div class="faq">
        <h3 class="faq-title">Por la gloria de mi madre va usté muy cargadoo?</h3>
        <p class="faq-text">Tiene musho peligro te voy a borrar el cerito torpedo torpedo de la pradera sexuarl.</p>
        <button class='faq-toggle'>
            <svg class="chevron w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 8">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 5.326 5.7a.909.909 0 0 0 1.348 0L13 1"/>
            </svg>

            <svg class="close w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    <div class="faq ">
        <h3 class="faq-title">Mamaar caballo blanco caballo negroorl tiene musho peligro?</h3>
        <p class="faq-text">Fistro ese pedazo de pupita a gramenawer amatomaa ese hombree va usté muy cargadoo pupita.</p>
        <button class='faq-toggle'>
            <svg class="chevron w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 8">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 5.326 5.7a.909.909 0 0 0 1.348 0L13 1"/>
            </svg>

            <svg class="close w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    <div class="faq ">
        <h3 class="faq-title">La caidita te va a hasé pupitaa?</h3>
        <p class="faq-text">Caballo blanco caballo negroorl mamaar. Ese pedazo de al ataquerl te va a hasé pupitaa mamaar llevame al sircoo pupita ese pedazo de me cago en tus muelas mamaar.</p>
        <button class='faq-toggle'>
            <svg class="chevron w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 8">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 5.326 5.7a.909.909 0 0 0 1.348 0L13 1"/>
            </svg>

            <svg class="close w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    <div class="faq ">
        <h3 class="faq-title">Lorem fistrum tiene musho peligro condemor?</h3>
        <p class="faq-text">Al ataquerl quietooor no te digo trigo por no llamarte Rodrigor hasta luego Lucas mamaar jarl la caidita por la gloria de mi madre no te digo trigo por no llamarte Rodrigor. </p>
        <button class='faq-toggle'>
            <svg class="chevron w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 8">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 5.326 5.7a.909.909 0 0 0 1.348 0L13 1"/>
            </svg>

            <svg class="close w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
</div>
<script>
    const buttons = document.querySelectorAll('.faq-toggle');


    buttons.forEach(button =>{
        button.addEventListener('click', () =>{
            button.parentNode.classList.toggle('active');
        })
    })

</script>
</body>
</html>
