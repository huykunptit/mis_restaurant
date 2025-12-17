
// |--------------------------------------------------------------------------
// | Customer's Home Page
// |--------------------------------------------------------------------------

    // Foods
    const foodsButton =  document.querySelector('#foodsButton');
    const foodsContent =  document.querySelector('#foodsContent');

    foodsButton.addEventListener('click',() => {
        if (foodsContent.classList.contains('hidden')){

            foodsContent.classList.remove('hidden');
            drinksContent.classList.add('hidden');

        }
    })

    // Drinks
    const drinksButton =  document.querySelector('#drinksButton');
    const drinksContent =  document.querySelector('#drinksContent');

    drinksButton.addEventListener('click',() => {
        if (drinksContent.classList.contains('hidden')){

            drinksContent.classList.remove('hidden');
            foodsContent.classList.add('hidden');

        }
    })