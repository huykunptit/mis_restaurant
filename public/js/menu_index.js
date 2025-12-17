
// |--------------------------------------------------------------------------
// | Menu's Index Page
// |--------------------------------------------------------------------------

    // Foods
    const foodsButton =  document.querySelector('#foodsButton');
    const foodsContent =  document.querySelector('#foodsContent');

    // Drinks
    const drinksButton =  document.querySelector('#drinksButton');
    const drinksContent =  document.querySelector('#drinksContent');


    // Foods
    foodsButton.addEventListener('click',() => {
        if (foodsContent.classList.contains('hidden')){

            foodsContent.classList.remove('hidden');
            drinksContent.classList.add('hidden');

            foodsButton.classList.add('bg-green-800');
            foodsButton.classList.add('text-white');
            foodsButton.classList.remove('text-green-800');

            drinksButton.classList.remove('bg-green-800');
            drinksButton.classList.remove('text-white');
            drinksButton.classList.add('text-green-800');

        }
    })

    // Drinks
    drinksButton.addEventListener('click',() => {
        if (drinksContent.classList.contains('hidden')){

            foodsContent.classList.add('hidden');
            drinksContent.classList.remove('hidden');

            foodsButton.classList.remove('bg-green-800');
            foodsButton.classList.remove('text-white');
            foodsButton.classList.add('text-green-800');

            drinksButton.classList.add('bg-green-800');
            drinksButton.classList.add('text-white');
            drinksButton.classList.remove('text-green-800');

        }
    })