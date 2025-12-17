// |--------------------------------------------------------------------------
// | Order's Show Page
// |--------------------------------------------------------------------------

    // All Tables
    const allButton =  document.querySelector('#allButton');
    const allContent =  document.querySelector('#allContent');

    allButton.addEventListener('click',() => {
        if (allContent.classList.contains('hidden')){

            allContent.classList.remove('hidden');
            uncompletedContent.classList.add('hidden');
            completedContent.classList.add('hidden');

        }
    })

    // Uncompleted Orders
    const uncompletedButton =  document.querySelector('#uncompletedButton');
    const uncompletedContent =  document.querySelector('#uncompletedContent');

    uncompletedButton.addEventListener('click',() => {
        if (uncompletedContent.classList.contains('hidden')){

            allContent.classList.add('hidden');
            uncompletedContent.classList.remove('hidden');
            completedContent.classList.add('hidden');

        }
    })

    // Completed Orders
    const completedButton =  document.querySelector('#completedButton');
    const completedContent =  document.querySelector('#completedContent');

    completedButton.addEventListener('click',() => {
        if (completedContent.classList.contains('hidden')){

            allContent.classList.add('hidden');
            uncompletedContent.classList.add('hidden');
            completedContent.classList.remove('hidden');

        }
    })