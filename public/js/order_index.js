// |--------------------------------------------------------------------------
// | Order's Index Page
// |--------------------------------------------------------------------------

    // All Tables
    const allButton =  document.querySelector('#allButton');
    const allContent =  document.querySelector('#allContent');

    // Uncompleted Orders
    const uncompletedButton =  document.querySelector('#uncompletedButton');
    const uncompletedContent =  document.querySelector('#uncompletedContent');

    // Completed Orders
    const completedButton =  document.querySelector('#completedButton');
    const completedContent =  document.querySelector('#completedContent');


    // All Tables
    allButton.addEventListener('click',() => {
        if (allContent.classList.contains('hidden')){

            allContent.classList.remove('hidden');
            uncompletedContent.classList.add('hidden');
            completedContent.classList.add('hidden');

            allButton.classList.add('bg-green-800');
            allButton.classList.add('text-white');
            allButton.classList.remove('text-green-800');

            uncompletedButton.classList.remove('bg-green-800');
            uncompletedButton.classList.remove('text-white');
            uncompletedButton.classList.add('text-green-800');

            completedButton.classList.remove('bg-green-800');
            completedButton.classList.remove('text-white');
            completedButton.classList.add('text-green-800');

        }
    })

    // Uncompleted Orders
    uncompletedButton.addEventListener('click',() => {
        if (uncompletedContent.classList.contains('hidden')){

            allContent.classList.add('hidden');
            uncompletedContent.classList.remove('hidden');
            completedContent.classList.add('hidden');
            
            allButton.classList.remove('bg-green-800');
            allButton.classList.remove('text-white');
            allButton.classList.add('text-green-800');

            uncompletedButton.classList.add('bg-green-800');
            uncompletedButton.classList.add('text-white');
            uncompletedButton.classList.remove('text-green-800');

            completedButton.classList.remove('bg-green-800');
            completedButton.classList.remove('text-white');
            completedButton.classList.add('text-green-800');
        }
    })

    // Completed Orders
    completedButton.addEventListener('click',() => {
        if (completedContent.classList.contains('hidden')){

            allContent.classList.add('hidden');
            uncompletedContent.classList.add('hidden');
            completedContent.classList.remove('hidden');

            allButton.classList.remove('bg-green-800');
            allButton.classList.remove('text-white');
            allButton.classList.add('text-green-800');

            uncompletedButton.classList.remove('bg-green-800');
            uncompletedButton.classList.remove('text-white');
            uncompletedButton.classList.add('text-green-800');

            completedButton.classList.add('bg-green-800');
            completedButton.classList.add('text-white');
            completedButton.classList.remove('text-green-800');
        }
    })